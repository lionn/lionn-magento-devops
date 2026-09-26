require(['jquery'], function($) {
    $(document).ready(function(){
        var backToTopButton = $('#back-to-top');
        
        // Mostrar o botão ao rolar para baixo
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                backToTopButton.fadeIn();
            } else {
                backToTopButton.fadeOut();
            }
        });

        // Voltar ao topo ao clicar
        backToTopButton.click(function() {
            $('html, body').animate({scrollTop: 0}, '300');
        });
    });
});
