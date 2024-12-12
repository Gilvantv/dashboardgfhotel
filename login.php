<?php
session_start();


$erro_login = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

   
    $usuarios_cadastrados = [
        ['email' => 'usuario@exemplo.com', 'senha' => 'senha123'],
        ['email' => 'admin@gfhotel.com', 'senha' => 'admin123']
    ];

    $login_valido = false;
    foreach ($usuarios_cadastrados as $usuario) {
        if ($usuario['email'] === $email && $usuario['senha'] === $senha) {
            $login_valido = true;
            break;
        }
    }

    if ($login_valido) {
        $_SESSION['usuario_logado'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $erro_login = "Email ou senha inválidos";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - G&F Hotel</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        .container-formulario-login {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .formulario-login {
            display: flex;
            flex-direction: column;
        }

        .grupo-campo {
            margin-bottom: 15px;
        }

        .grupo-campo label {
            margin-bottom: 5px;
            display: block;
        }

        .grupo-campo input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .botao-login {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .botao-login:hover {
            background-color: #0056b3;
        }

        .erro-login {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .link-cadastro {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?php require 'navbar.php'; ?>

    <div class="conteudo-principal">
        <div class="container-formulario-login">
            <h2>Login G&F Hotel</h2>
            
            <?php if (!empty($erro_login)): ?>
                <div class="erro-login">
                    <?php echo htmlspecialchars($erro_login); ?>
                </div>
            <?php endif; ?>

            <form id="form-login" class="formulario-login" method="POST" action="">
                <div class="grupo-campo">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="Digite seu email"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                    >
                </div>
                
                <div class="grupo-campo">
                    <label for="senha">Senha</label>
                    <input 
                        type="password" 
                        id="senha" 
                        name="senha" 
                        required 
                        placeholder="Digite sua senha"
                    >
                </div>

                <div class="grupo-campo">
                    <input type="checkbox" id="lembrar-me" name="lembrar-me">
                    <label for="lembrar-me">Lembrar meu login</label>
                </div>

                <button type="submit" class="botao-login">Entrar</button>
            </form>

            <div class="link-cadastro">
                <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
                <p><a href="recuperar-senha.php">Esqueci minha senha</a></p>
            </div>
        </div>
    </div>

    <div class="rodape">
        <div class="texto-rodape">Todos os direitos reservados</div>
    </div>

    <script>
    document.getElementById('form-login').addEventListener('submit', function(event) {
        const email = document.getElementById('email');
        const senha = document.getElementById('senha');
        
        if (email.value.trim() === '') {
            alert('Por favor, digite seu email');
            event.preventDefault();
            return;
        }

        if (senha.value.trim() === '') {
            alert('Por favor, digite sua senha');
            event.preventDefault();
            return;
        }
    });
    </script>
</body>
</html>