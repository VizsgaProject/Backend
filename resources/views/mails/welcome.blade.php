<!DOCTYPE html>
<html>

<head>
    <title>Üdvözöljük az oldalunkon!</title>
    <style>
        /* Alap stílusok */
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }

        /* Konténer stílus */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            color: #ffffff;
            padding: 20px;
            background-color: #1c1c1c;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Cím stílus */
        h1 {
            color: #00ADB5;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Bekezdés stílus */
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #ffffff;
            text-align: center;
        }

        /* Kiemelt szöveg */
        .highlight {
            color: #00ADB5;
            font-weight: bold;
        }

        /* Gomb stílus */
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

        /* Elválasztó vonal stílus */
        .separator {
            width: 100%;
            height: 1px;
            background-color: #333;
            /* A vonal színe */
            margin: 20px 0;
            /* Térköz a vonal körül */
        }

        /* Lábléc stílus */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
        }

        /* Reszponzív stílusok */
        @media (max-width: 600px) {
            .email-container {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .button {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Kedves {{ $name }},</h1>

        <div class="separator"></div>

        <p>Köszönjük, hogy regisztráltál az oldalunkra!</p>
        <p>Reméljük, hogy élvezni fogod az oldalunkat, és sok hasznos információt találsz nálunk.</p>
        <p>Ha bármilyen kérdésed van, ne habozz kapcsolatba lépni velünk!</p>

        <div class="separator"></div>

        <div class="footer">
            <p>Üdvözlettel,</p>
            <p>Az Lifesport csapata</p>
        </div>
    </div>
</body>

</html>
