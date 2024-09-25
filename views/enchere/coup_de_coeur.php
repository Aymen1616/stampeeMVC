{{ include('layouts/header.php', {title:'Coup de cœur'}) }}
<div class="container">
    <h2 class="mb-4">Coup de cœur</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Prix plancher</th>
                <th>Nom du Timbre</th>
                <th>Image principale</th>
            </tr>
        </thead>
        <tbody>
            {% for enchere in encheres %}
                <tr>
                    <td>{{ enchere.id_Enchere }}</td>
                    <td>{{ enchere.date_debut }}</td>
                    <td>{{ enchere.date_fin }}</td>
                    <td>{{ enchere.prix_plancher }}</td>
                    <td>{{ enchere.nom_Timbre }}</td>
                    <td>
                        <img src="{{ base }}/uploads/{{ enchere.main_image }}" alt="Image principale" width="100">
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
{{ include('layouts/footer.php') }}
