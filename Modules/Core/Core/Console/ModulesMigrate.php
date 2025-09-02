<?php

namespace Modules\Core\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use PDO;
use Throwable;

class ModulesMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:migrate {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates databases if missing, migrates all modules, respecting load order and multiple DB connections.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting module setup and migration...');

        try {
            $modules = Module::getOrdered();
            $connections = $this->getAllModuleConnections($modules);
            
            // 1. Ensure all required databases exist before doing anything else.
            $this->ensureDatabasesExist($connections);

            // 2. If --clear is used, wipe tables from all relevant databases.
            if ($this->option('clear')) {
                $this->clearAllModuleTables($connections);
            }

            // 3. Run the migrations.
            $this->runMigrationsForAllModules($modules);

            $this->info('All module migrations completed successfully.');
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('An error occurred during module migration: ' . $e->getMessage());
            $this->line('Halting execution.');
            return Command::FAILURE;
        }
    }

    /**
     * Loops through connections, checks if the database exists, and creates it if not.
     *
     * @param array $connections
     * @return void
     */
    protected function ensureDatabasesExist(array $connections): void
    {
        $this->line('');
        $this->info('Checking for database existence...');

        foreach ($connections as $connectionName) {
            try {
                $config = config("database.connections.{$connectionName}");

                if (!$config || $config['driver'] !== 'mysql') {
                    $this->line("Skipping database creation check for non-mysql connection: <fg=yellow>{$connectionName}</>");
                    continue;
                }

                $dbName = $config['database'];
                $this->line("Checking database: <fg=yellow>{$dbName}</> on connection '{$connectionName}'");

                // Connect to MySQL server without selecting a database
                $pdo = new PDO(
                    "mysql:host={$config['host']};port={$config['port']}",
                    $config['username'],
                    $config['password']
                );

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . $pdo->quote($dbName));
                
                if ($stmt->fetch()) {
                    $this->info("Database '{$dbName}' already exists.");
                } else {
                    $this->warn("Database '{$dbName}' does not exist. Creating it...");
                    $charset = $config['charset'] ?? 'utf8mb4';
                    $collation = $config['collation'] ?? 'utf8mb4_unicode_ci';
                    $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET `{$charset}` COLLATE `{$collation}`");
                    $this->info("Database '{$dbName}' created successfully.");
                }
            } catch (Throwable $e) {
                $this->error("Could not check or create database for connection '{$connectionName}'. Please check credentials and permissions.");
                throw $e; // Re-throw to halt the command
            }
        }
    }

    /**
     * Run migrations for all provided modules.
     *
     * @param array $modules
     * @return void
     */
    protected function runMigrationsForAllModules(array $modules): void
    {
        foreach ($modules as $module) {
            $this->line('');
            $this->info("Processing module: <fg=cyan;options=bold>{$module->getName()}</>");

            $path = $module->getPath() . '/Database/Migrations';
            if (!is_dir($path)) continue;

            $files = collect(scandir($path))->filter(fn ($file) => Str::endsWith($file, '.php'));

            if ($files->isEmpty()) {
                $this->line("No migrations found for {$module->getName()}.");
                continue;
            }

            foreach ($files as $file) {
                $this->processSingleMigrationFile($path . DIRECTORY_SEPARATOR . $file);
            }
        }
    }

    /**
     * Process and run a single migration file using Laravel's own migrate command.
     *
     * @param string $file
     * @return void
     */
    protected function processSingleMigrationFile(string $file): void
    {
        $migrationName = Str::before(basename($file), '.php');
        $connection = $this->getMigrationConnection($file);
        
        $this->ensureMigrationsTableExists($connection);

        if (DB::connection($connection)->table('migrations')->where('migration', $migrationName)->exists()) {
            $this->line("Skipping already migrated file: <fg=yellow>{$migrationName}</>");
            return;
        }

        $this->line("Running migration: <fg=yellow>{$migrationName}</> on connection '{$connection}'...");
        $relativePath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file);

        $this->call('migrate', [
            '--database' => $connection,
            '--path' => $relativePath,
            '--force' => true,
        ]);
    }

     /**
     * Wipes all tables from all databases used by the modules using a direct PDO connection.
     * This method is more reliable than using the Schema builder for dropping all tables.
     *
     * @param array $connections
     * @return void
     */
    protected function clearAllModuleTables(array $connections): void
    {
        $this->line('');
        $this->warn('(--clear) Wiping all module tables using direct PDO connection...');
        
        foreach ($connections as $connectionName) {
            $this->line("Clearing tables for connection: <fg=yellow>{$connectionName}</>");

            try {
                // Get the database configuration for the current connection
                $config = config("database.connections.{$connectionName}");
                if (!$config) {
                    $this->error("Configuration for connection '{$connectionName}' not found.");
                    continue;
                }

                // Establish a direct PDO connection
                $pdo = new \PDO(
                    "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']}",
                    $config['username'],
                    $config['password']
                );
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                // Disable foreign key checks
                $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

                // Get all tables
                $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

                if (empty($tables)) {
                    $this->info("No tables found to wipe in '{$config['database']}'.");
                } else {
                    // Drop all tables
                    foreach ($tables as $table) {
                        $pdo->exec("DROP TABLE `{$table}`;");
						$this->info("Table `{$table}` dropped.");
                    }
                    $this->info("Successfully dropped all tables on connection '{$connectionName}'.");
                }

                // Re-enable foreign key checks
                $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');

            } catch (\Throwable $e) {
                $dbName = $config['database'] ?? $connectionName;
                $this->error("Could not drop tables for '{$dbName}': " . $e->getMessage());
                 // In case of an error, it's safer to leave FK checks disabled, 
                 // as the connection will close and the setting will reset for the next session.
            }
        }
    }
    
    /**
     * Ensures the 'migrations' table exists on a given database connection.
     *
     * @param string $connectionName
     * @return void
     */
    protected function ensureMigrationsTableExists(string $connectionName): void
    {
        if (!Schema::connection($connectionName)->hasTable('migrations')) {
            $this->warn("Migrations table not found on '{$connectionName}'. Creating it now.");
            Schema::connection($connectionName)->create('migrations', function (Blueprint $table) {
                $table->id();
                $table->string('migration');
                $table->integer('batch');
            });
        }
    }

    /**
     * Parses a migration file to determine its specified database connection.
     *
     * @param string $filePath
     * @return string
     */
    protected function getMigrationConnection(string $filePath): string
    {
        if (preg_match("/protected\s+\\\$connection\s*=\s*['\"]([^'\"]+)['\"]/", file_get_contents($filePath), $matches)) {
            return $matches[1];
        }
        return config('database.default');
    }

    /**
     * Gathers a unique list of all database connections used across all modules.
     *
     * @param array $modules
     * @return array
     */
    protected function getAllModuleConnections(array $modules): array
    {
        $connections = [];
        foreach ($modules as $module) {
            $path = $module->getPath() . '/Database/Migrations';
            if (!is_dir($path)) continue;

            $files = collect(scandir($path))->filter(fn ($file) => Str::endsWith($file, '.php'));
            foreach ($files as $file) {
                $connections[] = $this->getMigrationConnection($path . DIRECTORY_SEPARATOR . $file);
            }
        }
        return array_unique($connections);
    }
}


