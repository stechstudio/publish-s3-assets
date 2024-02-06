<?php

namespace Stechstudio\PublishS3Assets;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Stechstudio\PublishS3Assets\Console\Commands\PublishS3AssetsCommand;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/publish-s3-assets.php' => config_path('publish-s3-assets.php'),
        ], 'publish-s3-assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishS3AssetsCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/publish-s3-assets.php', 'publish-s3-assets'
        );

        $this->app->config['filesystems.disks.asset-publish-disk'] = config('publish-s3-assets.disk');
    }
}
