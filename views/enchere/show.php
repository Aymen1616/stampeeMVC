{{ include('layouts/header.php', {title:'Détails de l\'enchère'}) }}
<div class="container">
    <h2 class="mb-4">Détails de l'enchère</h2>
    <div class="row">
        <div class="col-md-6">
            <img id="main-image" src="{{ base }}/uploads/{{ enchere.main_image }}" alt="Image principale" >
            <div class="mt-4">
                {% for image in images %}
                    <img src="{{ base }}/uploads/{{ image.nom_image }}" alt="Image"  width="100" onclick="document.getElementById('main-image').src='{{ base }}/uploads/{{ image.nom_image }}'">
                {% endfor %}
            </div>
        </div>
        <div class="col-md-6">
            <p><strong>Date de début:</strong> {{ enchere.date_debut }}</p>
            <p><strong>Date de fin:</strong> {{ enchere.date_fin }}</p>
            <p><strong>Prix plancher:</strong> {{ enchere.prix_plancher }}</p>
            <p><strong>Nom du Timbre:</strong> {{ enchere.nom_Timbre }}</p>
            <p><strong>Couleur:</strong> {{ enchere.couleur_Timbre }}</p>
            <p><strong>Pays d'origine:</strong> {{ enchere.pays_origine_Timbre }}</p>
            <p><strong>Tirage:</strong> {{ enchere.tirage_Timbre }}</p>
            <p><strong>Dimensions:</strong> {{ enchere.dimensions_Timbre }}</p>
            <p><strong>Certifié:</strong> {{ enchere.certifie_Timbre ? 'Oui' : 'Non' }}</p>
            <p><strong>Condition:</strong> {{ condition.nom_condition }}</p>


            {% if session.user_id != enchere.id_Utilisateur and session.privilege_id != 1 %}
                <!-- Formulaire pour placer une mise -->
                <form action="{{ base }}/enchere/addToFavorites" method="post" style="display:inline;">
        <input type="hidden" name="id_Enchere" value="{{ enchere.id_Enchere }}">
        <button type="submit" class="btn btn-primary">Ajouter aux favoris</button>
    </form>
                <form method="post" action="{{ base }}/enchere/place-bid">
                    <div class="form-group">
                        <label for="montant">Montant de la mise</label>
                        <input type="number" class="form-control" id="montant" name="montant" required>
                    </div>
                    <input type="hidden" name="id_Enchere" value="{{ enchere.id_Enchere }}">
                    <button type="submit" class="btn btn-primary">Placer la mise</button>
                </form>
            {% endif %}
        </div>
    </div>
</div>
{{ include('layouts/footer.php') }}

<script>
    // Ajouter un effet de zoom sur l'image principale
    document.getElementById('main-image').addEventListener('mouseover', function() {
        this.style.transform = 'scale(1.15)';
        this.style.transition = 'transform 0.5s ease';
    });

    document.getElementById('main-image').addEventListener('mouseout', function() {
        this.style.transform = 'scale(1)';
        this.style.transition = 'transform 0.5s ease';
    });
</script>
