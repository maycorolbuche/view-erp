<div style="padding: 0 5px 0 5px;">
    @if ($route != '')
        <a type="{{ $type }}" class="btn btn-{{ $layout }}" id="{{ $id }}"
            name="{{ $name }}" onclick="confirm_btn_{{ $id }}()" {{ $disabled ? 'disabled' : '' }}>
            {{ $label }}
        </a>
    @else
        <button type="{{ $type }}" class="btn btn-{{ $layout }}" id="{{ $id }}"
            name="{{ $name }}" onclick="confirm_btn_{{ $id }}()" {{ $disabled ? 'disabled' : '' }}>
            {{ $label }}
        </button>
    @endif
</div>
<script>
    function confirm_btn_{{ $id }}() {
        @if ($confirm != '')
            if ($("#{{ $id }}").hasClass("no-confirm")) {
                actions_btn_{{ $id }}();
                $("#{{ $id }}").removeClass("no-confirm");
            } else {
                $.confirm({
                    title: '{{ $confirmTitle ?: '' }}',
                    content: '<span style="font-weight: 600;">{{ $confirm }}</span>',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        confirm: {
                            text: 'Sim',
                            btnClass: 'btn-info',
                            action: function() {
                                $("#{{ $id }}").addClass("no-confirm");
                                $("#{{ $id }}").click();
                                event.preventDefault();
                            }
                        },
                        cancel: {
                            text: 'Não',
                        },
                    }
                });
                event.preventDefault();
            }
        @else
            actions_btn_{{ $id }}();
        @endif
    }

    function actions_btn_{{ $id }}() {
        $("#{{ $id }}").closest('form').find('[name=_action]').val('{{ $value }}');
        @if ($route != '')
            window.location.href = '{{ $route }}';
            event.preventDefault();
        @elseif ($novalidate == true)
            $("#{{ $id }}").closest('form')[0].submit();
            event.preventDefault();
        @endif
    }
</script>
