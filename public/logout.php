<?php
include '../includes/header.php';
include '../includes/auth.php';

check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    setcookie("jwt", "", time() - 3600, "/");
    header('Location: /public/index.php');
    exit;
}
?>

<h1>Logout</h1>
<form method="POST" action="">
    <button type="submit">Logout</button>
</form>

<?php include '../includes/footer.php'; ?>
