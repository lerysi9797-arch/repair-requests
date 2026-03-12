<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель диспетчера</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        select { padding: 5px; }
        button { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
<h1>Панель диспетчера</h1>
    <form method="GET" action="{{ route('dispatcher.dashboard') }}" style="margin-bottom: 20px;">
        <label>Фильтр по статусу:</label>
        <select name="status" onchange="this.form.submit()">
            <option value="all" {{ $currentStatus == 'all' ? 'selected' : '' }}>Все</option>
            <option value="new" {{ $currentStatus == 'new' ? 'selected' : '' }}>Новые</option>
            <option value="assigned" {{ $currentStatus == 'assigned' ? 'selected' : '' }}>Назначенные</option>
            <option value="in_progress" {{ $currentStatus == 'in_progress' ? 'selected' : '' }}>В работе</option>
            <option value="done" {{ $currentStatus == 'done' ? 'selected' : '' }}>Выполненные</option>
            <option value="canceled" {{ $currentStatus == 'canceled' ? 'selected' : '' }}>Отменённые</option>
        </select>
        <noscript><button type="submit">Применить</button></noscript>
    </form>
    <form method="POST" action="{{ route('logout') }}" style="display: inline; float: right;">
        @csrf
        <button type="submit">Выйти</button>
    </form>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="error">{{ session('error') }}</div>
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
        <th>Мастер</th>
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
            <td>{{ $request->master->name ?? 'Не назначен' }}</td>
            <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
            <td>
                @if($request->status === 'new')
                    <form method="POST" action="{{ route('requests.assign', $request->id) }}" style="margin-bottom: 5px;">
                        @csrf
                        @method('PATCH')
                        <select name="master_id" required>
                            <option value="">Выберите мастера</option>
                            @foreach($masters as $master)
                                <option value="{{ $master->id }}">{{ $master->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Назначить</button>
                    </form>
                    <form method="POST" action="{{ route('requests.cancel', $request->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Отменить заявку?')">Отменить</button>
                    </form>
                @elseif($request->status === 'assigned')
                    <form method="POST" action="{{ route('requests.cancel', $request->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Отменить заявку?')">Отменить</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
