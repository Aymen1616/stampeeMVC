<?php
namespace App\Models;

class Timbre extends CRUD {
    protected $table = 'timbre';
    protected $primaryKey = 'id_Timbre';
    protected $fillable = ['nom_Timbre', 'couleur_Timbre', 'pays_origine_Timbre', 'tirage_Timbre', 'dimensions_Timbre', 'certifie_Timbre', 'id_Utilisateur', 'id_Enchere', 'id_condition'];

    public function whereAll($column, $value) {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        $stmt = $this->prepare($query);
        $stmt->execute([$value]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
