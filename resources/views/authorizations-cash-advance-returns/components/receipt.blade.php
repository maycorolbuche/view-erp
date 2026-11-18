@if ($data->authorization_type->type == 'cash-advance-return' && $data->file)
    <p>
        <b>Comprovante de Devolução:</b>
        <a href="{{ $data->file->url }}" target="_blank" rel="noopener" data-type="file">
            {{ $data->file->original_name }}
        </a>
    </p>
@endif
