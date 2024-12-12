<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_quartos";


try {
   
    $conn = new mysqli($servername, $username, $password);

 
    if ($conn->connect_error) {
        throw new Exception("Erro na conexão: " . $conn->connect_error);
    }


    $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sql_create_db)) {
        throw new Exception("Erro ao criar banco de dados: " . $conn->error);
    }


    $conn->close();

    $conn = new mysqli($servername, $username, $password, $dbname);


    $sql_create_table = "CREATE TABLE IF NOT EXISTS quartos (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        numero VARCHAR(10) NOT NULL UNIQUE,
        status ENUM('liberado', 'ocupado', 'alugando') DEFAULT 'liberado',
        tipo ENUM('suíte', 'comum') NOT NULL,
        dias INT(3) DEFAULT 0,
        preco DECIMAL(10,2) NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!$conn->query($sql_create_table)) {
        throw new Exception("Erro ao criar tabela: " . $conn->error);
    }


    $check_data = $conn->query("SELECT COUNT(*) as count FROM quartos");
    $data_count = $check_data->fetch_assoc()['count'];
    
    if ($data_count == 0) {
        $quartos_iniciais = [
            "(101, 'liberado', 'suíte', 0, 250.00)",
            "(102, 'liberado', 'comum', 0, 150.00)",
            "(103, 'ocupado', 'suíte', 2, 250.00)",
            "(104, 'alugando', 'comum', 1, 150.00)"
        ];
        
        $sql_insert = "INSERT INTO quartos (numero, status, tipo, dias, preco) VALUES " . 
                      implode(',', array_map(function($quarto) { 
                          return "($quarto)"; 
                      }, $quartos_iniciais));
        
        $conn->query($sql_insert);
    }

 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'adicionar':
                    $numero = $conn->real_escape_string($_POST['numero']);
                    $status = $conn->real_escape_string($_POST['status']);
                    $tipo = $conn->real_escape_string($_POST['tipo']);
                    $dias = intval($_POST['dias']);
                    $preco = floatval($_POST['preco']);
                    
                    $sql = "INSERT INTO quartos (numero, status, tipo, dias, preco) 
                            VALUES ('$numero', '$status', '$tipo', $dias, $preco)";
                    $conn->query($sql);
                    break;
                
                case 'editar':
                    $id = intval($_POST['id']);
                    $numero = $conn->real_escape_string($_POST['numero']);
                    $status = $conn->real_escape_string($_POST['status']);
                    $tipo = $conn->real_escape_string($_POST['tipo']);
                    $dias = intval($_POST['dias']);
                    $preco = floatval($_POST['preco']);
                    
                    $sql = "UPDATE quartos SET 
                            numero='$numero', 
                            status='$status', 
                            tipo='$tipo', 
                            dias=$dias, 
                            preco=$preco 
                            WHERE id=$id";
                    $conn->query($sql);
                    break;
                
                case 'excluir':
                    $id = intval($_POST['id']);
                    $sql = "DELETE FROM quartos WHERE id=$id";
                    $conn->query($sql);
                    break;
            }
            
           
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

 
    $result = $conn->query("SELECT * FROM quartos ORDER BY numero");

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
    <title>Dashboard de Quartos</title>
    
</head>
<link rel="stylesheet" href="./quartos.css" />
<?php require 'navdash.php'; ?>
<body>
    <div class="container">
        <h1>Dashboard de Quartos</h1>
        
        <button id="btn-adicionar">Adicionar Quarto</button>
        
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Status</th>
                    <th>Tipo</th>
                    <th>Dias</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['numero']); ?></td>
                        <td class="status-<?php echo htmlspecialchars($row['status']); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['tipo']); ?></td>
                        <td><?php echo htmlspecialchars($row['dias']); ?></td>
                        <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <button class="btn-editar" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-numero="<?php echo htmlspecialchars($row['numero']); ?>"
                                    data-status="<?php echo htmlspecialchars($row['status']); ?>"
                                    data-tipo="<?php echo htmlspecialchars($row['tipo']); ?>"
                                    data-dias="<?php echo $row['dias']; ?>"
                                    data-preco="<?php echo $row['preco']; ?>">
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
            <h2>Adicionar/Editar Quarto</h2>
            <form id="form-quarto" method="POST">
                <input type="hidden" name="id" id="input-id">
                <input type="hidden" name="action" id="input-action">
                
                <label for="numero">Número do Quarto:</label>
                <input type="text" name="numero" id="input-numero" required>
                
                <label for="status">Status:</label>
                <select name="status" id="input-status" required>
                    <option value="liberado">Liberado</option>
                    <option value="ocupado">Ocupado</option>
                    <option value="alugando">Alugando</option>
                </select>
                
                <label for="tipo">Tipo:</label>
                <select name="tipo" id="input-tipo" required>
                    <option value="suíte">Suíte</option>
                    <option value="comum">Comum</option>
                </select>
                
                <label for="dias">Dias:</label>
                <input type="number" name="dias" id="input-dias" min="0" required>
                
                <label for="preco">Preço:</label>
                <input type="number" name="preco" id="input-preco" step="0.01" min="0" required>
                
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
   
        const modal = document.getElementById('modal');
        const btnAdicionar = document.getElementById('btn-adicionar');
        const closeBtn = document.querySelector('.close');
        const form = document.getElementById('form-quarto');

        const botoesEditar = document.querySelectorAll('.btn-editar');
        const botoesExcluir = document.querySelectorAll('.btn-excluir');

      
        btnAdicionar.addEventListener('click', () => {
            document.getElementById('input-id').value = '';
            document.getElementById('input-numero').value = '';
            document.getElementById('input-status').value = 'liberado';
            document.getElementById('input-tipo').value = 'comum';
            document.getElementById('input-dias').value = '0';
            document.getElementById('input-preco').value = '';
            
            document.getElementById('input-action').value = 'adicionar';
            modal.style.display = 'block';
        });

     
        botoesEditar.forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.getElementById('input-id').value = e.target.getAttribute('data-id');
                document.getElementById('input-numero').value = e.target.getAttribute('data-numero');
                document.getElementById('input-status').value = e.target.getAttribute('data-status');
                document.getElementById('input-tipo').value = e.target.getAttribute('data-tipo');
                document.getElementById('input-dias').value = e.target.getAttribute('data-dias');
                document.getElementById('input-preco').value = e.target.getAttribute('data-preco');
                
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

<?php
