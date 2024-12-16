@extends('layouts.pdf')

@section('title', 'Фінансові показники')

@section('header', 'Фінансові показники')

@section('content')
    <p>Клініка: {{ $clinicName }}</p>
    <p>Період:
        @if(isset($startDate) && isset($endDate) && $startDate === $endDate)
            {{ $startDate->format('d.m.Y') }}
        @elseif($startDate && $endDate)
            {{ $startDate->format('d.m.Y') }} - {{ $endDate->format('d.m.Y') }}
        @else
            весь
        @endif
    </p>
    <p>Тип: {{ $type === 'analyses' ? 'Анализы' : ($type === 'services' ? 'Услуги' : 'Всі') }}</p>

    <table>
        <thead>
        <tr>
            <th>Назва</th>
            <th>Ціна за одиницю</th>
            <th>Кількість</th>
            <th>Загальна вартість</th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ number_format($item['price'], 2) }} грн</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['total_price'], 2) }} грн</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Загальна сума:</td>
            <td style="font-weight: bold;">{{ number_format($totalSum, 2) }} грн</td>
        </tr>
        </tbody>
    </table>
@endsection
