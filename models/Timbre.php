<?php
namespace App\Models;

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id_Timbre';
    protected $fillable = ['nom_Timbre', 'couleur_Timbre', 'pays_origine_Timbre', 'tirage_Timbre', 'dimensions_Timbre', 'certifie_Timbre', 'id_Utilisateur', 'id_Enchere', 'id_condition'];
}
