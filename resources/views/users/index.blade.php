@extends('layouts.app')
@section('content')
	<h3>Usuários</h3>
	{!! Html::link(route('user.create'), 'Novo Usuário', ['class' => 'btn btn-success']) !!}
	<table class="table table-striped">
		<thead>
			<th>ID</th>
			<th>Nome</th>
			<th>Email</th>						
			<th class="text-right"></th>
		</thead>
		<tbody>
			@forelse ($users as $user)
				<tr>
			    	<td>{{ $user->id }}</td>
			    	<td>{{ $user->name }}</td>
			    	<td>{{ $user->email }}</td>
			    				    	
			    	<td class="text-right">
			    		@include('partials.actions', ['route' => 'user', 'routeId' => $user->id])
			    	</td>
			    </tr>
			@empty
				<tr>
					<td colspan="5">Nenhum usuário cadastrado.</td>
				</tr>
			@endforelse
		</tbody>
	</table>
@endsection