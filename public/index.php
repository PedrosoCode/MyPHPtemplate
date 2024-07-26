<?php include '../includes/header.php'; ?>
<?php
include '../config/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$db = $database->getConnection();

// Leitura dos posts
$query = "SELECT * FROM tb_posts";
$stmt = $db->prepare($query);

if ($stmt->execute()) {
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Erro ao executar a consulta: " . implode(" ", $stmt->errorInfo());
    exit;
}
?>

<h1>Bem-vindo ao Meu Site</h1>
<p>Este é o conteúdo da página inicial.</p>

<h1>Posts</h1>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <h2><?php echo htmlspecialchars($post['titulo']); ?></h2>
            <h3><?php echo htmlspecialchars($post['subtitulo']); ?></h3>
            <p><?php echo htmlspecialchars($post['conteudo']); ?></p>
            <p>Autor: <?php echo htmlspecialchars($post['autor']); ?></p>
            <p>Data de Criação: <?php echo htmlspecialchars($post['data_criacao']); ?></p>
            <p>Última Modificação: <?php echo htmlspecialchars($post['data_ultima_modificacao']); ?></p>
            <form method="POST" action="../public/posts/update_post.php">
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
            <form method="POST" action="../public/posts/delete_post.php">
                <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                <button type="submit">Deletar</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

<h1>Criar Post</h1>
<form method="POST" action="../public/posts/create_post.php">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>
    <label for="subtitulo">Subtítulo:</label>
    <input type="text" id="subtitulo" name="subtitulo">
    <br>
    <label for="conteudo">Conteúdo:</label>
    <textarea id="conteudo" name="conteudo" required></textarea>
    <br>
    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor" required>
    <br>
    <button type="submit">Criar</button>
</form>

<?php include '../includes/footer.php'; ?>
