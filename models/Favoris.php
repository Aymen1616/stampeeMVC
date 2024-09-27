<?php
namespace App\Models;

class Favoris extends CRUD {
    protected $table = 'favoris'; 
    protected $primaryKey = 'id_favoris';
    protected $fillable = ['id_Enchere', 'id_Utilisateur', 'statut'];
}
