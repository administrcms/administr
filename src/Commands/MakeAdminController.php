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