<x-mail::message>
    <h1>Вітаємо!</h1>
    <p>Ви успішно записались на прийом.</p>
    <p>Деталі:</p>
    <ul>
        <li>Дата прийому: {{ $appointment->appointment_date->format('d.m.Y') }}</li>
        <li>Лікар: {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}</li>
        <li>Послуга: {{ $appointment->service->name }}</li>
    </ul>
</x-mail::message>
