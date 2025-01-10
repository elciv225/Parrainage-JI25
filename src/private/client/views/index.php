<?php
// Récupérer les informations de l'utilisateur
$utilisateur = $_SESSION['utilisateur'];
$nom = htmlspecialchars($utilisateur['nom']);
$prenom = htmlspecialchars($utilisateur['prenom']);
$email = htmlspecialchars($utilisateur['email']);
$niveau = htmlspecialchars($utilisateur['niveau']);
$photoBrut = htmlspecialchars($utilisateur['photo']);

// Chemin de la photo par défaut
$photoDefault = 'private/client/uploads/photo/imgDefault.png';

// Chemin de la photo de l'utilisateur
$photo = !empty($photoBrut)
    ? str_replace('/var/www/html', '', $photoBrut)
    : $photoDefault;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <style>
        /* Styles CSS ici */
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .welcome-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .user-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .user-details {
            text-align: left;
            margin-top: 20px;
        }

        .user-details p {
            margin: 5px 0;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <?php if ($photo !== $photoDefault): ?>
        <img src="<?php echo $photo; ?>" alt="Photo de profil" class="user-photo">
    <?php endif; ?>
    <h1>Bienvenue, <?php echo $prenom . ' ' . $nom; ?>!</h1>
    <p>Nous sommes ravis de vous voir ici.</p>

    <div class="user-details">
        <p><strong>Email :</strong> <?php echo $email; ?></p>
        <p><strong>Niveau :</strong> <?php echo $niveau; ?></p>
    </div>

    <form method="post">
        <button type="submit" name="deconnexion">Se déconnecter</button>
    </form>
</div>

</body>
</html>