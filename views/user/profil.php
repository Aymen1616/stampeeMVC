{{ include('layouts/header.php', {title:'Profil'}) }}
<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="card border-light bg-light mb-4">  
            <div class="card-body">
                <h2 class="mb-4">Profil</h2>
                {% if session.message is defined %}
                    <div class="alert alert-success">
                        {{ session.message }}
                    </div>
                    {% set session = session|merge({'message': null}) %}
                {% endif %}
                <p><strong>Nom:</strong> {{ user.nom_Utilisateur }}</p>
                <p><strong>Email:</strong> {{ user.email_Utilisateur }}</p>
                
                <h3 class="mt-4">Ajouter une enchère</h3>
                <a href="{{ base }}/enchere/create" class="btn btn-primary btn-block">Ajouter une enchère</a>
                
                <h3 class="mt-4">Mes enchères</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix plancher</th>
                            <th>Coup de cœur</th>
                            <th>Image principale</th>
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
                                    <img src="{{ base }}/uploads/{{ enchere.main_image }}" alt="Image principale" width="100">
                                </td>
                                <td>
                                    <a href="{{ base }}/enchere/show?id={{ enchere.id_Enchere }}" class="btn btn-info">Voir</a>
                                    <a href="{{ base }}/enchere/edit?id={{ enchere.id_Enchere }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ base }}/enchere/delete" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="{{ enchere.id_Enchere }}">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
                
                <h3 class="mt-4">Enchères sur lesquelles j'ai placé une mise</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix plancher</th>
                            <th>Montant de la mise</th>
                            <th>Nom du Timbre</th>
                            <th>Image principale</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for mise in mises %}
                            <tr>
                                <td>{{ mise.id_Enchere }}</td>
                                <td>{{ mise.date_debut }}</td>
                                <td>{{ mise.date_fin }}</td>
                                <td>{{ mise.prix_plancher }}</td>
                                <td>{{ mise.prix_mise }}</td>
                                <td>{{ mise.nom_Timbre }}</td>
                                <td>
                                    <img src="{{ base }}/uploads/{{ mise.main_image }}" alt="Image principale" width="100">
                                </td>
                                <td>
                                    <a href="{{ base }}/enchere/show?id={{ mise.id_Enchere }}" class="btn btn-info">Voir</a>
                                </td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
                
                <h3 class="mt-4">Enchères favorites</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix plancher</th>
                            <th>Nom du Timbre</th>
                            <th>Image principale</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for favorite in favorites %}
                            <tr>
                                <td>{{ favorite.id_Enchere }}</td>
                                <td>{{ favorite.date_debut }}</td>
                                <td>{{ favorite.date_fin }}</td>
                                <td>{{ favorite.prix_plancher }}</td>
                                <td>{{ favorite.nom_Timbre }}</td>
                                <td>
                                    <img src="{{ base }}/uploads/{{ favorite.main_image }}" alt="Image principale" width="100">
                                </td>
                                <td>
                                    <a href="{{ base }}/enchere/show?id={{ favorite.id_Enchere }}" class="btn btn-info">Voir</a>
                                    <form action="{{ base }}/enchere/removeFromFavorites" method="post" style="display:inline;">
                                        <input type="hidden" name="id_Enchere" value="{{ favorite.id_Enchere }}">
                                        <button type="submit" class="btn btn-danger">Retirer des favoris</button>
                                    </form>
                                </td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{ include('layouts/footer.php') }}
