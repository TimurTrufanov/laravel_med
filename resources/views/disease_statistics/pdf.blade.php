@extends('layouts.pdf')

@section('title', 'Статистика захворювань')

@section('header', 'Статистика захворювань')

@section('content')
    <p>Клініка: {{ request('clinic_id') ? $records->first()->appointment->clinic->name : 'Всі клініки' }}</p>
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
            <th>Діагноз</th>
            <th>Кількість</th>
        </tr>
        </thead>
        <tbody>
        @foreach($diagnosisCounts as $diagnosis => $group)
            <tr>
                <td>{{ $diagnosis }}</td>
                <td>{{ $group->count() }}</td>
            </tr>
        @endforeach
        @if ($customDiagnosesCount > 0)
            <tr>
                <td>Користувацький діагноз</td>
                <td>{{ $customDiagnosesCount }}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
