<?php
// Iniciar a sessão
session_start();

// Conectar ao banco de dados
require_once "../../../includes/db.php";

// Inicializar a variável de erro
if (isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']); // Limpar a mensagem após a exibição
} else {
    $erro = "";
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verificar se os campos estão preenchidos
    if (!empty($usuario) && !empty($senha)) {
        // Preparar a consulta SQL
        $stmt = $pdo->prepare("SELECT * FROM administradores WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o usuário existe e a senha está correta
        if ($admin && password_verify($senha, $admin['senha'])) {
            // Armazenar o ID do usuário na sessão
            $_SESSION['usuario_id'] = $admin['id'];  // Substitua 'id' pelo nome correto da coluna de ID no banco
            $_SESSION['usuario'] = $admin['usuario']; // Armazenar o nome de usuário também, se necessário
            header("Location: inicial.php"); // Redireciona para a página inicial
            exit();
        } else {
            $_SESSION['erro'] = "Usuário ou senha incorretos."; // Armazenar mensagem de erro na sessão
            header("Location: login.php"); // Redireciona para a mesma página
            exit();
        }
    } else {
        $_SESSION['erro'] = "Preencha todos os campos."; // Armazenar mensagem de erro na sessão
        header("Location: login.php"); // Redireciona para a mesma página
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tela de Login</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
    <ul class="bolhas" id="bolhas"></ul>
    <div class="card">
        <h1>Login</h1>
        <form method="POST">
            <div class="campo">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário" value="<?= isset($usuario) ? htmlspecialchars($usuario) : '' ?>" required />
            </div>

            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required />
            </div>

            <!-- Mensagem de erro se houver -->
            <?php if (!empty($erro)): ?>
                <div class="mensagem-erro" id="erroMensagem"><?= $erro ?></div>
            <?php endif; ?>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <script src="../js/login.js"></script>
</body>
</html>
