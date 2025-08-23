<?php

namespace Modules\Core\Core\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class UserTimeStampsProvider extends ServiceProvider
{
	public function boot(Router $router)
	{
		Blueprint::macro('userTimeStamps', function() {
            $this->timestamps();
            $this->unsignedBigInteger('created_by')->nullable()->constrained('acl_users')->nullOnDelete();
            $this->unsignedBigInteger('updated_by')->nullable()->constrained('acl_users')->nullOnDelete();
            $this->unsignedBigInteger('deleted_by')->nullable()->constrained('acl_users')->nullOnDelete();
        });
	}
}