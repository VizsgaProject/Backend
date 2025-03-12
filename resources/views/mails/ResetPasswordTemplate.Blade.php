<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelszó visszaállítása</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            color: white;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #1C1C1C;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: white;
        }

        .content {
            margin: 20px 0;
            line-height: 1.6;
            text-align: center;
        }

        .content p {
            margin: 15px 0;
            color: white;
        }

        .button {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 24px;
            background-color: #00ADB5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #009299;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: white;
            font-size: 14px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Jelszó visszaállítása</h1>
        </div>
        <div class="content">
            <p>Üdvözöljük!</p>
            <p>Ezt az e-mailt azért kapta, mert jelszó-visszaállítási kérelmet kaptunk az Ön fiókjához.</p>
            <p>Kattintson az alábbi gombra a jelszó visszaállításához:</p>
            <a href="http://localhost:8000/api/foods" class="button">Jelszó visszaállítása</a>
            <p>Ha nem Ön kérte a jelszó visszaállítását, kérjük, hagyja figyelmen kívül ezt az e-mailt.</p>
            <p>Köszönjük,<br><strong>A Csapat</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Az Ön cége. Minden jog fenntartva.</p>
        </div>
    </div>
</body>

</html>
