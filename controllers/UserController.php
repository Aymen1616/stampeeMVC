<?php
namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

class UserController {

    public function __construct(){
        Auth::session();
    }

    public function create() {
        return View::render('user/create');
    }

    public function store($data) {
        $validator = new Validator;
        $validator->field('nom_Utilisateur', $data['nom'])->required()->max(50);
        $validator->field('mot_de_passe_Utilisateur', $data['mot_de_passe'])->min(5)->max(20);
        $validator->field('email_Utilisateur', $data['email'])->email()->required()->max(50)->isUnique('User');
    
        if ($validator->isSuccess()) {
            $user = new User;
            $data['nom_Utilisateur'] = $data['nom'];
            $data['mot_de_passe_Utilisateur'] = $user->hashPassword($data['mot_de_passe']);
            $data['id_privilege'] = 2; 
            $data['email_Utilisateur'] = $data['email'];
            $insert = $user->insert($data);
            if ($insert) {
                return View::redirect('auth/login');
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('user/create', ['errors' => $errors, 'user' => $data]);
        }
    }


    public function manageUsers() {
        $user = new User;
        $users = $user->select();
        return View::render('user/manage', ['users' => $users]);
    }

    public function deleteUser($data) {
        if ($_SESSION['privilege_id'] == 1) { 
            $user = new User;
            $delete = $user->delete($data['id']);
            if ($delete) {
                return View::redirect('user/manage-users');
            } else {
                return View::render('error', ['message' => 'Erreur lors de la suppression de l\'utilisateur.']);
            }
        } else {
            return View::render('error', ['msg' => 'Vous n\'avez pas les privilèges nécessaires pour supprimer un utilisateur.']);
        }
    }
    
    
}
