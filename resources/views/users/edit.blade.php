@extends('layouts.app')
@section('content')
	<h3>Novo Usuário</h3>
	{!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'patch', 'class' => 'form-horizontal form-label-left']) !!}
		@include('users._form')
	{!! Form::close() !!}
@endsection