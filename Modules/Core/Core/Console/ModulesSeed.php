<?php

namespace Modules\Core\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Throwable;

class ModulesSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:seed {--clear : Clear (truncate) all module tables before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds all modules in their specified priority order.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting module seeding process...');

        try {
            // 1. If --clear is used, clear (truncate) tables from all relevant databases.
            if ($this->option('clear')) {
                $connections = $this->getAllModuleConnections();
                $this->clearAllModuleTables($connections);
            }

            // 2. Run the seeders for all modules.
            $modules = Module::getOrdered();
            $this->runSeedersForAllModules($modules);

            $this->info('All module seeding completed successfully.');
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('An error occurred during module seeding: ' . $e->getMessage());
            $this->line('Halting execution.');
            return Command::FAILURE;
        }
    }

	/**
     * Run database seeders for all provided modules, finding the seeder's
     * namespace from the module's composer.json file.
     *
     * @param \Nwidart\Modules\Module[] $modules
     * @return void
     */
    protected function runSeedersForAllModules(array $modules): void
    {
        foreach ($modules as $module) {
            $this->line('');
            $this->info("Processing module: <fg=cyan;options=bold>{$module->getName()}</>");

            $seederClass = null;
            $seederNamespace = null;

            // Find the seeder namespace from the module's composer.json
            $composerJsonPath = $module->getPath() . '/composer.json';
            if (file_exists($composerJsonPath)) {
                $composerConfig = json_decode(file_get_contents($composerJsonPath), true);
                $psr4 = $composerConfig['autoload']['psr-4'] ?? [];
                
                // Find the namespace that points to the Seeders directory
                foreach ($psr4 as $namespace => $path) {
                    if (str_ends_with(rtrim($path, '/'), 'Database/Seeders')) {
                        $seederNamespace = $namespace;
                        break;
                    }
                }
            }
            
            if ($seederNamespace) {
                // Construct the full class name for the main seeder
                $seederClass = rtrim($seederNamespace, '\\') . '\\' . $module->getStudlyName() . 'DatabaseSeeder';
            } else {
                $this->line("Could not determine seeder namespace from composer.json for {$module->getName()}.");
                continue;
            }

            if (class_exists($seederClass)) {
                $this->line("Running seeder: <fg=yellow>{$seederClass}</>");
                $this->call('db:seed', ['--class' => $seederClass, '--force' => true]);
            } else {
                $this->line("Seeder not found, checked for: <fg=gray>{$seederClass}</>");
            }
        }
    }


    
    /**
     * Clears (truncates) all tables in the given connections.
     *
     * @param array $connections
     * @return void
     */
    protected function clearAllModuleTables(array $connections): void
    {
        $this->line('');
        $this->warn('(--clear) Clearing all module tables...');
        
        foreach ($connections as $connectionName) {
            $config = config("database.connections.{$connectionName}");
            if (!$config || $config['driver'] !== 'mysql') {
                $this->line("Skipping table clearing for non-mysql connection: <fg=yellow>{$connectionName}</>");
                continue;
            }
            
            $this->line("Clearing tables for connection: <fg=yellow>{$connectionName}</>");

            try {
                $pdo = new \PDO(
                    "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']}",
                    $config['username'],
                    $config['password']
                );
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                $pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');
                $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

                if (empty($tables)) {
                    $this->info("No tables to clear in '{$config['database']}'.");
                } else {
                    foreach ($tables as $table) {
                        $pdo->exec("TRUNCATE TABLE `{$table}`;");
                        $this->info("Table `{$table}` cleared.");
                    }
                    $this->info("Successfully cleared all tables on connection '{$connectionName}'.");
                }
                
                $pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');

            } catch (\Throwable $e) {
                $dbName = $config['database'] ?? $connectionName;
                $this->error("Could not clear tables for '{$dbName}': " . $e->getMessage());
            }
        }
    }
    
    /**
     * Gathers a unique list of all database connections used across all modules.
     *
     * @return array
     */
    protected function getAllModuleConnections(): array
    {
        $connections = [];
        $modules = Module::all();

        foreach ($modules as $module) {
            $path = $module->getPath() . '/Database/Migrations';
            if (!is_dir($path)) continue;

            $files = collect(scandir($path))->filter(fn ($file) => Str::endsWith($file, '.php'));
            foreach ($files as $file) {
                $connections[] = $this->getMigrationConnection($path . DIRECTORY_SEPARATOR . $file);
            }
        }
        return array_unique(array_filter($connections));
    }

    /**
     * Parses a migration file to determine its specified database connection.
     *
     * @param string $filePath
     * @return string
     */
    protected function getMigrationConnection(string $filePath): string
    {
        if (preg_match("/protected\\s+\\\$connection\\s*=\\s*['\"]([^'\"]+)['\"]/", file_get_contents($filePath), $matches)) {
            return $matches[1];
        }
        return config('database.default');
    }
}
