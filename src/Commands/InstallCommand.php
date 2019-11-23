<?php

namespace SaadeMotion\Photofolio\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageServiceProviderLaravel5;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'photofolio:install';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Photofolio Admin package';
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null]
        ];
    }
    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }
        return 'composer';
    }
    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }
    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing the Photofolio assets, database, and config files');
        // Publish only relevant resources on install
        $this->call('vendor:publish', ['--provider' => ImageServiceProviderLaravel5::class]);
        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);
        
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();
        $this->info('Adding Photofolio routes to routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Photofolio::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => 'admin'], function () {\n    Photofolio::routes();\n});\n"
            );
        }
        \Route::group(['prefix' => 'admin'], function () {
            \Photofolio::routes();
        });

        $this->call('vendor:publish', ['--provider' => PhotofolioServiceProvider::class, '--tag' => ['config']]);
        $this->info('Adding the storage symlink to your public folder');
        $this->call('storage:link');
        $this->info('Successfully installed Photofolio! Enjoy');
    }
}
