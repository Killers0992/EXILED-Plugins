<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyLevel;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyPermission;
use jeremykenedy\LaravelRoles\App\Http\Middleware\VerifyRole;

class RoleServiceProvider extends ServiceProvider
{
    private $_packageTag = 'laravelroles2';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Routing\Router $router The router
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('pluginpermission', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasPermission({$expression})): ?>";
        });

        $blade->directive('endpluginpermission', function () {
            return '<?php endif; ?>';
        });
    }
}
