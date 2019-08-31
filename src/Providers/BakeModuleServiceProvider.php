<?php

namespace Wicool\BakeModule\Providers;

use Wicool\BakeModule\BakeModuleCommand;

class BakeModuleServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BakeModuleCommand::class
            ]);
        }
    }
}
