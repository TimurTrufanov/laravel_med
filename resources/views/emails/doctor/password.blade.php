<x-mail::message>
    <h1>Вітаємо, {{ $name }}!</h1>
    <p>Ваш обліковий запис успішно створено. Для входу використовуйте наступні дані:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Пароль:</strong> {{ $password }}</p>
</x-mail::message>
