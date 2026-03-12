<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} — Вход</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 50px 40px;
            text-align: center;
        }
        h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .test-accounts {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: left;
            font-size: 13px;
            border: 1px solid #e9ecef;
        }
        .test-accounts strong {
            color: #495057;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .test-accounts ul {
            list-style: none;
            color: #6c757d;
        }
        .test-accounts li {
            margin: 5px 0;
            font-family: monospace;
            background: white;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
            font-weight: 500;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.9;
        }
        .quick-links {
            margin-top: 25px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .quick-links a {
            text-decoration: none;
            color: #667eea;
            font-size: 13px;
            padding: 5px 10px;
            border: 1px solid #667eea;
            border-radius: 5px;
            transition: all 0.2s;
        }
        .quick-links a:hover {
            background: #667eea;
            color: white;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>🔧 Ремонтная служба</h1>
    <div class="subtitle">Вход в систему для сотрудников</div>

    @if($errors->any())
        <div class="error-message">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="test-accounts">
        <strong>👥 Тестовые аккаунты</strong>
        <ul>
            <li>📋 Диспетчер: dispatcher@test.com / 123</li>
            <li>🔧 Мастер Иван: ivan@test.com / 123</li>
            <li>🔧 Мастер Пётр: petr@test.com / 123</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>📧 Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label>🔑 Пароль</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Войти</button>
    </form>

    <div class="quick-links">
        <a href="/">← На главную</a>
    </div>
</div>
</body>
</html>
