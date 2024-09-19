<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Models\Condition; 
use App\Models\Timbre; 
use App\Models\Image;
use App\Providers\View;
use App\Providers\Validator;

class EnchereController {

    public function create() {
        $condition = new Condition;
        $conditions = $condition->select();
        return View::render('enchere/create', ['conditions' => $conditions]);
    }
    

    public function store($data) {
        $validator = new Validator;
        $validator->field('date_debut', $data['date_debut'])->required();
        $validator->field('date_fin', $data['date_fin'])->required();
        $validator->field('prix_plancher', $data['prix_plancher'])->required();
    
        if ($validator->isSuccess()) {
            $data['id_Utilisateur'] = $_SESSION['user_id']; // Assigner l'utilisateur actuel
            $enchere = new Enchere;
            $insert = $enchere->insert($data);
            if ($insert) {
                // Ajouter le timbre
                $timbreData = [
                    'nom_Timbre' => $data['nom_Timbre'],
                    'couleur_Timbre' => $data['couleur_Timbre'],
                    'pays_origine_Timbre' => $data['pays_origine_Timbre'],
                    'tirage_Timbre' => $data['tirage_Timbre'],
                    'dimensions_Timbre' => $data['dimensions_Timbre'],
                    'certifie_Timbre' => $data['certifie_Timbre'],
                    'id_Utilisateur' => $_SESSION['user_id'],
                    'id_Enchere' => $insert,
                    'id_condition' => $data['id_condition']
                ];
                $timbre = new Timbre;
                $timbreInsert = $timbre->insert($timbreData);
    
                // Ajouter les images
                if ($timbreInsert && isset($_FILES['images'])) {
                    $images = $_FILES['images'];
                    for ($i = 0; $i < count($images['name']); $i++) {
                        $imageName = time() . '_' . $images['name'][$i];
                        $imagePath = 'uploads/' . $imageName;
                        move_uploaded_file($images['tmp_name'][$i], $imagePath);
    
                        $imageData = [
                            'nom_image' => $imageName,
                            'type_image' => $images['type'][$i],
                            'id_Timbre' => $timbreInsert,
                            'is_main' => $i == 0 ? 1 : 0 
                        ];
                        $image = new Image;
                        $image->insert($imageData);
                    }
                }
    
                return View::redirect('enchere/manage-encheres');
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('enchere/create', ['errors' => $errors, 'enchere' => $data]);
        }
    }
    
    
    public function update($data, $id) {
        $validator = new Validator;
        $validator->field('date_debut', $data['date_debut'])->required();
        $validator->field('date_fin', $data['date_fin'])->required();
        $validator->field('prix_plancher', $data['prix_plancher'])->required();
    
        if ($validator->isSuccess()) {
            $data['id_Utilisateur'] = $_SESSION['user_id']; 
            $enchere = new Enchere;
            $update = $enchere->update($data, $id);
            if ($update) {
                return View::redirect('enchere/manage-encheres');
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('enchere/edit', ['errors' => $errors, 'enchere' => $data]);
        }
    }
    

    public function manageEncheres() {
        $enchere = new Enchere;
        $encheres = $enchere->selectWithTimbre();
        for ($i = 0; $i < count($encheres); $i++) {
            $encheres[$i]['main_image'] = '';
            if (isset($encheres[$i]['id_Timbre']) && !empty($encheres[$i]['id_Timbre'])) {
                $image = new Image;
                $mainImage = $image->where('id_Timbre', $encheres[$i]['id_Timbre']);
                if ($mainImage) {
                    $encheres[$i]['main_image'] = $mainImage['nom_image'];
                }
            } 

        }
    
        return View::render('enchere/manage', ['encheres' => $encheres]);
    }
    
    
    


    public function deleteEnchere($id) {
        $enchere = new Enchere;
        if ($enchere->delete($id)) {
            return View::redirect('enchere/manage-encheres');
        } else {
            return View::render('error', ['message' => 'Erreur lors de la suppression de l\'enchère.']);
        }
    }

    public function edit($id) {
        $enchere = new Enchere;
        $data = $enchere->selectId($id);
        return View::render('enchere/edit', ['enchere' => $data]);
    }


}
