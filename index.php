<?php
// This is a comprehensive response to the conversion request. I'll start with an evaluation of the database model, suggested adjustments, and then provide the full PHP code structure following MVC, clean code principles, Bootstrap for UI, and a RESTful API for reports.

// ### Database Evaluation and Adjustments
// The current database model is mostly solid for the requirements, but some improvements are needed for security, integrity, and API usability:
// 1. **Security**: Passwords in `usuario` are stored in plain text. We should hash them (e.g., using bcrypt). I'll include a note on how to update existing passwords.
// 2. **Data Integrity**: Add UNIQUE constraint to `num_proposta` in `fluxo_venda` to prevent duplicates.
// 3. **API Support**: No major changes needed, but ensure all queries use prepared statements to prevent SQL injection. For RESTful API, we'll expose data via JSON endpoints with authentication (e.g., API keys or session-based for simplicity).
// 4. **Other**: CPF is stored as char(11) without formatting, which is fine (strip masks on insert). Contacts are varchar(15), suitable for Brazilian phone numbers. Add timestamps where missing for auditing.

// Suggested SQL Adjustments (run these on your database):
/*
ALTER TABLE fluxo_venda ADD UNIQUE (num_proposta);
ALTER TABLE usuario MODIFY senha_usuario VARCHAR(255);  -- To accommodate hashed passwords

-- Hash existing passwords (example for user id 2, replace '@376420' with actual plain password if needed)
UPDATE usuario SET senha_usuario = '$2y$10$K.ExampleHashHere' WHERE id_usuario = 2;  -- Use password_hash() in PHP to generate.

-- If needed, add an API key table for secure API access (optional for advanced security):
CREATE TABLE api_keys (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  api_key VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES usuario(id_usuario)
);
*/

// ### PHP Project Structure
// Follows MVC pattern:
// - **Models**: Database interactions (e.g., ClienteModel.php).
// - **Views**: HTML templates with Bootstrap (e.g., cadastro_proposta.php).
// - **Controllers**: Business logic (e.g., PropostaController.php).
// - **Config**: Database connection (db.php).
// - **Public**: Entry points (index.php for app, api.php for REST API).
// - **Libs**: Any helpers (e.g., wa.php for WhatsApp, assuming a custom lib; replace with a real one like https://github.com/maykelsb/whatsapp-cloud-api).

// Clean Code: Use PDO for DB, prepared statements, OOP, meaningful names, separation of concerns.
// Bootstrap: v5.3 for responsive UI, with form validations (HTML5 + JS).
// Sidebar: Bootstrap offcanvas for mobile responsiveness.
// RESTful API: In api.php, endpoints like GET /api/propostas (returns JSON). Secured with session or API key (session for simplicity, matching app login).
// WhatsApp: Assuming 'wa.php' is a custom lib; I'll include a placeholder. In production, use an official API.

// Folder Structure:
// project/
// ├── app/
// │   ├── controllers/
// │   │   ├── AuthController.php
// │   │   ├── PropostaController.php
// │   ├── models/
// │   │   ├── BaseModel.php
// │   │   ├── ClienteModel.php
// │   │   ├── FluxoVendaModel.php
// │   │   ├── HistoricoMensagensModel.php
// │   │   ├── ProdutoModel.php
// │   │   ├── StatusClienteModel.php
// │   │   ├── StatusFaturaModel.php
// │   │   ├── UsuarioModel.php
// │   │   ├── VendedorModel.php
// │   ├── views/
// │   │   ├── layouts/
// │   │   │   └── main.php  (includes sidebar)
// │   │   ├── partials/
// │   │   │   └── sidebar.php
// │   │   ├── login.php
// │   │   ├── cadastro_proposta.php
// │   │   ├── atualizar_proposta.php
// │   │   ├── listar_propostas.php
// ├── config/
// │   └── db.php
// ├── libs/
// │   └── wa.php  (placeholder for WhatsApp sender)
// ├── public/
// │   ├── index.php  (main app router)
// │   ├── api.php    (REST API endpoint)
// │   ├── css/
// │   │   └── custom.css  (optional overrides)
// │   ├── js/
// │   │   └── scripts.js  (form validations)
// │   └── img/
// │       └── logo_empresa.png
// ├── .env  (for DB credentials, use dotenv if needed)
// └── .htaccess  (for clean URLs, optional)
?>

<?php
// ### public/index.php (router)
session_start();
if (!isset($_SESSION['logged_in']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}

require 'config/db.php';
require 'app/models/BaseModel.php';  // Autoload if possible
require 'app/models/ClienteModel.php';
require 'app/models/FluxoVendaModel.php';
require 'app/models/HistoricoMensagensModel.php';
require 'app/models/ProdutoModel.php';
require 'app/models/usuarioModel.php';
require 'app/controllers/AuthController.php';
require 'app/controllers/PropostaController.php';
require 'libs/wa.php';  // WhatsApp library (placeholder)
// Require other models and controllers as needed

$page = $_GET['page'] ?? 'listar_propostas';

$authController = new AuthController();
$propostaController = new PropostaController();

switch ($page) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'cadastro_proposta':
        $propostaController->cadastro();
        break;
    case 'atualizar_proposta':
        $propostaController->atualizar();
        break;
    case 'listar_propostas':
        $propostaController->listar();
        break;
    case 'excluir_proposta':
        $propostaController->excluir();
        break;
    default:
        echo "Página não encontrada";
}
?>