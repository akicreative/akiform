@props([

  'scroll' => false

])

<?

$class1 = '';
$class2 = '';

if($scroll){

    $class1 = 'overflow-x-auto';
    $class2 = 'overflow-hidden';
}

?>

<div class="flex flex-col">



  <div class="-my-2 {{ $class1 }} sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow-sm  {{ $class2 }} border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">

            {{ $slot }}

          </table>
      </div>
    </div>
  </div>



</div>