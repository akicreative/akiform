<?php
    
    namespace akicreative\akiforms;
    
    use Illuminate\Support\ServiceProvider;
    
    class AkiFormsServiceProvider extends ServiceProvider {

        public function boot()
        {

            require_once __DIR__ . '/helpers.php';

        }
        
        public function register()
        {

           

        }

        public function provides()
        {
            
        }

    }
?>