<?php
session_start();


if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard G&F Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        .navbar-vertical {
            width: 70px;
            background-color: #2c3e50;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            transition: width 0.3s;
        }

        .navbar-vertical:hover {
            width: 200px;
        }

        .navbar-vertical a {
            width: 100%;
            color: white;
            text-decoration: none;
            padding: 15px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .navbar-vertical a:hover {
            background-color: #34495e;
        }

        .navbar-vertical a i {
            margin-right: 15px;
            min-width: 25px;
            text-align: center;
        }

        .navbar-vertical a span {
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .navbar-vertical:hover a span {
            opacity: 1;
        }

        .dashboard-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .dashboard-image {
            width: 500px;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar-vertical">
        <a href="dashboard.php" class="active">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
        <a href="clientes.php">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
        </a>
        <a href="quartos.php">
            <i class="fas fa-users"></i>
            <span>quartos</span>
        </a>
        <a href="reservadash.php">
            <i class="fas fa-users"></i>
            <span>reserva</span>
        </a>
        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Sair</span>
        </a>
    </nav>

    <div class="dashboard-content">
        <img src="/api/placeholder/500/500" alt="Dashboard" class="dashboard-image">
    </div>
</body>
</html>