{{ include('layouts/header.php', {title:'Profil'})}}
<div class="container d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="card border-light bg-light mb-4">  
            <div class="card-body">
                <h2 class="mb-4">Profil</h2>
                <p><strong>Email:</strong> {{ user.email_Utilisateur }}</p>
                <h3 class="mt-4">Ajouter une enchère</h3>
                <a href="{{ base }}/enchere/create" class="btn btn-primary btn-block">Ajouter une enchère</a>
            </div>
        </div>
    </div>
</div>
{{ include('layouts/footer.php')}}
