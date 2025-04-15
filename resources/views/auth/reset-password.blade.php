<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó Visszaállítás</title>
    <style>
        body {
            background-color: #1e2939;
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
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        form {
            width: 100%;
            max-width: 400px;
            /* Az űrlap szélessége változatlan */
        }

        div {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #E0E0E0;
        }

        input {
            height: 40px;
            width: 125%;
            /* Az input mezők hosszabbak */
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #1E1E1E;
            color: #E0E0E0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #00ADB5;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 173, 181, 0.5);
        }

        button {
            padding: 12px 24px;
            background-color: #008B96;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            display: block;
            margin: 20px auto 0;
            transition: background-color 0.3s ease;
            justify-content: center;
        }

        button:hover {
            background-color: #0097A7;
        }

        .container {
            background-color: #101828;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
        }

        .error-message {
            color: #FF6B6B;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 10px;
            background-color: #2E2E2E;
            border-radius: 5px;
            border: 1px solid #FF6B6B;
        }

        .center {
            margin-left: 120px;
        }
    </style>
</head>

<body>
    <div class="container center">
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
            <div class="center">
                <button type="submit">Jelszó Visszaállítása</button>
            </div>
        </form>
    </div>
</body>

</html>
