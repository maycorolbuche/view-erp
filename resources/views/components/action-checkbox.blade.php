<div class="btn-group">
    <a style="color: #666; cursor: pointer; text-decoration: none;" data-toggle="dropdown" aria-expanded="true">
        <i class="far fa-square"></i>
        <span class="caret ml5"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="javascript:" onclick="check('{{ $element }}', 'all');{!! $callback !!}">
                <i class="far fa-check-square"></i> Marcar Todos
            </a>
        </li>
        <li>
            <a href="javascript:" onclick="check('{{ $element }}', 'none');{!! $callback !!}">
                <i class="far fa-square"></i> Desmarcar Todos
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="javascript:" onclick="check('{{ $element }}', 'reverse');{!! $callback !!}">
                <i class="glyphicon glyphicon-refresh"></i> Inverter Seleção
            </a>
        </li>
    </ul>
</div>
