<?php
require_once './vendor/autoload.php';

use App\Models\User;

$user = new User();
$email = 'admin@example.com';
$password = '12345';
$nom = 'Admin'; 

if ($user->createAdmin($nom, $email, $password)) {
    echo "Administrateur créé avec succès.";
} else {
    echo "Échec de la création de l'administrateur.";
}
