<div>

    @if ($title != '')
        <div class="panel panel-{{ $type ? $type : 'primary' }}">
            <div class="panel-heading">
                <span class="panel-title">{{ $title }}</span>
            </div>
        </div>
    @endif

    <div
        style="display: flex;flex-direction: row;flex-wrap: wrap;align-items: stretch;{{ $right ? 'justify-content: flex-end;' : '' }}">
        {{ $slot }}
    </div>

</div>
