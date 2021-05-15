@extends('cms.layout')

@section('pagetitle')
Create User
@endsection

@section('content')



<div class="container">

	<h1>Create User</h1>

<?

$ar = new AkiForm($errors, ['horizontal' => true]);

$ar->open(['action' => route('aki.users.store')]);

$ar->build('text', 'Name:', 'name', ['required' => true]);

$ar->build('email', 'Email:', 'email', ['required' => true, 'blockhelp' => "This will be the login."]);

$ar->build('text', 'Password:', 'password', ['required' => true]);

$ar->build('submit', 'Create');

$ar->close();

?>

</div>

@endsection