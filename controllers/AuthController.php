<?php
namespace App\Controllers;

use App\Models\Enchere;
use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;

class AuthController {
    public function index() {
        View::render('auth/index');
    }

    public function store($data) {
        $validator = new Validator;
    
        if (!isset($data['email']) || !isset($data['mot_de_passe'])) {
            $errors['message'] = "Veuillez remplir tous les champs";
            return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
        }
    
        $validator->field('email_Utilisateur', $data['email'])->email()->required()->max(50);
        $validator->field('mot_de_passe_Utilisateur', $data['mot_de_passe'])->min(5)->max(20);
    
        if ($validator->isSuccess()) {
            $user = new User;
            $checkuser = $user->checkuser($data['email'], $data['mot_de_passe']);
            if ($checkuser) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['email'] = $data['email'];
                $_SESSION['password'] = $data['mot_de_passe'];
                $_SESSION['nom'] = $user->unique('email_Utilisateur', $data['email'])['nom_Utilisateur']; 
                $_SESSION['privilege_id'] = $user->unique('email_Utilisateur', $data['email'])['id_Privilege'];
                
                if ($_SESSION['privilege_id'] == 1) {
                    return View::redirect('user/manage-users');
                } else {
                    return $this->profil();
                }
            } else {
                $errors['message'] = "Veuillez vérifier vos identifiants";
                return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('auth/index', ['errors' => $errors, 'user' => $data]);
        }
    }
    

    public function profil() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = new User;
        $userData = $user->unique('email_Utilisateur', $_SESSION['email']);
        
        $enchere = new Enchere;
        $encheres = $enchere->selectWithTimbreByUser($_SESSION['user_id']);
        
        return View::render('user/profil', ['user' => $userData, 'encheres' => $encheres]);
    }
    
    
    

    public function delete() {
        session_destroy();
        return View::redirect('login');
    }
}
