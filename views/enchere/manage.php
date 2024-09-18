{{ include('layouts/header.php', {title:'Gérer les enchères'}) }}
<div class="container">
    <h2 class="mb-4">Gérer les enchères</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Prix plancher</th>
                <th>Coup de cœur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {% for enchere in encheres %}
                <tr>
                    <td>{{ enchere.id_Enchere }}</td>
                    <td>{{ enchere.date_debut }}</td>
                    <td>{{ enchere.date_fin }}</td>
                    <td>{{ enchere.prix_plancher }}</td>
                    <td>{{ enchere.coup_de_coeur ? 'Oui' : 'Non' }}</td>
                    <td>
                        <a href="/enchere/edit/{{ enchere.id_Enchere }}" class="btn btn-warning">Modifier</a>
                        <form action="/enchere/delete-enchere/{{ enchere.id_Enchere }}" method="post" style="display:inline;">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
{{ include('layouts/footer.php') }}
