<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заявки</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
<h1>Создание заявки в ремонтную службу</h1>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('requests.store') }}">
    @csrf
    <div class="form-group">
        <label>Имя клиента</label>
        <input type="text" name="client_name" required value="{{ old('client_name') }}">
        @error('client_name') <div style="color: red;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Телефон</label>
        <input type="text" name="phone" required value="{{ old('phone') }}">
        @error('phone') <div style="color: red;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Адрес</label>
        <input type="text" name="address" required value="{{ old('address') }}">
        @error('address') <div style="color: red;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Описание проблемы</label>
        <textarea name="problem_text" rows="4" required>{{ old('problem_text') }}</textarea>
        @error('problem_text') <div style="color: red;">{{ $message }}</div> @enderror
    </div>

    <button type="submit">Отправить заявку</button>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center;">
        <h3>Вход для сотрудников</h3>
        <div style="display: flex; gap: 20px; justify-content: center; margin-top: 15px;">
            <a href="{{ route('login') }}"
               style="display: inline-block; padding: 10px 25px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
                👤 Войти как диспетчер
            </a>
            <a href="{{ route('login') }}"
               style="display: inline-block; padding: 10px 25px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px;">
                🔧 Войти как мастер
            </a>
        </div>
        <p style="color: #777; font-size: 14px; margin-top: 10px;">
            Тестовые пользователи:<br>
            Диспетчер: dispatcher@test.com / 123<br>
            Мастер Иван: ivan@test.com / 123<br>
            Мастер Пётр: petr@test.com / 123
        </p>
    </div>
</form>
</body>
</html>
