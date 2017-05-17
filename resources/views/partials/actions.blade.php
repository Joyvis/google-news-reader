<div class="dropdown">
  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Ações
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li>
    	{!! Html::link(route($route.'.edit', $routeId), 'Editar') !!}
    </li>
    <li>
    	{!! Html::link(route($route.'.show', $routeId), 'Ver') !!}
    </li>
    <li>
    	{!! Html::link(route($route.'.show', $routeId), 'Remover', ['class' => 'remover-item']) !!}
    	{!! Form::open(['route' => [$route.'.destroy', $routeId], 'method' => 'DELETE', 'style' => "display: none;"]) !!}
		    
		{!! Form::close() !!}
    </li>
  </ul>
</div>

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.remover-item', function(e){
                e.preventDefault();
                var link = $(this);

                if(confirm('Você realmente deseja excluir esse item?'))
                    link.parent().find('form').submit();
            })
        })
    </script>
@endsection