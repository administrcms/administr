<?php

namespace Administr\Commands;


use Illuminate\Console\GeneratorCommand;

class MakeAdminController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'administr:controller {name}';

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

        $dummyRoute = str_plural(
            strtolower( $noControllerName )
        );
        $stub = str_replace('dummyroute', $dummyRoute, $stub);

        $appNamespace = $this->getLaravel()->getNamespace();

        $dummyModel = str_singular($noControllerName);
        $dummyModelNamespaced = $appNamespace . 'Models\\' . $dummyModel;
        $stub = str_replace('DummyModel', $dummyModel, $stub);
        $stub = str_replace('DummyModelNamespaced', $dummyModelNamespaced, $stub);

        $dummyForm = str_singular($noControllerName) . 'Form';
        $dummyFormNamespaced = $appNamespace . 'Http\\Forms\\' . $dummyForm;
        $stub = str_replace('DummyFormNamespaced', $dummyFormNamespaced, $stub);

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
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
        return $rootNamespace.'\Http\Controllers\Admin';
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
}