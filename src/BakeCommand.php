<?php

namespace Wicool\BakeModule;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bake:module {name : Class (plural) for example Posts}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a Laravel module based skeleton with name passed in parameter';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $name = $this->argument('name');

        if (!file_exists(base_path("/modules")))
            File::makeDirectory(base_path('/modules'),0777,true);
            $this->info('O diretório modules foi criado na raiz do seu projeto.');

        $this->model($name);
        $this->controller($name);
        $this->route($name);
        $this->facade($name);
        $this->interface($name);
        $this->provider($name);
        $this->service($name);

        $this->output->writeln([
            'Adicione o service provider em config/app.php',
            'Modules\\' . studly_case($name) . '\Providers\\' . studly_case($name) .
            'ServiceProvider::class,'
        ]);
    }

    /**
     * @param $name
     * @return bool|string
     */
    protected function getStub($name)
    {
        $from = __DIR__ . 'stubs' . DIRECTORY_SEPARATOR;
        return file_get_contents($from . $name . '.stub');
    }

    /**
     * @param $name
     */
    protected function model($name)
    {
        $singular_name = Str::singular($name);

        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingular}}',
                '{{modelNameTable}}',
            ],
            [
                $name,
                $singular_name,
                strtolower(Str::slug($name))
            ],
            $this->getStub('Model')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Models")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Models/{$singular_name}.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function controller($name)
    {
        $singular_name = Str::singular($name);
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingular}}',
            ],
            [
                $name,
                $singular_name
            ],
            $this->getStub('Controller')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Http/Controllers")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Http/Controllers/{$name}Controller.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function route($name)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameRoute}}',
            ],
            [
                $name,
                Str::plural(strtolower(Str::slug($name)))
            ],
            $this->getStub('Route')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Routes")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Routes/api.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function facade($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Facade')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Facades")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Facades/{$name}.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function interface($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Interface')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Interfaces")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Interfaces/{$name}Interface.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function provider($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('ServiceProvider')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Providers")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Providers/{$name}ServiceProvider.php"),
            $template
        );
    }

    /**
     * @param $name
     */
    protected function service($name)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Service')
        );

        if (!file_exists($path = base_path("/modules/{$name}/Services")))
            mkdir($path, 0777, true);

        file_put_contents(
            base_path("/modules/{$name}/Services/{$name}Service.php"),
            $template
        );
    }
}
