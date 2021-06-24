<?php

namespace Marshmallow\NovaUserGroups\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class GeneratePolicyCommand extends GeneratorCommand
{
    public $signature = 'user-groups:policy {name}';

    public $description = 'This command will generate policies for every nova resource in you Nova folder';

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return __DIR__ . '/../../resources/stubs/Policy.php.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model to which the repository will be generated'],
        ];
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Policies';
    }
}
