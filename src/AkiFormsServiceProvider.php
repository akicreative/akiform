<?php
    
    namespace AkiCreative\AkiForms;
    
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Blade;
    
    class AkiFormsServiceProvider extends ServiceProvider {

        public function boot()
        {

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'akiforms');

            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

            $this->publishes([

                __DIR__ . '/../lib/' => public_path('vendor/akicreative/akiforms')

            ]);

            $this->publishes([

                __DIR__ . '/../config/akiforms.php' => config_path('akiforms.default.php')

            ]);



            require_once __DIR__ . '/helpers.php';
            require_once __DIR__ . '/redactor.php';
            require_once __DIR__ . '/notifications.php';

            Blade::componentNamespace('AkiCreative\\AkiForms\\Resources\\Views\\Components', 'akiforms');

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