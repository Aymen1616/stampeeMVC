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
        $sql = "SELECT e.*, t.id_Timbre, i.nom_image AS main_image FROM $this->table e
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function selectWithTimbreByUser($userId) {
        $sql = "SELECT e.*, t.nom_Timbre, i.nom_image AS main_image FROM $this->table e
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                WHERE e.id_Utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
     
    
    public function selectCoupDeCoeur() {
        $sql = "SELECT e.*, t.nom_Timbre, i.nom_image AS main_image FROM $this->table e
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                WHERE e.coup_de_coeur = 1";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectDetails($id) {
        $sql = "SELECT e.*, t.*, i.nom_image AS main_image FROM $this->table e
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                WHERE e.id_Enchere = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function selectImages($id) {
        $sql = "SELECT * FROM image WHERE id_Timbre = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function selectCondition($id) {
        $sql = "SELECT nom_condition FROM `condition` WHERE id_condition = :id";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function addToFavorites($enchereId, $userId) {
        $sql = "INSERT INTO favoris (id_Enchere, id_Utilisateur, statut) VALUES (:enchereId, :userId, 1)";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchereId', $enchereId);
        $stmt->bindValue(':userId', $userId);
        return $stmt->execute();
    }

    public function removeFromFavorites($enchereId, $userId) {
        $sql = "DELETE FROM favoris WHERE id_Enchere = :enchereId AND id_Utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchereId', $enchereId);
        $stmt->bindValue(':userId', $userId);
        return $stmt->execute();
    }

    public function getFavoritesByUser($userId) {
        $sql = "SELECT e.*, t.nom_Timbre, i.nom_image AS main_image FROM favoris f
                LEFT JOIN enchere e ON f.id_Enchere = e.id_Enchere
                LEFT JOIN timbre t ON e.id_Enchere = t.id_Enchere
                LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                WHERE f.id_Utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function isFavorite($enchereId, $userId) {
        $sql = "SELECT COUNT(*) FROM favoris WHERE id_Enchere = :enchereId AND id_Utilisateur = :userId";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':enchereId', $enchereId);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getFilteredEncheres($prixPlancher, $datePublication, $condition, $paysOrigine)
    {
        $query = "SELECT e.*, t.pays_origine_Timbre, c.nom_condition, i.nom_image AS main_image
                  FROM enchere e
                  JOIN timbre t ON e.id_Enchere = t.id_Enchere
                  JOIN `condition` c ON t.id_condition = c.id_condition
                  LEFT JOIN image i ON t.id_Timbre = i.id_Timbre AND i.is_main = 1
                  WHERE 1=1";

        $params = [];

        if ($condition) {
            $query .= " AND c.nom_condition = :condition";
            $params[':condition'] = $condition;
        }

        if ($paysOrigine && !empty($paysOrigine[0])) {
            $query .= " AND t.pays_origine_Timbre IN (" . implode(',', array_map(function($pays) { return "'$pays'"; }, $paysOrigine)) . ")";
        }

        $orderByClauses = [];
        if ($prixPlancher) {
            $orderByClauses[] = "e.prix_plancher " . ($prixPlancher == 'asc' ? 'ASC' : 'DESC');
        }

        if ($datePublication) {
            $orderByClauses[] = "e.date_debut " . ($datePublication == 'asc' ? 'ASC' : 'DESC');
        }

        if (!empty($orderByClauses)) {
            $query .= " ORDER BY " . implode(', ', $orderByClauses);
        }

        $stmt = $this->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    


}

