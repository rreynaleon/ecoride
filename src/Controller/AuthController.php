<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\UserRole;
use App\Repository\UserRoleRepository;

class AuthController extends Controller
{
    public function register()
    {
        $errors = [];

        if (isset($_POST) && !empty($_POST)) {
            // Récupération et nettoyage des données du formulaire qui arrivent via la superglobale $_POST
            $name = trim($_POST['name'] ?? '');
            $lastname = trim($_POST['lastname'] ?? '');
            $nickname = trim($_POST['nickname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $birthdate = $_POST['birthdate'] ?? null;
            $profileImage = null;
            $roles = $_POST['roles'] ?? []; // Récupérer les rôles sélectionnés

            // Verification que les rôles sont sélectionnés
            // var_dump($roles);
            // die;

            // Validation des données du formulaire (côté serveur)
            if (strlen($name) < 2) $errors[] = "Le prénom doit faire au moins 2 caractères.";
            if (strlen($lastname) < 2) $errors[] = "Le nom doit faire au moins 2 caractères.";
            if (strlen($nickname) < 3) $errors[] = "Le pseudo doit faire au moins 3 caractères.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide.";
            if (strlen($password) < 8) $errors[] = "Le mot de passe doit faire au moins 8 caractères.";
            if ($phone && !preg_match('/^0[1-9][0-9]{8}$/', $phone)) $errors[] = "Téléphone invalide.";
            if ($birthdate && (new DateTimeImmutable($birthdate) > new DateTimeImmutable())) $errors[] = "La date de naissance ne peut pas être dans le futur.";
            if (empty($roles)) $errors[] = "Veuillez sélectionner au moins un rôle.";

            // Vérification de l'unicité email/pseudo
            $userRepo = new UserRepository();
            if ($userRepo->findByEmail($email)) $errors[] = "Cet email existe déjà.";
            if ($userRepo->findByNickname($nickname)) $errors[] = "Ce pseudo existe déjà.";

            // Gestion de la photo de profil (optionnel)
            if (!empty($_FILES['profileImage']['name'])) {
                $file = $_FILES['profileImage'];
                if (strpos($file['type'], 'image/') !== 0) $errors[] = "Le fichier de profil doit être une image.";
                if ($file['size'] > 2 * 1024 * 1024) $errors[] = "La photo de profil ne doit pas dépasser 2 Mo.";
                if (empty($errors)) {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $profileImage = uniqid('profile_') . '.' . $ext;
                    move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/assets/uploads/' . $profileImage);
                }
            }

            // Si pas d’erreur, on crée l’utilisateur
            if (empty($errors)) {
                $user = new User();
                $user->setName($name);
                $user->setLastname($lastname);
                $user->setNickname($nickname);
                $user->setEmail($email);
                $user->setPassword($password); // UserRepository doit hasher le mot de passe
                $user->setPhone($phone);
                $user->setAddress($address);
                $user->setBirthdate($birthdate ? new \DateTimeImmutable($birthdate) : null);
                $user->setProfileImage($profileImage);

                $userId = $userRepo->save($user); // Doit retourner l’ID de l’utilisateur

                // Associer les rôles (ex : via UserRoleRepository)
                $userRoleRepo = new UserRoleRepository();
                if ($userId && is_int($userId)) {
                    foreach ($roles as $roleId) {
                        $userRoleRepo->addRoleToUser($userId, (int)$roleId);
                    }
                }

                // Redirection ou message de succès
                header('Location: /home');
                exit;
            }
        }

        // Affiche la vue après le traitement
        $this->render("register", [
            'errors' => $errors
        ]);
    }

    public function login()
    {
        $this->render("login");


        if (isset($_POST) && !empty($_POST)) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            var_dump($email, $password);
            die;
        }

    }

    public function logout()
    {
        $this->render("logout");
    }
}
