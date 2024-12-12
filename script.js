document.addEventListener('DOMContentLoaded', function() {
    let slideAtual = 0;
    const slides = document.querySelectorAll('.slide');
    const indicadores = document.querySelectorAll('.indicador');
    const totalSlides = slides.length;


    function atualizarCarrossel() {
        const deslocamento = -slideAtual * 100;
        document.querySelector('.slides').style.transform = `translateX(${deslocamento}%)`;
        

        indicadores.forEach((indicador, index) => {
            indicador.classList.toggle('ativo', index === slideAtual);
        });
    }


    document.querySelector('.proximo').addEventListener('click', () => {
        slideAtual = (slideAtual + 1) % totalSlides;
        atualizarCarrossel();
    });

    document.querySelector('.anterior').addEventListener('click', () => {
        slideAtual = (slideAtual - 1 + totalSlides) % totalSlides;
        atualizarCarrossel();
    });


    indicadores.forEach((indicador, index) => {
        indicador.addEventListener('click', () => {
            slideAtual = index;
            atualizarCarrossel();
        });
    });

    setInterval(() => {
        slideAtual = (slideAtual + 1) % totalSlides;
        atualizarCarrossel();
    }, 5000);
});