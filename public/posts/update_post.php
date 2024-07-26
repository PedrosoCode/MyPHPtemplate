<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $conteudo = $_POST['conteudo'];
    $autor = $_POST['autor'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "UPDATE tb_posts SET titulo = :titulo, subtitulo = :subtitulo, conteudo = :conteudo, autor = :autor, data_ultima_modificacao = NOW() WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':subtitulo', $subtitulo);
    $stmt->bindParam(':conteudo', $conteudo);
    $stmt->bindParam(':autor', $autor);

    if ($stmt->execute()) {
        echo "Post atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o post.";
    }
}
?>
