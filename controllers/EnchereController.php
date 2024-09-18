<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Providers\View;
use App\Providers\Validator;

class EnchereController {

    public function create() {
        return View::render('enchere/create');
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
        $validator->field('prix_plancher', $data['prix_plancher'])->required()->numeric();
    
        if ($validator->isSuccess()) {
            $data['id_Utilisateur'] = $_SESSION['user_id']; // Assigner l'utilisateur actuel
            $enchere = new Enchere;
            $update = $enchere->update($data, $id);
            if ($update) {
                return View::redirect('manage-encheres');
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
        $encheres = $enchere->select();
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
