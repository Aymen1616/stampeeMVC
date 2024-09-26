<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Models\Condition; 
use App\Models\Timbre; 
use App\Models\Image;
use App\Models\User;
use App\Models\Mise;

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
            $data['id_Utilisateur'] = $_SESSION['user_id'];
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
    
                return View::render('user/profil');
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('enchere/create', ['errors' => $errors, 'enchere' => $data]);
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


    public function delete($data) {
        if (!isset($data['id'])) {
            return View::render('error', ['message' => 'ID de l\'enchère non fourni.']);
        }
    
        $enchere = new Enchere;
        $enchereData = $enchere->selectId($data['id']);
    
        if (!$enchereData) {
            return View::render('error', ['message' => 'Enchère non trouvée.']);
        }
    
        if ($_SESSION['user_id'] != $enchereData['id_Utilisateur'] && $_SESSION['privilege_id'] != 1) {
            return View::render('error', ['message' => 'Vous n\'avez pas les privilèges nécessaires pour supprimer cette enchère.']);
        }
    
        // Supprimer les timbres associés
        $timbre = new Timbre;
        $timbres = $timbre->where('id_Enchere', $data['id'], false);
        foreach ($timbres as $t) {
            // Supprimer les images associées
            $image = new Image;
            $images = $image->where('id_Timbre', $t['id_Timbre'], false);
            foreach ($images as $img) {
                $image->delete($img['id_image']);
            }
            // Supprimer le timbre
            $timbre->delete($t['id_Timbre']);
        }
    
        // Supprimer l'enchère
        $delete = $enchere->delete($data['id']);
        if ($delete) {
            return View::redirect('user/profil');
        } else {
            return View::render('error', ['message' => 'Erreur lors de la suppression de l\'enchère.']);
        }
    }

    
    public function edit($data = []) {
        if ($_SESSION['privilege_id'] == 1 || isset($_GET['id'])) {
            $id = $_GET['id'];
            $enchere = new Enchere;
            $data = $enchere->selectId($id);
            
            if (!$data) {
                return View::render('error', ['message' => 'Enchère non trouvée.']);
            }
            
            if ($_SESSION['user_id'] != $data['id_Utilisateur'] && $_SESSION['privilege_id'] != 1) {
                return View::render('error', ['message' => 'Vous n\'avez pas les privilèges nécessaires pour modifier cette enchère.']);
            }
            
            $isAdmin = $_SESSION['privilege_id'] == 1;  
            return View::render('enchere/edit', ['enchere' => $data, 'isAdmin' => $isAdmin]);
        } else {
            return View::render('error', ['msg' => 'Vous n\'avez pas les privilèges nécessaires pour modifier cette enchère.']);
        }
    }
    
    
    public function update($data) {
        if ($_SESSION['privilege_id'] == 1 || isset($data['id'])) {
            $id = $data['id'];
            $validator = new Validator;
            $validator->field('date_debut', $data['date_debut'])->required();
            $validator->field('date_fin', $data['date_fin'])->required();
            $validator->field('prix_plancher', $data['prix_plancher'])->required();
    
            if ($validator->isSuccess()) {
                $data['id_Utilisateur'] = $_SESSION['user_id'];
                if ($_SESSION['privilege_id'] != 1) {
                    unset($data['coup_de_coeur']); 
                }
                $enchere = new Enchere;
                $update = $enchere->update($data, $id);
                if ($update) {
                    if ($_SESSION['privilege_id'] == 1) {
                        return View::redirect('enchere/manage-encheres');
                    } else {
                        return View::redirect('user/profil');
                    }
                } else {
                    return View::render('error');
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('enchere/edit', ['errors' => $errors, 'enchere' => $data]);
            }
        } else {
            return View::render('error', ['msg' => 'Vous n\'avez pas les privilèges nécessaires pour modifier cette enchère.']);
        }
    }
    
    
    public function showCoupDeCoeur() {
        $enchere = new Enchere;
        $coupDeCoeurEncheres = $enchere->selectCoupDeCoeur();
        return View::render('enchere/coup_de_coeur', ['encheres' => $coupDeCoeurEncheres]);
    } 
    

    public function show($data) {
        if (isset($data['id'])) {
            $id = $data['id'];
            $enchere = new Enchere;
            $details = $enchere->selectDetails($id);
            $images = $enchere->selectImages($details['id_Timbre']);
            return View::render('enchere/show', ['enchere' => $details, 'images' => $images]);
        } else {
            return View::render('error', ['message' => 'ID de l\'enchère non fourni.']);
        }
    }

    
    public function all() {
        $enchere = new Enchere;
        $encheres = $enchere->selectWithTimbre();
        return View::render('enchere/manage', ['encheres' => $encheres]);
    }
    
    
    public function placeBid($data) {
        $validator = new Validator;
        $validator->field('montant', $data['montant'])->required();
        
        if ($validator->isSuccess()) {
            $data['id_Utilisateur'] = $_SESSION['user_id'];
            $data['id_Enchere'] = $data['id_Enchere'];
            $data['prix_mise'] = $data['montant'];
            $data['date_mise'] = date('Y-m-d H:i:s');
            
            $mise = new Mise;
            $insert = $mise->insert($data);
            
            if ($insert) {
                return View::redirect('user/profil');
            } else {
                return View::render('error', ['message' => 'Erreur lors de la mise.']);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('enchere/show', ['errors' => $errors, 'enchere' => $data]);
        }
    }
    
    
}
