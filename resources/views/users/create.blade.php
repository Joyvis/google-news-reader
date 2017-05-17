@extends('layouts.app')
@section('content')
	<h3>Novo Usuário</h3>
	{!! Form::open(['route' => 'user.store', 'class' => 'form-horizontal form-label-left', 'data-parsley-validate' => ""]) !!}
		@include('users._form')
	{!! Form::close() !!}
@endsection