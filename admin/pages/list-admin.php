<?php
require_once '../../includes/db.php'; // Incluindo a conexão com o banco de dados

// Buscar administradores
$query = "SELECT a.id, a.nome, a.usuario, a.email, a.telefone, i.nome AS instituicao
          FROM administradores a
          INNER JOIN instituicoes i ON a.instituicao_id = i.id";
$stmt = $pdo->prepare($query);  // Usando PDO para preparar a consulta
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtém os resultados como um array associativo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Administradores</title>
</head>
<body>
    <h2>Listagem de Administradores</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Instituição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['usuario']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= htmlspecialchars($row['instituicao']) ?></td>
                    <td>
                        <a href="edit-admin.php?id=<?= htmlspecialchars($row['id']) ?>">Editar</a> | 
                        <a href="delete-admin.php?id=<?= htmlspecialchars($row['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
