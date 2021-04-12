<?php

namespace Administr\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeAdminController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'administr:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin controller class.';

    protected $type = 'Admin controller class';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $noControllerName = str_replace('Controller', '', $this->getNameInput());

        $dummyRoute = config('administr.prefix') . '.' . Str::plural(
            strtolower( snake_case( $noControllerName, '-' ) )
        );
        $stub = str_replace('dummyroute', $dummyRoute, $stub);

        $appNamespace = $this->getLaravel()->getNamespace();

        $dummyModel = Str::singular($noControllerName);
        $dummyModelNamespaced = $appNamespace . 'Models\\' . $dummyModel;
        $stub = str_replace('DummyModelNamespaced', $dummyModelNamespaced, $stub);
        $stub = str_replace('DummyModel', $dummyModel, $stub);

        $dummyForm = Str::singular($noControllerName) . 'Form';
        $dummyFormNamespaced = $appNamespace . 'Http\\Forms\\' . $dummyForm;
        $stub = str_replace('DummyFormNamespaced', $dummyFormNamespaced, $stub);
        $stub = str_replace('DummyForm', $dummyForm, $stub);

        $dummyListView = Str::plural($noControllerName) . 'ListView';
        $dummyListViewNamespaced = $appNamespace . 'Http\\ListViews\\' . $dummyListView;
        $stub = str_replace('DummyListViewNamespaced', $dummyListViewNamespaced, $stub);
        $stub = str_replace('DummyListView', $dummyListView, $stub);

        $viewPath = config('administr.viewPath');
        if(strlen($viewPath) > 0) {
            $viewPath .= '.';
        }

        $dummyView = $viewPath . Str::plural( Str::snake(class_basename($noControllerName), '-') );
        $stub = str_replace('dummyview', $dummyView, $stub);

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if( $this->option('translated') )
        {
            return __DIR__.'/stubs/admin_controller_translated.stub';
        }

        return __DIR__.'/stubs/admin_controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the admin controller class.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['translated', 't', InputOption::VALUE_NONE, 'Create a new admin controller that uses a translated model.'],
        ];
    }
}