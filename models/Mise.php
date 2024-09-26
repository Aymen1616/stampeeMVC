<?php
namespace App\Models;

class Mise extends CRUD {
    protected $table = 'mise';
    protected $primaryKey = 'id_mise';
    protected $fillable = ['id_Enchere', 'id_Utilisateur', 'prix_mise', 'date_mise'];

    public function selectByUser($userId) {
        $sql = "SELECT m.*, e.*, t.nom_Timbre, i.nom_image AS main_image FROM $this->table m
                LEFT JOIN enchere e ON m.id_Enchere = e.id_Enchere
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                WHERE m.id_Utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}
