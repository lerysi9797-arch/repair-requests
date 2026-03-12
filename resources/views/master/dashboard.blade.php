<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель мастера</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        button { padding: 5px 10px; cursor: pointer; }
        .logout-form { float: right; }
    </style>
</head>
<body>
<h1>Панель мастера
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</h1>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Клиент</th>
        <th>Телефон</th>
        <th>Адрес</th>
        <th>Проблема</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
        <tr>
            <td>{{ $request->id }}</td>
            <td>{{ $request->client_name }}</td>
            <td>{{ $request->phone }}</td>
            <td>{{ $request->address }}</td>
            <td>{{ $request->problem_text }}</td>
            <td>{{ $request->status }}</td>
            <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
            <td>
                @if($request->status === 'assigned')
                    <form method="POST" action="{{ route('requests.take', $request->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Взять в работу</button>
                    </form>
                @elseif($request->status === 'in_progress')
                    <form method="POST" action="{{ route('requests.complete', $request->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Завершить</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
