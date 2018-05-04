<?php namespace Markard\GridData;

use Illuminate\Support\ServiceProvider;

class GridDataServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('grid_data',
            function ($app) {
                return new GridDataManager($app);
            });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('grid_data');
    }

    public function boot()
    {
        $this->package('Markard/GridData');
    }


}
