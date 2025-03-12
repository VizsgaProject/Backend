<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó visszaállítása</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
        }

        .header h1 {
            margin: 0;
            color: #333333;
        }

        .content {
            margin: 20px 0;
        }

        .content p {
            line-height: 1.6;
            color: #666666;
        }

        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 0;
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Jelszó visszaállítása</h1>
        </div>
        <div class="content">
            <p>Üdv,</p>
            <p>Ezt az e-mailt azért kapta, mert jelszó-visszaállítási kérelmet kaptunk az Ön fiókjához.</p>
            <p>Kattintson az alábbi gombra a jelszó visszaállításához:</p>
            <a href="http://localhost:8000/api/foods" class="button">Jelszó visszaállítása</a>
            <p>Ha nem Ön kérte a jelszó visszaállítását, nincs további teendője.</p>
            <p>Köszönjük,<br>A Csapat</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Az Ön cége. Minden jog fenntartva.</p>
        </div>
    </div>
</body>

</html>
