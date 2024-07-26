<?php
include '../../../config/db.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM tb_posts";
$stmt = $db->prepare($query);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
        </li>
    <?php endforeach; ?>
</ul>
