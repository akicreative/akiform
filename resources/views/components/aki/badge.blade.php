@props([

    'color',
    'colorclass' => ''


])

<?

    switch($color){

        case "blue":
        case "customer":
            $colorclass = "bg-blue-100 text-blue-800";
            break;
        case "green":
        case "contractor":
            $colorclass = "bg-green-100 text-green-800";
            break;
        case "pink":
        case "supplier":
            $colorclass = "bg-pink-100 text-pink-800";
            break;
        case "purple":
            $colorclass = "bg-purple-100 text-purple-800";
            break;
        case "red":
            $colorclass = "bg-red-100 text-red-800";
            break;
        case "gray":
            $colorclass = "bg-gray-100 text-gray-800";
            break;
    }

?>

<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $colorclass }}"> {{ $slot }} </span>