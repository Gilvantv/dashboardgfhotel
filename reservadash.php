<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_quartos";

try {
    
    $conn = new mysqli($servername, $username, $password, $dbname);

 
    $sql_create_table = "CREATE TABLE IF NOT EXISTS reservas (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        quarto_id INT(6) UNSIGNED NOT NULL,
        nome_cliente VARCHAR(100) NOT NULL,
        data_checkin DATE NOT NULL,
        data_checkout DATE NOT NULL,
        valor_reserva DECIMAL(10,2) NOT NULL,
        status ENUM('confirmada', 'pendente', 'cancelada') DEFAULT 'pendente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (quarto_id) REFERENCES quartos(id)
    )";

    if (!$conn->query($sql_create_table)) {
        throw new Exception("Erro ao criar tabela de reservas: " . $conn->error);
    }

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'adicionar':
                    $quarto_id = intval($_POST['quarto_id']);
                    $nome_cliente = $conn->real_escape_string($_POST['nome_cliente']);
                    $data_checkin = $conn->real_escape_string($_POST['data_checkin']);
                    $data_checkout = $conn->real_escape_string($_POST['data_checkout']);
                    $valor_reserva = floatval($_POST['valor_reserva']);
                    $status = $conn->real_escape_string($_POST['status']);
                    

                    $update_room_status = "UPDATE quartos SET status='ocupado' WHERE id=$quarto_id";
                    $conn->query($update_room_status);
                    
                    $sql = "INSERT INTO reservas (quarto_id, nome_cliente, data_checkin, data_checkout, valor_reserva, status) 
                            VALUES ($quarto_id, '$nome_cliente', '$data_checkin', '$data_checkout', $valor_reserva, '$status')";
                    $conn->query($sql);
                    break;
                
                case 'editar':
                    $id = intval($_POST['id']);
                    $quarto_id = intval($_POST['quarto_id']);
                    $nome_cliente = $conn->real_escape_string($_POST['nome_cliente']);
                    $data_checkin = $conn->real_escape_string($_POST['data_checkin']);
                    $data_checkout = $conn->real_escape_string($_POST['data_checkout']);
                    $valor_reserva = floatval($_POST['valor_reserva']);
                    $status = $conn->real_escape_string($_POST['status']);
                    
                    $sql = "UPDATE reservas SET 
                            quarto_id=$quarto_id, 
                            nome_cliente='$nome_cliente', 
                            data_checkin='$data_checkin', 
                            data_checkout='$data_checkout', 
                            valor_reserva=$valor_reserva, 
                            status='$status' 
                            WHERE id=$id";
                    $conn->query($sql);
                    break;
                
                case 'excluir':
                    $id = intval($_POST['id']);
                    $sql = "DELETE FROM reservas WHERE id=$id";
                    $conn->query($sql);
                    break;
            }
            
  
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

 
    $result = $conn->query("
        SELECT r.*, q.numero AS numero_quarto 
        FROM reservas r 
        JOIN quartos q ON r.quarto_id = q.id 
        ORDER BY r.data_checkin
    ");


    $rooms_result = $conn->query("SELECT id, numero, status FROM quartos WHERE status='liberado'");

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
    <title>Dashboard de Reservas</title>
    <link rel="stylesheet" href="./quartos.css" />
</head>
<body>
    <?php require 'navdash.php'; ?>
    <div class="container">
        <h1>Dashboard de Reservas</h1>
        
        <button id="btn-adicionar">Adicionar Reserva</button>
        
        <table>
            <thead>
                <tr>
                    <th>Número do Quarto</th>
                    <th>Nome do Cliente</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Valor da Reserva</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['numero_quarto']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome_cliente']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_checkin'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['data_checkout'])); ?></td>
                        <td>R$ <?php echo number_format($row['valor_reserva'], 2, ',', '.'); ?></td>
                        <td class="status-<?php echo htmlspecialchars($row['status']); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </td>
                        <td>
                            <button class="btn-editar" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-quarto-id="<?php echo $row['quarto_id']; ?>"
                                    data-nome-cliente="<?php echo htmlspecialchars($row['nome_cliente']); ?>"
                                    data-data-checkin="<?php echo $row['data_checkin']; ?>"
                                    data-data-checkout="<?php echo $row['data_checkout']; ?>"
                                    data-valor-reserva="<?php echo $row['valor_reserva']; ?>"
                                    data-status="<?php echo htmlspecialchars($row['status']); ?>">
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
            <h2>Adicionar/Editar Reserva</h2>
            <form id="form-reserva" method="POST">
                <input type="hidden" name="id" id="input-id">
                <input type="hidden" name="action" id="input-action">
                
                <label for="quarto_id">Número do Quarto:</label>
                <select name="quarto_id" id="input-quarto-id" required>
                    <?php while($room = $rooms_result->fetch_assoc()): ?>
                        <option value="<?php echo $room['id']; ?>">
                            <?php echo htmlspecialchars($room['numero']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label for="nome_cliente">Nome do Cliente:</label>
                <input type="text" name="nome_cliente" id="input-nome-cliente" required>
                
                <label for="data_checkin">Data Check-in:</label>
                <input type="date" name="data_checkin" id="input-data-checkin" required>
                
                <label for="data_checkout">Data Check-out:</label>
                <input type="date" name="data_checkout" id="input-data-checkout" required>
                
                <label for="valor_reserva">Valor da Reserva:</label>
                <input type="number" name="valor_reserva" id="input-valor-reserva" step="0.01" min="0" required>
                
                <label for="status">Status:</label>
                <select name="status" id="input-status" required>
                    <option value="confirmada">Confirmada</option>
                    <option value="pendente">Pendente</option>
                    <option value="cancelada">Cancelada</option>
                </select>
                
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const btnAdicionar = document.getElementById('btn-adicionar');
        const closeBtn = document.querySelector('.close');
        const form = document.getElementById('form-reserva');

        const botoesEditar = document.querySelectorAll('.btn-editar');
        const botoesExcluir = document.querySelectorAll('.btn-excluir');

    
        btnAdicionar.addEventListener('click', () => {
            document.getElementById('input-id').value = '';
            document.getElementById('input-quarto-id').value = '';
            document.getElementById('input-nome-cliente').value = '';
            document.getElementById('input-data-checkin').value = '';
            document.getElementById('input-data-checkout').value = '';
            document.getElementById('input-valor-reserva').value = '';
            document.getElementById('input-status').value = 'pendente';
            
            document.getElementById('input-action').value = 'adicionar';
            modal.style.display = 'block';
        });

      
        botoesEditar.forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.getElementById('input-id').value = e.target.getAttribute('data-id');
                document.getElementById('input-quarto-id').value = e.target.getAttribute('data-quarto-id');
                document.getElementById('input-nome-cliente').value = e.target.getAttribute('data-nome-cliente');
                document.getElementById('input-data-checkin').value = e.target.getAttribute('data-data-checkin');
                document.getElementById('input-data-checkout').value = e.target.getAttribute('data-data-checkout');
                document.getElementById('input-valor-reserva').value = e.target.getAttribute('data-valor-reserva');
                document.getElementById('input-status').value = e.target.getAttribute('data-status');
                
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