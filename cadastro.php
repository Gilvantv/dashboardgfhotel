<?php require 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>


    <div class="conteudo-principal">
        <div class="container-formulariocads">
            <h2>Cadastro</h2>
            <form id="form-cadastro" class="formulario-cadastro">
                <div class="grupo-campo">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" required>
                </div>
                <div class="grupo-campo">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>
                <div class="grupo-campo">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" required>
                </div>
                <div class="grupo-campo">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" required>
                </div>
                <div class="grupo-campo">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" required>
                </div>
                <div class="grupo-campo">
                    <label for="confirma-senha">Confirma Senha</label>
                    <input type="password" id="confirma-senha" required>
                </div>
                <div class="grupo-campo">
                    <input type="checkbox" id="nao-sou-robo" required>
                    <label for="nao-sou-robo">Não sou um robô</label>
                </div>
                <button type="submit" class="botao-cadastrar">Criar Cadastro</button>
            </form>
            <div id="mensagem" style="display: none; margin-top: 20px; color: green;">Cadastro realizado!</div>
        </div>
    </div>

    <div class="rodape">
        <div class="texto-rodape">Todos os direitos reservados</div>
    </div>
</body>