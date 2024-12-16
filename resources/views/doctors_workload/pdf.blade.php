@extends('layouts.pdf')

@section('title', 'Завантаженість лікарів')

@section('header', 'Завантаженість лікарів')

@section('content')
    <p>Клініка: {{ $clinicName }}</p>
    <p>Спеціалізація: {{ $specializationName }}</p>
    <p>Період:
        @if(isset($startDate) && isset($endDate) && $startDate === $endDate)
            {{ $startDate }}
        @elseif($startDate && $endDate)
            {{ $startDate }} - {{ $endDate }}
        @else
            весь
        @endif
    </p>

    <table>
        <thead>
        <tr>
            <th>Лікар</th>
            <th>Кількість записів</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doctorsWorkload as $doctor => $appointments)
            <tr>
                <td>{{ $doctor }}</td>
                <td>{{ $appointments->count() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
