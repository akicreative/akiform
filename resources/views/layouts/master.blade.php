<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @yield('analytics')




    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <?

    if(isset($page)){

        if($page->metakeywords != ''){

            $meta_keywords = $page->metakeywords;
        }

        if($page->metadescription != ''){

            $meta_description = $page->metadescription;
        }
    }


    ?>

    <title>@yield('pagetitle')</title>

    <?

    if(!isset($meta_keywords)) $meta_keywords = '';
    if(!isset($meta_description)) $meta_description = '';

    if($meta_keywords != ''){

        echo '<meta name="keywords" content="' . $meta_keywords . '">';

    }

    if($meta_description != ''){

        echo '<meta name="description" content="' . $meta_description . '">';
        
    }


    ?>

    <!-- Scripts -->
    
    <!-- Fonts -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/f067031dde.js"></script>

    <!-- Styles -->
    
    @yield('mastercss')

    @yield('head')

</head>
<body>
    
    @yield('master')

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    @yield('masterscripts')

    @yield('scripts')

</body>
</html>
