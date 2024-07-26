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

$post_id = $_GET['id'];

$query = "SELECT * FROM tb_posts WHERE id = :id AND autor = :autor";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $post_id);
$stmt->bindParam(':autor', $user_id);

if ($stmt->execute()) {
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$post) {
        echo "Post não encontrado ou você não tem permissão para visualizá-lo.";
        exit;
    }
} else {
    echo "Erro ao executar a consulta: " . implode(" ", $stmt->errorInfo());
    exit;
}
?>

<h1>Detalhes do Post</h1>
<h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
<h3><?php echo htmlspecialchars($post['subtitulo']); ?></h3>
<p><?php echo htmlspecialchars($post['conteudo']); ?></p>
<p>Autor: <?php echo htmlspecialchars($post['autor']); ?></p>
<p>Data de Criação: <?php echo htmlspecialchars($post['data_criacao']); ?></p>
<p>Última Modificação: <?php echo htmlspecialchars($post['data_ultima_modificacao']); ?></p>

<form method="POST" action="../functions/update_post.php">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" value="<?php echo $post['titulo']; ?>" required>
    <br>
    <label for="subtitulo">Subtítulo:</label>
    <input type="text" name="subtitulo" value="<?php echo $post['subtitulo']; ?>">
    <br>
    <label for="conteudo">Conteúdo:</label>
    <textarea name="conteudo" required><?php echo $post['conteudo']; ?></textarea>
    <br>
    <label for="autor">Autor:</label>
    <input type="text" name="autor" value="<?php echo $post['autor']; ?>" required>
    <br>
    <button type="submit">Atualizar</button>
</form>

<form method="POST" action="../
