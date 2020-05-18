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

    {{ $meta_keywords ?? '' }}
    {{ $meta_description ?? '' }}

    <?

    if($meta_keywords != ''){

        echo '<meta name="keywords" content="' . $meta_keywords . '">';

    }

    if($meta_description != ''){

        echo '<meta name="description" content="' . $meta_description . '">';
        
    }


    ?>

    <!-- Scripts -->
    
    <!-- Fonts -->

 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/f067031dde.js"></script>

    <!-- Styles -->
    
    @yield('mastercss')

    @yield('head')

</head>
<body>
    
    @yield('master')

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    @yield('scripts')

</body>
</html>
