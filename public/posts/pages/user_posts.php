<?php include '../../includes/header.php'; ?>
<?php
include '../../config/db.php';
include '../../includes/auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

check_login();

$jwt_data = verificar_jwt($_COOKIE['jwt']);
$user_id = $jwt_data['id'];

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM tb_posts WHERE autor = :autor";
$stmt = $db->prepare($query);
$stmt->bindParam(':autor', $user_id);

if ($stmt->execute()) {
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Erro ao executar a consulta: " . implode(" ", $stmt->errorInfo());
    exit;
}
?>

<h1>Meus Posts</h1>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
            <a href="post_details.php?id=<?php echo $post['id']; ?>">Ver Detalhes</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include '../../includes/footer.php'; ?>
