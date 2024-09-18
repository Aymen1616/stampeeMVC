<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }}</title>
    <link rel="stylesheet" href="{{ asset }}css/style.css">
    <!-- Lien vers le fichier CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light">
    <ul>
        {% if session.privilege_id is defined and session.privilege_id == 1 %}
            <li><a href="{{ base }}/user/manage-users">Gérer les utilisateurs</a></li>
        {% endif %}
        
        {% if guest %}
            <li><a href="{{ base }}/user/create">Inscription</a></li>
            <li><a href="{{ base }}/login">Login</a></li>
        {% else %}
            <li><a href="{{ base }}/logout">Logout</a></li>
        {% endif %}
    </ul>
</nav>

<main>
    {% if guest is empty %}
        {% if session.privilege_id == 1 %}
            Hello Admin!
        {% else %}
            Hello {{ session.email }}!
        {% endif %}
    {% endif %}
</main>
</body>
</html>
