@extends('layouts.blank')

@section('content')
    @foreach ($data as $item)
        <tr class="category" data-id="{{ $item->category_id }}">
            <td>
                {{ $item->category_name }}
            </td>
            <td class="text-right">
                {{ $item->total_users }}
            </td>
            <td class="total-amount">
                <x-input type="money" class="--filter-ignore" value="{{ $item->total_amount }}" />
            </td>
            <td class="total-items">
                <x-input type="number" value="{{ $item->total_items }}" />
            </td>
            <td class="text-right avg">
            </td>
        </tr>
    @endforeach
@endsection
