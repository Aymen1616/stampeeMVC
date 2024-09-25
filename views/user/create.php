{{ include('layouts/header.php', {title:'Inscription'})}}
<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="card border-light bg-light mb-4">  
            <div class="card-body">
                <form method="post">
                    <h2 class="mb-4">S'inscrire</h2>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ user.nom }}">
                        {% if errors.nom_Utilisateur is defined %}
                            <div class="error">{{ errors.nom_Utilisateur }}</div>
                        {% endif %}
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
                        {% if errors.mot_de_passe_Utilisateur is defined %}
                            <div class="error">{{ errors.mot_de_passe_Utilisateur }}</div>
                        {% endif %}
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ user.email }}">
                        {% if errors.email_Utilisateur is defined %}
                            <div class="error">{{ errors.email_Utilisateur }}</div>
                        {% endif %}
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="Enregistrer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{ include('layouts/footer.php')}}
