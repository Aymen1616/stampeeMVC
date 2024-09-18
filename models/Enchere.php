<?php
namespace App\Models;

class Enchere extends CRUD {
    protected $table = 'enchere';
    protected $primaryKey = 'id_Enchere';
    protected $fillable = ['date_debut', 'date_fin', 'prix_plancher', 'coup_de_coeur', 'id_Utilisateur'];
}

