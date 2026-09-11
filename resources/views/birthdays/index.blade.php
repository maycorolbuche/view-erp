@extends('layouts.app')
@section('title', 'Aniversariantes')

@section('content')
    <div class="title-bar">
        <h1>Aniversariantes</h1>
        <p>Datas de aniversário de todos os usuários, organizadas por mês.</p>
        <a class="link" href="{{ route('dashboard') }}">Voltar ao dashboard</a>
    </div>

    <div class="row g-3">
        @foreach ($months as $month => $label)
            <div class="col-12 col-md-6 col-xl-4">
                <x-card :title="$label" full-height>
                    @forelse ($birthdaysByMonth->get($month, collect()) as $birthday)
                        <x-birthday :birthday="$birthday" />
                    @empty
                        <p class="text-body-secondary mb-0">Nenhum aniversariante neste mês.</p>
                    @endforelse
                </x-card>
            </div>
        @endforeach
        @if ($withoutBirthday->isNotEmpty())
            <div class="col-12">
                <x-card title="Sem data de aniversário">
                    @foreach ($withoutBirthday as $birthday)
                        <x-birthday :birthday="$birthday" />
                    @endforeach
                </x-card>
            </div>
        @endif
    </div>
@endsection
