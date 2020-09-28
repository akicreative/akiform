<?

$toastid = md5(rand() . time());

?>

<div id="toast{{ $toastid }}" class="toast border-primary" role="alert" aria-live="assertive" aria-atomic="true" data-delay="{{ $toastdelay ?? "5000" }}" style="min-width: 300px;">
  <div  class="toast-header {{ $toastheaderclass ?? "" }}">
   
    <strong class="mr-auto"><div class="d-inline">{!! $toastheader ?? 'SAVED!' !!}</div></strong>
    <small class="text-white">just now</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    {!! $toastbody ?? "The item has been saved." !!}
  </div>
</div>


<script type="text/javascript">
	
(function(){
	
	$('#toast{{ $toastid }}').toast('show');

})();


</script>