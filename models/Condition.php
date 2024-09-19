<?php
namespace App\Models;

class Condition extends CRUD {
    protected $table = '`condition`'; 
    protected $primaryKey = 'id_condition';
    protected $fillable = ['nom_condition'];
}
