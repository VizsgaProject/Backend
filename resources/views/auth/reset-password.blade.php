<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó Visszaállítás</title>
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #00ADB5;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        form {
            width: 100%;
            max-width: 400px;
        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
        }

        input {
            padding: 10px;
            width: 100%;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #1E1E1E;
            color: #E0E0E0;
            font-size: 1rem;
        }

        input:focus {
            border-color: #00ADB5;
            outline: none;
        }

        button {
            padding: 10px 20px;
            background-color: #00ADB5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background-color: #0097A7;
        }

        .container {
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .error-message {
            color: #FF6B6B;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Jelszó Visszaállítás</h1>

        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('update.password') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Új Jelszó:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="password_confirmation">Jelszó Megerősítése:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>
            <button type="submit">Jelszó Visszaállítása</button>
        </form>
    </div>
</body>

</html>
