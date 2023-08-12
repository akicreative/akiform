@aware([
	'for' => '',
	'errormsg' => 'REQUIRED FIELD',
	'errorhighlight' => false
])

@if($for != '' && $errormsg != 'hidden')


	@error($for) 

	<? if($errormsg == 'auto'){ $errormsg = $message; } ?>

	<span class="text-xs text-red-600">{{ $errormsg }}</span> 

	@enderror

@endif