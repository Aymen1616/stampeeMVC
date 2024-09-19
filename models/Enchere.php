<?php
namespace App\Models;

class Enchere extends CRUD {
    protected $table = 'enchere';
    protected $primaryKey = 'id_Enchere';
    protected $fillable = ['date_debut', 'date_fin', 'prix_plancher', 'coup_de_coeur', 'id_Utilisateur'];

    public function selectWithTimbre($field = null, $order = 'ASC'){
        if($field == null){
            $field = $this->primaryKey;
        }
        $sql = "SELECT e.*, t.id_Timbre FROM $this->table e
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

