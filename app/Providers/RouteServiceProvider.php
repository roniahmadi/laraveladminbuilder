<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

// for dynamic route
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapDynamicRoutes();
        
        $this->mapApiRoutes();
        
        $this->mapWebRoutes();
        
        // Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
        //
    }

    protected function mapDynamicRoutes(){
        $pth = [];
        $namespacePath = self::translateNamespacePath($this->namespace);
        if ($namespacePath === '') {
            $pth = [];
        }

        $pth = self::searchClasses($this->namespace, $namespacePath);

        Route::middleware('web')->namespace($this->namespace)->group(function() use ($pth){
            foreach ($pth as $key => $value) {
                if( !($value == $this->namespace.DIRECTORY_SEPARATOR.'Controller') ){
                    $explode_string = explode("\\",$value);
                    $splice_string = array_splice($explode_string,3,count($explode_string)-1);
                    $implode_string = implode("/",$splice_string);
                    $implode_string_with_comma = implode('.',$splice_string);
                    $string_lower = strtolower($implode_string);
                    Route::get($string_lower, [$value,'index'])->name($implode_string_with_comma);
                    Route::get($string_lower.'/add', [$value,'add'])->name($implode_string_with_comma.'.add');
                }
            }
            // base_path('routes/web.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected static function translateNamespacePath(string $namespace): string
    {
        $rootPath = app_path().DIRECTORY_SEPARATOR;
        
        $nsParts = explode('\\', $namespace);
        array_shift($nsParts);
        
        if (empty($nsParts)) {
            return '';
        }

        return realpath($rootPath. implode(DIRECTORY_SEPARATOR, $nsParts)) ?: '';
    }

    private static function searchClasses(string $namespace, string $namespacePath): array {
        $classes = [];

        /**
         * @var \RecursiveDirectoryIterator $iterator
         * @var \SplFileInfo $item
         */
        foreach ($iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($namespacePath, RecursiveDirectoryIterator::SKIP_DOTS),RecursiveIteratorIterator::SELF_FIRST) as $item) {
            if ($item->isDir()) {
                $nextPath = $iterator->current()->getPathname();
                $nextNamespace = $namespace . '\\' . $item->getFilename();
                $classes = array_merge($classes, self::searchClasses($nextNamespace, $nextPath));
                continue;
            }
            if ($item->isFile() && $item->getExtension() === 'php') {
                $class = $namespace . '\\' . $item->getBasename('.php');
                if (!class_exists($class)) {
                    continue;
                }
                $classes[] = $class;
            }
        }

        return $classes;
    }
}
