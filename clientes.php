<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_quartos";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql_create_table = "CREATE TABLE IF NOT EXISTS clientes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        cpf VARCHAR(14) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        telefone VARCHAR(20),
        data_nascimento DATE,
        endereco VARCHAR(255),
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!$conn->query($sql_create_table)) {
        throw new Exception("Erro ao criar tabela de clientes: " . $conn->error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'adicionar':
                    $nome = $conn->real_escape_string($_POST['nome']);
                    $cpf = $conn->real_escape_string($_POST['cpf']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $telefone = $conn->real_escape_string($_POST['telefone']);
                    $data_nascimento = $conn->real_escape_string($_POST['data_nascimento']);
                    $endereco = $conn->real_escape_string($_POST['endereco']);
                    
                    $sql = "INSERT INTO clientes (nome, cpf, email, telefone, data_nascimento, endereco) 
                            VALUES ('$nome', '$cpf', '$email', '$telefone', '$data_nascimento', '$endereco')";
                    $conn->query($sql);
                    break;
                
                case 'editar':
                    $id = intval($_POST['id']);
                    $nome = $conn->real_escape_string($_POST['nome']);
                    $cpf = $conn->real_escape_string($_POST['cpf']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $telefone = $conn->real_escape_string($_POST['telefone']);
                    $data_nascimento = $conn->real_escape_string($_POST['data_nascimento']);
                    $endereco = $conn->real_escape_string($_POST['endereco']);
                    
                    $sql = "UPDATE clientes SET 
                            nome='$nome', 
                            cpf='$cpf', 
                            email='$email', 
                            telefone='$telefone', 
                            data_nascimento='$data_nascimento', 
                            endereco='$endereco' 
                            WHERE id=$id";
                    $conn->query($sql);
                    break;
                
                case 'excluir':
                    $id = intval($_POST['id']);
                    $sql = "DELETE FROM clientes WHERE id=$id";
                    $conn->query($sql);
                    break;
            }
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    $result = $conn->query("SELECT * FROM clientes ORDER BY nome");

} catch (Exception $e) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px 0;'>";
    echo "Ocorreu um erro: " . $e->getMessage();
    echo "</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Clientes</title>
    <link rel="stylesheet" href="./clientes.css" />
</head>
<body>
    <?php require 'navdash.php'; ?>
    <div class="container">
        <h1>Dashboard de Clientes</h1>
        
        <button id="btn-adicionar">Adicionar Cliente</button>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['cpf']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefone']); ?></td>
                        <td>
                            <button class="btn-editar" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-nome="<?php echo htmlspecialchars($row['nome']); ?>"
                                    data-cpf="<?php echo htmlspecialchars($row['cpf']); ?>"
                                    data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                    data-telefone="<?php echo htmlspecialchars($row['telefone']); ?>"
                                    data-data-nascimento="<?php echo $row['data_nascimento']; ?>"
                                    data-endereco="<?php echo htmlspecialchars($row['endereco']); ?>">
                                Editar
                            </button>
                            <button class="btn-excluir" data-id="<?php echo $row['id']; ?>">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar/Editar Cliente</h2>
            <form id="form-cliente" method="POST">
                <input type="hidden" name="id" id="input-id">
                <input type="hidden" name="action" id="input-action">
                
                <label for="nome">Nome Completo:</label>
                <input type="text" name="nome" id="input-nome" required>
                
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" id="input-cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" id="input-email" required>
                
                <label for="telefone">Telefone:</label>
                <input type="tel" name="telefone" id="input-telefone" placeholder="(00) 00000-0000">
                
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" name="data_nascimento" id="input-data-nascimento">
                
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="input-endereco">
                
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('input-cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{2})$/, '$1-$2');
            e.target.value = value;
        });

        document.getElementById('input-telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
            value = value.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = value;
        });

        const modal = document.getElementById('modal');
        const btnAdicionar = document.getElementById('btn-adicionar');
        const closeBtn = document.querySelector('.close');
        const form = document.getElementById('form-cliente');

        const botoesEditar = document.querySelectorAll('.btn-editar');
        const botoesExcluir = document.querySelectorAll('.btn-excluir');

        btnAdicionar.addEventListener('click', () => {
            document.getElementById('input-id').value = '';
            document.getElementById('input-nome').value = '';
            document.getElementById('input-cpf').value = '';
            document.getElementById('input-email').value = '';
            document.getElementById('input-telefone').value = '';
            document.getElementById('input-data-nascimento').value = '';
            document.getElementById('input-endereco').value = '';
            
            document.getElementById('input-action').value = 'adicionar';
            modal.style.display = 'block';
        });

        botoesEditar.forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.getElementById('input-id').value = e.target.getAttribute('data-id');
                document.getElementById('input-nome').value = e.target.getAttribute('data-nome');
                document.getElementById('input-cpf').value = e.target.getAttribute('data-cpf');
                document.getElementById('input-email').value = e.target.getAttribute('data-email');
                document.getElementById('input-telefone').value = e.target.getAttribute('data-telefone');
                document.getElementById('input-data-nascimento').value = e.target.getAttribute('data-data-nascimento');
                document.getElementById('input-endereco').value = e.target.getAttribute('data-endereco');
                
                document.getElementById('input-action').value = 'editar';
                modal.style.display = 'block';
            });
        });

        botoesExcluir.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = e.target.getAttribute('data-id');
                
                const form = document.createElement('form');
                form.method = 'POST';
                
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;
                
                const inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = 'excluir';
                
                form.appendChild(inputId);
                form.appendChild(inputAction);
                
                document.body.appendChild(form);
                form.submit();
            });
        });

       
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

       
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>
</body>
</html>