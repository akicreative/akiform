<?php
    
    namespace akicreative\akiforms;
    
    use Illuminate\Support\ServiceProvider;
    
    class AkiFormsServiceProvider extends ServiceProvider {

        public function boot()
        {

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'akiforms');

            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

            $this->publishes([

                __DIR__ . '/../lib/' => public_path('vendor/akicreative/akiforms')

            ]);

            require_once __DIR__ . '/helpers.php';
            require_once __DIR__ . '/telegram.php';

        }
        
        public function register()
        {

            $this->mergeConfigFrom(__DIR__ . '/../config/akiforms.php', 'akiforms');        

        }

        public function provides()
        {
            
        }

    }
?>