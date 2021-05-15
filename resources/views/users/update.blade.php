@extends('cms.layout')

@section('pagetitle')
Update {{ $user->name }}
@endsection

@section('head')

@endsection

@section('content')

<div class="container">

<h1>{{ $user->name }}</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.users.update', [$user->id])]);


$ar->fill($user);

$ar->build('text', 'Name:', 'name', ['required' => true]);

$ar->build('email', 'Email:', 'email', ['required' => true, 'blockhelp' => "This will be the login."]);

$ar->build('text', 'Password:', 'password', ['blockhelp' => 'Entering a password will reset the user password. If the user wants to reset their password they can do it from the login form.']);

if(auth()->user()->aki_admin){

	$ar->build('select', 'Admin:', 'aki_admin', ['selectshortcut' => 'noyes']);
}

$ar->build('submit', 'Save');

$ar->close();

?>

</div>

@endsection

@section('scripts')



@endsection