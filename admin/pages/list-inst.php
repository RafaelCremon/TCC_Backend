<?php
require_once '../../includes/db.php'; // Incluindo a conexão com o banco de dados

// Buscar instituições
$query = "SELECT * FROM instituicoes";
$stmt = $pdo->prepare($query); // Usando PDO para preparar a consulta
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém os resultados como um array associativo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Instituições</title>
</head>
<body>
    <h2>Listagem de Instituições</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>CEP</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Subdomínio</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['cnpj']) ?></td>
                    <td><?= htmlspecialchars($row['endereco']) ?></td>
                    <td><?= htmlspecialchars($row['cidade']) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td><?= htmlspecialchars($row['cep']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['subdominio']) ?></td>
                    <td>
                        <a href="edit-inst.php?id=<?= htmlspecialchars($row['id']) ?>">Editar</a> | 
                        <a href="delete-inst.php?id=<?= htmlspecialchars($row['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
