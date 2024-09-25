<?php
namespace App\Models;

use App\Models\CRUD;

class User extends CRUD {
    protected $table = "utilisateur";
    protected $primaryKey = "id_Utilisateur";
    protected $fillable = [ 'nom_Utilisateur','mot_de_passe_Utilisateur','email_Utilisateur', 'id_privilege'];
    private $salt = "H4@1&";

    public function hashPassword($password, $cost = 10){
        $options = [
            'cost' => $cost
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function checkuser($email, $password) {
        $user = $this->unique('email_Utilisateur', $email);
        if ($user) {
            if(password_verify($password, $user['mot_de_passe_Utilisateur'])) {
                session_regenerate_id();
                $_SESSION['user_id'] = $user['id_Utilisateur'];
                $_SESSION['nom'] = $user['nom_Utilisateur'];
                $_SESSION['email'] = $user['email_Utilisateur'];
                $_SESSION['password'] = $password;
                $_SESSION['privilege_id'] = $user['id_Privilege'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    

    public function createAdmin($email, $password) {
        $hashed_password = $this->hashPassword($password);
        $data = [
            'nom_Utilisateur' => $nom,
            'email_Utilisateur' => $email,
            'mot_de_passe_Utilisateur' => $hashed_password,
            'id_privilege' => 1 
        ];

        return $this->insert($data);
    }
}
