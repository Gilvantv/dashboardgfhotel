
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G&FHotel - Galeria</title>
    <link rel="stylesheet" href="./styles.css" />

    <script src="script.js"></script>
</head>

<body>
<?php require 'navbar.php'; ?>
    <div class="conteudo-principal">
        <div class="carrossel">
            <div class="slides">
                <div class="slide">
                    <img src="assets/resorte.jpg" alt="Foto do Hotel 1">
                </div>
                <div class="slide">
                    <img src="assets/hotelfazenda.jpg" alt="Foto do Hotel 2">
                </div>
                <div class="slide">
                    <img src="assets/vistaparaomar.jpg  i" alt="Foto do Hotel 3">
                </div>
            </div>
            <button class="botao-carrossel anterior">&#10094;</button>
            <button class="botao-carrossel proximo">&#10095;</button>
            <div class="indicadores">
                <span class="indicador ativo"></span>
                <span class="indicador"></span>
                <span class="indicador"></span>
            </div>
        </div>
    </div>
</body>

</html>