<?php
require_once '../../includes/db.php'; // Incluindo a conexão com o banco de dados

// Verificando se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $subdominio = $_POST['subdominio'];

    // Inserção no banco de dados
    $query = "INSERT INTO instituicoes (nome, cnpj, endereco, cidade, estado, cep, telefone, email, subdominio) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query); // Usando PDO para preparar a consulta
    $stmt->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt->bindParam(2, $cnpj, PDO::PARAM_STR);
    $stmt->bindParam(3, $endereco, PDO::PARAM_STR);
    $stmt->bindParam(4, $cidade, PDO::PARAM_STR);
    $stmt->bindParam(5, $estado, PDO::PARAM_STR);
    $stmt->bindParam(6, $cep, PDO::PARAM_STR);
    $stmt->bindParam(7, $telefone, PDO::PARAM_STR);
    $stmt->bindParam(8, $email, PDO::PARAM_STR);
    $stmt->bindParam(9, $subdominio, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Instituição cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar instituição: " . $pdo->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Instituição</title>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
</head>
<body>
    <h2>Cadastrar Instituição</h2>
    <form action="cad-inst.php" method="POST">
        <label for="nome">Nome da Instituição:</label>
        <input type="text" name="nome" required><br><br>

        <label for="cnpj">CNPJ:</label>
        <input type="text" name="cnpj" id="cnpj" required><br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" required><br><br>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" required><br><br>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" required><br><br>

        <label for="cep">CEP:</label>
        <input type="text" name="cep" id="cep" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br><br>

        <label for="subdominio">Subdomínio:</label>
        <input type="text" name="subdominio" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
        // Máscaras para CNPJ, telefone e CEP
        var cnpjMask = new Inputmask('99.999.999/9999-99');
        cnpjMask.mask(document.querySelector("#cnpj"));

        var telefoneMask = new Inputmask('(99) 99999-9999');
        telefoneMask.mask(document.querySelector("#telefone"));

        var cepMask = new Inputmask('99999-999');
        cepMask.mask(document.querySelector("#cep"));
    </script>
</body>
</html>
