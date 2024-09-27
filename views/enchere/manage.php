{{ include('layouts/header.php', {title: session.privilege_id == 1 ? 'Gérer les enchères' : 'Listes d\'enchères'}) }}
<h2 class="mb-4">{{ session.privilege_id == 1 ? 'Gérer les enchères' : 'Listes d\'enchères' }}</h2>
<div class="container">
    {% if session.message is defined %}
        <div class="alert alert-success">
            {{ session.message }}
        </div>
        {% set session = session|merge({'message': null}) %}
    {% endif %}
    
    {% if session.privilege_id != 1 %}
    <div class="row">
        <div class="col-md-3">
            <form method="get" action="{{ base }}/enchere/filter">
                <div class="mb-4">
                    <label for="prix_plancher"><strong>Prix plancher</strong></label>
                    <select id="prix_plancher" name="prix_plancher" class="form-control">
                        <option value="">Sélectionner</option>
                        <option value="asc" {% if session.filters.prix_plancher == 'asc' %}selected{% endif %}>Croissant</option>
                        <option value="desc" {% if session.filters.prix_plancher == 'desc' %}selected{% endif %}>Décroissant</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="date_publication"><strong>Date de publication</strong></label>
                    <select id="date_publication" name="date_publication" class="form-control">
                        <option value="">Sélectionner</option>
                        <option value="asc" {% if session.filters.date_publication == 'asc' %}selected{% endif %}>De l'ancien au nouveau</option>
                        <option value="desc" {% if session.filters.date_publication == 'desc' %}selected{% endif %}>Du nouveau à l'ancien</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="condition"><strong>Condition du timbre</strong></label>
                    <select id="condition" name="condition" class="form-control">
                        <option value="">Sélectionner</option>
                        <option value="parfaite" {% if session.filters.condition == 'parfaite' %}selected{% endif %}>Parfaite</option>
                        <option value="excellente" {% if session.filters.condition == 'excellente' %}selected{% endif %}>Excellente</option>
                        <option value="bonne" {% if session.filters.condition == 'bonne' %}selected{% endif %}>Bonne</option>
                        <option value="moyenne" {% if session.filters.condition == 'moyenne' %}selected{% endif %}>Moyenne</option>
                        <option value="endommagée" {% if session.filters.condition == 'endommagée' %}selected{% endif %}>Endommagée</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="pays_origine"><strong>Pays d'origine</strong></label>
                    <select id="pays_origine" name="pays_origine[]" class="form-control" >
                    <option value="">Sélectionner</option>
                        <option value="Canada" {% if 'Canada' in session.filters.pays_origine %}selected{% endif %}>Canada</option>
                        <option value="Australie" {% if 'Australie' in session.filters.pays_origine %}selected{% endif %}>Australie</option>
                        <option value="Angleterre" {% if 'Angleterre' in session.filters.pays_origine %}selected{% endif %}>Angleterre</option>
                        <option value="Etats-Unis" {% if 'Etats-Unis' in session.filters.pays_origine %}selected{% endif %}>États-Unis</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>
        <div class="col-md-9">
            <div class="row">
                {% for enchere in encheres %}
                    <div class="col-md-4 ">
                        <div class="card">
                            <img src="{{ base }}/uploads/{{ enchere.main_image }}" class="card-img-top" alt="Image principale">
                            <div class="card-body">
                                <p class="card-text"><strong>Date de début:</strong> {{ enchere.date_debut }}</p>
                                <p class="card-text"><strong>Date de fin:</strong> {{ enchere.date_fin }}</p>
                                <p class="card-text"><strong>Prix plancher:</strong> {{ enchere.prix_plancher }}$</p>
                                <p class="card-text"><strong>Coup de cœur:</strong> {{ enchere.coup_de_coeur ? 'Oui' : 'Non' }}</p>
                                <a href="{{ base }}/enchere/show?id={{ enchere.id_Enchere }}" class="btn btn-info">Voir</a>
                                {% if session.privilege_id == 1 %}
                                    <a href="{{ base }}/enchere/edit?id={{ enchere.id_Enchere }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ base }}/enchere/delete" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="{{ enchere.id_Enchere }}">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>
    {% else %}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                {% for enchere in encheres %}
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ base }}/uploads/{{ enchere.main_image }}" class="card-img-top" alt="Image principale">
                            <div class="card-body">
                                <p class="card-text"><strong>Date de début:</strong> {{ enchere.date_debut }}</p>
                                <p class="card-text"><strong>Date de fin:</strong> {{ enchere.date_fin }}</p>
                                <p class="card-text"><strong>Prix plancher:</strong> {{ enchere.prix_plancher }}$</p>
                                <p class="card-text"><strong>Coup de cœur:</strong> {{ enchere.coup_de_coeur ? 'Oui' : 'Non' }}</p>
                                <a href="{{ base }}/enchere/show?id={{ enchere.id_Enchere }}" class="btn btn-info">Voir</a>
                                {% if session.privilege_id == 1 %}
                                    <a href="{{ base }}/enchere/edit?id={{ enchere.id_Enchere }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ base }}/enchere/delete" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="{{ enchere.id_Enchere }}">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>
    {% endif %}
</div>
{{ include('layouts/footer.php') }}
