<?php 
include '../../includes/header.php'; 
include '../../../config/db.php';
include '../../../includes/auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

check_login();

$jwt_data = verificar_jwt($_COOKIE['jwt']);
$user_id = $jwt_data['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $conteudo = $_POST['conteudo'];

    $database = new Database();
    $db = $database->getConnection();

    $query = "INSERT INTO tb_posts (titulo, subtitulo, conteudo, autor) VALUES (:titulo, :subtitulo, :conteudo, :autor)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':subtitulo', $subtitulo);
    $stmt->bindParam(':conteudo', $conteudo);
    $stmt->bindParam(':autor', $user_id);

    if ($stmt->execute()) {
        header('Location: user_posts.php');
        exit();
    } else {
        echo "Erro ao criar o post: " . implode(" ", $stmt->errorInfo());
    }
}
?>

<h1>Criar Post</h1>
<form method="POST" action="">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>
    <label for="subtitulo">Subtítulo:</label>
    <input type="text" id="subtitulo" name="subtitulo">
    <br>
    <label for="conteudo">Conteúdo:</label>
    <textarea id="conteudo" name="conteudo" required></textarea>
    <br>
    <button type="submit">Criar</button>
</form>

<?php include '../../../includes/footer.php'; ?>
