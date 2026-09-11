@extends('layouts.app')
@section('title', 'Aniversariantes')

@section('content')
    <div class="title-bar">
        <h1>Aniversariantes</h1>
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
    </div>
@endsection
