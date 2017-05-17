@extends('layouts.app')
@section('content')
	<h3>Visualizar Usuário</h3>
	<p><b>Nome:</b> {{ $user->name }}</p>
	<p><b>Email:</b> {{ $user->email }}</p>	
@endsection