<?php

namespace Exa\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:module')]
class MakeModuleCommand extends Command
{
    protected $signature = 'make:module
                            {module : The module name}';

    protected $description = 'Creates a new module for your application (disabled by default)';

    public function handle(): void
    {
        $moduleName = Str::studly($this->argument('module'));
        $modulePath = base_path("modules/$moduleName");
        mkdir($modulePath, 0755, true);

        foreach ($this->moduleStructure() as $directory) {
            $path = "$modulePath/$directory";
            mkdir($path, 0755, true);
            $this->addGitKeepFile($path);
        }

        $this->addModuleRoutes($modulePath);

        $this->info("Module '{$moduleName}' created successfully!");
        $this->warn('You need to enable this module when you want to by adding it to config/modules.php file');
    }

    private function moduleStructure(): array
    {
        return [
            'Actions', 'Commands', 'Controllers', 'DTOs', 'Events', 'Listeners', 'Models',
            'Requests', 'Resources', 'Responses', 'Support', 'Traits',
        ];
    }

    private function addModuleRoutes(string $modulePath): void
    {
        $path = "$modulePath/Routes";
        mkdir($path, 0755, true);

        $commonRoutingPath = base_path('modules/Common/Routes');
        $routingFile = 'v1.php';

        copy("$commonRoutingPath/$routingFile", "$path/$routingFile");
    }

    private function addGitKeepFile(string $path): void
    {
        $gitKeep = fopen("$path/.gitkeep", 'w');
        fwrite($gitKeep, '');
        fclose($gitKeep);
    }
}
