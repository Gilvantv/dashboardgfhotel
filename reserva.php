
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G&FHotel - Reserva</title>
    <link rel="stylesheet" href="./styles.css" />

    <script src="script.js"></script>
</head>

<body>
<?php require 'navbar.php'; ?>
    <div class="conteudo-principal">
        <div class="container-formulario">
            <h2>Faça sua Reserva</h2>
            <form class="formulario-reserva">
                <div class="grupo-campo">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="grupo-campo">
                    <label for="documento">CPF ou CNPJ</label>
                    <input type="text" id="documento" name="documento" required>
                </div>

                <div class="grupo-campo">
                    <label for="data-entrada">Data de Entrada</label>
                    <input type="date" id="data-entrada" name="data-entrada" required>
                </div>

                <div class="grupo-campo">
                    <label for="data-saida">Data de Saída</label>
                    <input type="date" id="data-saida" name="data-saida" required>
                </div>

                <div class="grupo-campo">
                    <label for="numero-quarto">Número do Quarto</label>
                    <input type="number" id="numero-quarto" name="numero-quarto" required>
                </div>

                <div class="grupo-campo">
                    <label>Método de Pagamento</label>
                    <div class="opcoes-pagamento">
                        <div class="opcao">
                            <input type="radio" id="pix" name="pagamento" value="pix">
                            <label for="pix">PIX</label>
                        </div>
                        <div class="opcao">
                            <input type="radio" id="cartao" name="pagamento" value="cartao">
                            <label for="cartao">Cartão</label>
                        </div>
                        <div class="opcao">
                            <input type="radio" id="dinheiro" name="pagamento" value="dinheiro">
                            <label for="dinheiro">Dinheiro</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="botao-reservar">Confirmar Reserva</button>
            </form>
        </div>
    </div>
</body>

</html>