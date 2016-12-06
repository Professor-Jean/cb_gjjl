/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 19/10/2016
 *Data de Modificação: 21/10/2016
 *Descrição: Esta página contém o código responsável por abrir a janela modal, quando o usuário selecionar um cliente, para que consiga ver informações detalhadas sobre o cliente.
 ***********************************************************************************************************************************************/
$(document).ready(function(){
    $('a[name=modal]').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a com o nome de modal.

        $(document).scrollTop(0);
        //Faz com que a página vá para o topo.

        var id = $(this).attr('class');
        //Recebe o id do atributo id do link.

        var maskHeight = $(document).height();
        //Recebe a altura da página e armazena na variável maskHeight.
        var maskWidth = $(window).width();
        //Recebe a largura da página e armazena na variável maskWidth.

        $('#mask').css({'width':maskWidth, 'height':maskHeight});
        //Escreve essas informações no css.

        $('#mask').fadeIn(500);
        //Da um efeito de entrada.
        $('#mask').fadeTo("slow", 0.6);
        //Da um efeito de saída.

        var winH = $(window).height();
        //Armazena a altura da janela na variável winH.
        var winW = $(window).width();
        //Armazena a largura da janela na variável winW.

        $(id).css('top', winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        //Calcula o meio da página.

        $(id).fadeIn(500);
        //Efeito de entrada.
    });

    $('.close').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a da imagem com a classe .close.
        $('#mask, .window').hide();
    });

    $('#mask').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado na máscara.
        $('#mask, .window').hide();
    });
});

// Janela modal de Eventos

$(document).ready(function(){
    $('a[name=modal_eventos]').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a com o nome de modal.

        $(document).scrollTop(0);
        //Faz com que a página vá para o topo.

        var id = $(this).attr('class');
        //Recebe o id do atributo id do link.

        var maskHeight = $(document).height();
        //Recebe a altura da página e armazena na variável maskHeight.
        var maskWidth = $(window).width();
        //Recebe a largura da página e armazena na variável maskWidth.

        $('#mask').css({'width':maskWidth, 'height':maskHeight});
        //Escreve essas informações no css.

        $('#mask').fadeIn(500);
        //Da um efeito de entrada.
        $('#mask').fadeTo("slow", 0.6);
        //Da um efeito de saída.

        var winH = $(window).height();
        //Armazena a altura da janela na variável winH.
        var winW = $(window).width();
        //Armazena a largura da janela na variável winW.

        $(id).css('top', winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        //Calcula o meio da página.

        $(id).fadeIn(500);
        //Efeito de entrada.
    });

    $('.close').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a da imagem com a classe .close.
        $('#mask, .window').hide();
    });

    $('#mask').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado na máscara.
        $('#mask, .window').hide();
    });
});

// Janela modal de Eventos Orçados

$(document).ready(function(){
    $('a[name=modal_orcados]').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a com o nome de modal.

        $(document).scrollTop(0);
        //Faz com que a página vá para o topo.

        var id = $(this).attr('class');
        //Recebe o id do atributo id do link.

        var maskHeight = $(document).height();
        //Recebe a altura da página e armazena na variável maskHeight.
        var maskWidth = $(window).width();
        //Recebe a largura da página e armazena na variável maskWidth.

        $('#mask').css({'width':maskWidth, 'height':maskHeight});
        //Escreve essas informações no css.

        $('#mask').fadeIn(500);
        //Da um efeito de entrada.
        $('#mask').fadeTo("slow", 0.6);
        //Da um efeito de saída.

        var winH = $(window).height();
        //Armazena a altura da janela na variável winH.
        var winW = $(window).width();
        //Armazena a largura da janela na variável winW.

        $(id).css('top', winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        //Calcula o meio da página.

        $(id).fadeIn(500);
        //Efeito de entrada.
    });

    $('.close').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a da imagem com a classe .close.
        $('#mask, .window').hide();
    });

    $('#mask').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado na máscara.
        $('#mask, .window').hide();
    });
});

// Janela modal de Eventos Cancelados

$(document).ready(function(){
    $('a[name=modal_cancelados]').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a com o nome de modal.

        $(document).scrollTop(0);
        //Faz com que a página vá para o topo.

        var id = $(this).attr('class');
        //Recebe o id do atributo id do link.

        var maskHeight = $(document).height();
        //Recebe a altura da página e armazena na variável maskHeight.
        var maskWidth = $(window).width();
        //Recebe a largura da página e armazena na variável maskWidth.

        $('#mask').css({'width':maskWidth, 'height':maskHeight});
        //Escreve essas informações no css.

        $('#mask').fadeIn(500);
        //Da um efeito de entrada.
        $('#mask').fadeTo("slow", 0.6);
        //Da um efeito de saída.

        var winH = $(window).height();
        //Armazena a altura da janela na variável winH.
        var winW = $(window).width();
        //Armazena a largura da janela na variável winW.

        $(id).css('top', winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        //Calcula o meio da página.

        $(id).fadeIn(500);
        //Efeito de entrada.
    });

    $('.close').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado no a da imagem com a classe .close.
        $('#mask, .window').hide();
    });

    $('#mask').click(function(e){
        e.preventDefault();
        //Previne que o link seja executado, quando se é clicado na máscara.
        $('#mask, .window').hide();
    });
});

