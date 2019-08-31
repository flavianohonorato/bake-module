<?php

namespace Wicool\BakeModule\Providers;

use Wicool\BakeModule\BakeModuleCommand;
use Illuminate\Support\ServiceProvider;

class BakeModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BakeModuleCommand::class
            ]);
        }
    }
}
