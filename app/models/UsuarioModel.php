<?php
// ### app/models/UsuarioModel.php
class UsuarioModel extends BaseModel {
    public function authenticate($email, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE email_usuario = :email AND senha_usuario = :password AND ativo = 1');
        $stmt->execute(['email' => $email, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) { // && password_verify($password, $user['senha_usuario'])) {
            return $user;
        }
        return false;
    }
}
?>