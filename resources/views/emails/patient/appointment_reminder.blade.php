<x-mail::message>
    <h1>Вітаємо!</h1>
    <p>Сьогодні у вас призначено прийом лікаря</p>
    <p>Деталі:</p>
    <ul>
        <li>Лікар: {{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}</li>
        <li>Послуга: {{ $appointment->service->name }}</li>
    </ul>
</x-mail::message>
