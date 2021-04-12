<?php

namespace Administr\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'administr:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin scaffold (controller, model, form).';

    protected $type = 'Admin scaffold';

    public function handle()
    {
        $name = trim( $this->argument('name') );
        $nameSingular = Str::singular($name);

        $status = 0;

        $controllerCmdArgs = [
            'name'  => "{$name}Controller",
        ];

        if($this->option('translated')) {
            $controllerCmdArgs['--translated'] = true;
        }

        $status = $this->call('administr:controller', $controllerCmdArgs);

        $status = $this->call('administr:form', [
            'name'  => "{$nameSingular}Form",
        ]);

        $modelCmdArgs = [
            'name'  => $nameSingular,
        ];

        if($this->option('translated')) {
            $modelCmdArgs['--translated'] = true;
        }

        $status = $this->call('administr:model', $modelCmdArgs);

        $status = $this->call('administr:listview', [
            'name'  => "{$name}ListView",
        ]);

        $status = $this->call('make:seed', [
            'name'  => "{$name}Seeder",
        ]);

        $table = Str::plural( Str::snake( class_basename($name) ) );
        $status = $this->call('make:migration', [
            'name'      => "create_{$table}_table",
            '--create'  => $table,
        ]);

        if($status !== 0) {
            $this->error('Some of the commands were not executed successfuly.');
        }

        $this->info('Admin scaffold generated!');
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