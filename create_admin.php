<?php
require_once './vendor/autoload.php';

use App\Models\User;

$user = new User();
$email = 'admin@example.com';
$password = '12345';

if ($user->createAdmin($email, $password)) {
    echo "Administrateur créé avec succès.";
} else {
    echo "Échec de la création de l'administrateur.";
}
