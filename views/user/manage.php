{{ include('layouts/header.php', {title:'Gérer les utilisateurs'})}}
<div class="container">
    <h2 class="mb-4">Liste des utilisateurs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Privilège</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
                <tr>
                    <td>{{ user.id_Utilisateur }}</td>
                    <td>{{ user.email_Utilisateur }}</td>
                    <td>{{ user.id_Privilege }}</td>
                    <td>
                    <form action="{{ base }}/user/delete-user" method="post">
                        <input type="hidden" name="id" value="{{ user.id_Utilisateur }}">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
{{ include('layouts/footer.php')}}
