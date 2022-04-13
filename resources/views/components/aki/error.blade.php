@aware([
	'for' => '',
	'errormsg' => 'REQUIRED FIELD'
])

@if($for != '')


	@error($for) 

	<? if($errormsg == 'auto'){ $errormsg = $message; } ?>

	<span class="text-xs text-red-600">{{ $errormsg }}</span> 

	@enderror

@endif