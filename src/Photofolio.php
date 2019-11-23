<?php

namespace SaadeMotion\Photofolio;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SaadeMotion\Photofolio\Database\Models\Category;
use SaadeMotion\Photofolio\Database\Models\Portifolio;
use SaadeMotion\Photofolio\Database\Models\PortifolioItem;

class Photofolio
{
    protected $version;
    protected $filesystem;

    protected $models = [
        'Category'    		=> Category::class,
        'Portifolio'  		=> Portifolio::class,
        'PortifolioItem'	=> PortifolioItem::class
    ];

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);
        $this->findVersion();
    }

    public function model($name)
    {
        return app($this->models[Str::studly($name)]);
    }

    public function view($name)
    {
        return view('photofolio::' . $name);
    }

    public function routes()
    {
        require __DIR__.'/../routes/photofolio.php';
    }

    public function getVersion()
    {
        return $this->version;
    }

    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }
        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );
            // Loop through all the packages and get the version of voyager
            foreach ($file->packages as $package) {
                if ($package->name == 'saademotion/photofolio') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }
}
