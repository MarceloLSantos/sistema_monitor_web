<?php
// ### app/controllers/AuthController.php
class AuthController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->usuarioModel->authenticate($email, $password);
            if ($user) {
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id_usuario'];
                header('Location: index.php?page=cadastro_proposta');
                exit;
            } else {
                $error = "Email ou senha inválidos";
            }
        }
        require './app/views/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>