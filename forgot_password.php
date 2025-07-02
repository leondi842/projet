<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts pour effet MUI -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #2575fc;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1a5edc;
        }
        .link {
            margin-top: 10px;
            text-align: center;
        }
        footer {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

    <main>
        <div class="card">
            <h2>🔐 Mot de passe oublié</h2>
            <form action="send_reset_link.php" method="POST">
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="exemple@domaine.com">
                </div>
                <button type="submit">📤 Envoyer le lien</button>
            </form>
            <div class="link">
                <a href="inscription_connexion.php">🔙 Retour à la connexion</a>
            </div>
        </div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

</body>
</html>
