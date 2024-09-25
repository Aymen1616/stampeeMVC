<?php
namespace App\Models;

class Image extends CRUD {
    protected $table = 'image';
    protected $primaryKey = 'id_image';
    protected $fillable = ['nom_image', 'type_image', 'id_Timbre', 'is_main'];

    public function whereSingle($column, $value) {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1";
        $stmt = $this->prepare($query);
        $stmt->execute([$value]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function whereAll($column, $value) {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        $stmt = $this->prepare($query);
        $stmt->execute([$value]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
}
