<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/header.php';
include '../config/db.php';
include '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Email e senha são obrigatórios.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $token = criar_jwt($usuario['id']);
            setcookie("jwt", $token, time() + (86400 * 30), "/");
            echo "Login bem-sucedido!";
        } else {
            echo "Email ou senha inválidos.";
        }
    } else {
        echo "Erro na execução da consulta.";
    }
}
?>

<h1>Login</h1>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <br>
    <button type="submit">Login</button>
</form>

<?php include '../includes/footer.php'; ?>
