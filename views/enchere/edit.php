{{ include('layouts/header.php', {title:'Modifier l\'enchère'}) }}
<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="card border-light bg-light mb-4">  
            <div class="card-body">
                <form method="post" action="{{ base }}/enchere/update">
                    <h2>Modifier l'enchère</h2>
                    {% if errors %}
                        <div class="alert alert-danger">
                            <ul>
                                {% for error in errors %}
                                    <li>{{ error }}</li>
                                {% endfor %}
                            </ul>
                        </div>
                    {% endif %}
                    <div class="form-group">
                        <label for="date_debut">Date de début</label>
                        <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" value="{{ enchere.date_debut }}" required>
                    </div>
                    <div class="form-group">
                        <label for="date_fin">Date de fin</label>
                        <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" value="{{ enchere.date_fin }}" required>
                    </div>
                    <div class="form-group">
                        <label for="prix_plancher">Prix plancher</label>
                        <input type="number" class="form-control" id="prix_plancher" name="prix_plancher" value="{{ enchere.prix_plancher }}" required>
                    </div>
                    {% if isAdmin %}
                    <div class="form-group">
                        <label for="coup_de_coeur">Coup de cœur</label>
                        <select class="form-control" id="coup_de_coeur" name="coup_de_coeur">
                            <option value="1" {{ enchere.coup_de_coeur ? 'selected' : '' }}>Oui</option>
                            <option value="0" {{ not enchere.coup_de_coeur ? 'selected' : '' }}>Non</option>
                        </select>
                    </div>
                    {% endif %}
                    <input type="hidden" name="id" value="{{ enchere.id_Enchere }}">
                    <button type="submit" class="btn btn-outline-primary btn-block">Enregistrer les modifications</button>
                </form>
            </div>
        </div>  
    </div>  
</div>  
{{ include('layouts/footer.php') }}
