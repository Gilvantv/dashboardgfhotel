<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G&FHotel</title>
    <link rel="stylesheet" href="./styles.css" />

    <script src="script.js" defer></script>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <div class="conteudo-principal">
        <div class="container-busca">
            <div class="abas-busca">
                <a href="#">Estadias</a>
            </div>
            <form class="formulario-busca">
                <input type="text" placeholder="Para onde você vai?">
                <input type="text" value="14 de out. - 20 de out.">
                <input type="text" value="2 viajantes, 1 quarto">
                <a href="reserva.php">
                    <button type="button">Buscar</button>
                </a>

            </form>
        </div>
        <div class="banner-promocao">
            <h2>Reserve sua estadia perfeita em até 12x sem juros</h2>
            <div class="recursos-promocao">
                <div class="recurso-promocao">Ganhe recompensas em todas as diárias da sua estadia</div>
                <div class="recurso-promocao">Economize mais com os Preços para Associados</div>
                <div class="recurso-promocao">Opções de cancelamento grátis caso os planos mudem</div>
            </div>
        </div>
        <h2>Encontre a sua estadia ideal</h2>
        <div class="tipos-acomodacao">
            <div class="cartao-imagem">
                <img src="assets/spa.jpg" alt="Tudo incluído">
                <span>Tudo incluído</span>
            </div>
            <div class="cartao-imagem">
                <img src="assets/resorte.jpg" alt="Resort">
                <span>Resort</span>
            </div>
            <div class="cartao-imagem">
                <img src="assets/resorte.jpg" alt="Hotel-fazenda">
                <span>Hotel-fazenda</span>
            </div>
            <div class="cartao-imagem">
                <img src="assets/hotelfazenda.jpg" alt="Spa">
                <span>Spa</span>
            </div>
            <div class="cartao-imagem">
                <img src="assets/vistaparaomar.jpg" alt="Vista para o mar">
                <span>Vista para o mar</span>
            </div>
        </div>
    </div>
</body>

</html>