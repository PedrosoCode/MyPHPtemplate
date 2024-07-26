<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "DELETE FROM tb_posts WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Post deletado com sucesso!";
    } else {
        echo "Erro ao deletar o post.";
    }
}
?>
