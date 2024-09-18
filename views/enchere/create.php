{{ include('layouts/header.php', {title:'Ajouter une enchère'}) }}
<div class="container">
    <h2 class="mb-4">Ajouter une enchère</h2>
    <form action="{{ base }}/enchere/create" method="post">
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
        <div class="form-group">
            <label for="coup_de_coeur">Coup de cœur</label>
            <input type="checkbox" id="coup_de_coeur" name="coup_de_coeur" value="1">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
{{ include('layouts/footer.php') }}
