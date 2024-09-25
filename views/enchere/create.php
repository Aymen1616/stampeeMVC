{{ include('layouts/header.php', {title:'Ajouter une enchère'}) }}
<div class="container">
    <h2 class="mb-4">Ajouter une enchère</h2>
    <form action="{{ base }}/enchere/create" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required>
        </div>
        <div class="form-group">
            <label for="prix_plancher">Prix plancher</label>
            <input type="number" step="5" class="form-control" id="prix_plancher" name="prix_plancher" required>
        </div>
        {% if isAdmin %}
        <div class="form-group">
            <label for="coup_de_coeur">Coup de cœur</label>
            <select class="form-control" id="coup_de_coeur" name="coup_de_coeur">
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>
    {% endif %}
        <h3 class="mt-4">Ajouter un timbre</h3>
        <div class="form-group">
            <label for="nom_Timbre">Nom du timbre</label>
            <input type="text" class="form-control" id="nom_Timbre" name="nom_Timbre" required>
        </div>
        <div class="form-group">
            <label for="couleur_Timbre">Couleur du timbre</label>
            <input type="text" class="form-control" id="couleur_Timbre" name="couleur_Timbre" required>
        </div>
        <div class="form-group">
            <label for="pays_origine_Timbre">Pays d'origine</label>
            <input type="text" class="form-control" id="pays_origine_Timbre" name="pays_origine_Timbre" required>
        </div>
        <div class="form-group">
            <label for="tirage_Timbre">Tirage</label>
            <input type="text" class="form-control" id="tirage_Timbre" name="tirage_Timbre" required>
        </div>
        <div class="form-group">
            <label for="dimensions_Timbre">Dimensions</label>
            <input type="text" class="form-control" id="dimensions_Timbre" name="dimensions_Timbre" required>
        </div>
        <div class="form-group">
            <label for="certifie_Timbre">Certifié</label>
            <input type="checkbox" id="certifie_Timbre" name="certifie_Timbre" value="1">
        </div>
        <div class="form-group">
            <label for="id_condition">Condition</label>
            <select class="form-control" id="id_condition" name="id_condition" required>
                {% for condition in conditions %}
                    <option value="{{ condition.id_condition }}">{{ condition.nom_condition }}</option>
                {% endfor %}
            </select>
        </div>
        <h3 class="mt-4">Ajouter des images</h3>
        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<!-- {{ include('layouts/footer.php') }} -->
