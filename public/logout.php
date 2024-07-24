<?php
include '../includes/header.php';
include '../includes/auth.php';

check_login();

$jwt_data = verificar_jwt($_COOKIE['jwt']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    setcookie("jwt", "", time() - 3600, "/");
    header('Location: /public/index.php');
    exit;
}
?>

<h1>Logout</h1>
<p>Bem-vindo, usuário de ID: <?php echo htmlspecialchars($jwt_data['id']); ?></p>
<p>Seu email: <?php echo htmlspecialchars($jwt_data['email']); ?></p>
<form method="POST" action="">
    <button type="submit">Logout</button>
</form>

<?php include '../includes/footer.php'; ?>
