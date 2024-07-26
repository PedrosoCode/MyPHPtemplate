<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $conteudo = $_POST['conteudo'];
    $autor = $_POST['autor'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO tb_posts (titulo, subtitulo, conteudo, autor) VALUES (:titulo, :subtitulo, :conteudo, :autor)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':subtitulo', $subtitulo);
    $stmt->bindParam(':conteudo', $conteudo);
    $stmt->bindParam(':autor', $autor);

    if ($stmt->execute()) {
        echo "Post criado com sucesso!";
    } else {
        echo "Erro ao criar o post.";
    }
}
?>
