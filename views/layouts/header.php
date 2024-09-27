<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    
    <!-- Lien vers le fichier CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset }}css/style.css">
</head>
<body >
<nav class="boite-nav">
        <a href="#"><img class="logo" src="../public/img/logoStampee-2-alt.png" alt="logo" loading="lazy"></a>
        <div class="boite-pages">

        {% if session.privilege_id is defined and session.privilege_id == 1 %}
            <a href="{{ base }}/user/manage-users"> Utilisateurs</a>
            <a href="{{ base }}/enchere/manage-encheres">Les enchères</a>
        {% endif %}
        
        {% if guest %}
            <a href="{{ base }}/user/create">Inscription</a>
            <a href="{{ base }}/auth/login">Login</a>
        {% else %}
            {% if session.privilege_id != 1 %}
                <a href="{{ base }}/user/profil">Profil</a>
                <a href="{{ base }}/enchere/manage">Enchères</a>

            {% endif %}
            <a href="{{ base }}/enchere/coup-de-coeur">Coup de cœur</a>
            <a href="{{ base }}/logout">Logout</a>
        {% endif %}
        </div>
        <div class="section-droite">
            <div class="recherche">
                <input type="text" placeholder="Recherche...">
                <img class="icone-recherche" src="../public/img/svg/search.svg" alt="icone de recherche">
            </div>
            <img class="icone-connexion" src="../public/img/svg/flaticon account.svg" alt="icone de connexion">
        </div>
    </nav>


<main>
    {% if guest is empty %}
        {% if session.privilege_id == 1 %}
            Hello Admin!
        {% endif %}
    {% endif %}
</main>
</body>
</html>
