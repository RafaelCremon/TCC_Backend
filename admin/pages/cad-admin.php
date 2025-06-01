<?php
require_once '../../includes/db.php'; // Incluindo a conexão com o banco de dados

// Buscar as instituições cadastradas para o select
$query_inst = "SELECT id, nome FROM instituicoes";
$result_inst = $pdo->query($query_inst); // Usando $pdo ao invés de $conn

// Verificando se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $instituicao_id = $_POST['instituicao_id'];
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Criptografando a senha usando password_hash
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Inserção no banco de dados
    $query = "INSERT INTO administradores (instituicao_id, nome, usuario, email, telefone, senha) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query); // Usando $pdo
    $stmt->bindParam(1, $instituicao_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $nome, PDO::PARAM_STR);
    $stmt->bindParam(3, $usuario, PDO::PARAM_STR);
    $stmt->bindParam(4, $email, PDO::PARAM_STR);
    $stmt->bindParam(5, $telefone, PDO::PARAM_STR);
    $stmt->bindParam(6, $senha, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Administrador cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar administrador: " . $pdo->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Administrador</title>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
</head>
<body>
    <h2>Cadastrar Administrador</h2>
    <form action="cad-admin.php" method="POST">
        <label for="instituicao_id">Instituição:</label>
        <select name="instituicao_id" required>
            <option value="">Selecione a instituição</option>
            <?php while ($row = $result_inst->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>

        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
        // Máscara para telefone
        var telefoneMask = new Inputmask('(99) 99999-9999');
        telefoneMask.mask(document.querySelector("#telefone"));
    </script>
</body>
</html>
