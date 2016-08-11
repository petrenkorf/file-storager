<?php

namespace Impacte\FileStorager;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Impacte\FileStorager\Handlers\ModelFolderHandler;

class FileStoragerServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('Impacte\FileStorager\FileStoragerService', function () {
            return new FileStoragerService(
                new ModelFolderHandler(
                    new Filesystem()
                )
            );
        });
    }
}