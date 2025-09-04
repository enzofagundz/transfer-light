<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the Service and Repository for a feature.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));

        throw_if(blank($name), \InvalidArgumentException::class, 'Please provide a name for the feature.');

        $this->generateRepository($name);
        $this->generateService($name);

        $this->info("Service and Repository for {$name} created successfully.");

        return 0;
    }

    private function generateRepository($name): void
    {
        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        $repositoryInterfacePath = app_path("Repositories/Interfaces/{$name}RepositoryInterface.php");

        if (File::exists($repositoryPath) || File::exists($repositoryInterfacePath)) {
            $this->warn("{$name} Repository already exists.");

            return;
        }

        File::ensureDirectoryExists(dirname($repositoryInterfacePath));
        File::ensureDirectoryExists(dirname($repositoryPath));

        $interfaceContent = <<<PHP
        <?php

        namespace App\Repositories\Interfaces;

        interface {$name}RepositoryInterface extends BaseRepository
        {
            // Add repository methods here
        }
        PHP;

        $repositoryContent = <<<PHP
        <?php

        namespace App\Repositories;

        use App\Repositories\Interfaces\\{$name}RepositoryInterface;
        use App\Models\\{$name};

        class {$name}Repository extends Repository implements {$name}RepositoryInterface
        {
            public function __construct({$name} \$model)
            {
                parent::__construct(\$model);
            }

            // Add repository methods here
        }
        PHP;

        File::put($repositoryInterfacePath, $interfaceContent);
        File::put($repositoryPath, $repositoryContent);
    }

    private function generateService($name): void
    {
        $servicePath = app_path("Services/{$name}Service.php");
        $serviceInterfacePath = app_path("Services/Interfaces/{$name}ServiceInterface.php");

        if (File::exists($servicePath) || File::exists($serviceInterfacePath)) {
            $this->warn("{$name} Service already exists.");

            return;
        }

        File::ensureDirectoryExists(dirname($serviceInterfacePath));
        File::ensureDirectoryExists(dirname($servicePath));

        $interfaceContent = <<<PHP
        <?php

        namespace App\Services\Interfaces;

        interface {$name}ServiceInterface extends BaseService
        {
            // Add service methods here
        }
        PHP;

        $serviceContent = <<<PHP
        <?php

        namespace App\Services;

        use App\Services\Interfaces\\{$name}ServiceInterface;
        use App\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Service extends Service implements {$name}ServiceInterface
        {
            public function __construct({$name}RepositoryInterface \$repository)
            {
                parent::__construct(\$repository);
            }

            // Add service methods here
        }
        PHP;

        File::put($serviceInterfacePath, $interfaceContent);
        File::put($servicePath, $serviceContent);
    }
}
