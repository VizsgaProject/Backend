<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó frissítése</title>
</head>

<body>
    <h1>Jelszó frissítése</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('update.password') }}" method="POST">
        @csrf
        <label for="email">Email cím:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Új jelszó:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password_confirmation">Új jelszó megerősítése:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        <br>
        <button type="submit">Jelszó frissítése</button>
    </form>
</body>

</html>
