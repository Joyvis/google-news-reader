@extends('layouts.app')
@section('content')
	<h2><a href="{{ $permalink }}">{{ $title }}</a></h2>

	@foreach ($items as $item)
		<div class="item">
		  <h3><a href="{{ $item->get_permalink() }}">{{ $item->get_title() }}</a></h3>
		  <p>{!! $item->get_description() !!}</p>
		  <p><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
		</div>
	@endforeach
@endsection