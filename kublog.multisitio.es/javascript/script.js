
$(document).ajaxStart(function()
{
});
$(document).ajaxComplete(function()
{
    materialize();
});

$(window).resize(function()
{
});

$(window).scroll(function()
{
    var top = $(this).scrollTop();
    if (top > 0)
    {
        $('.scroll-buttons').removeClass('hide');
    }
    else
    {
        $('.scroll-buttons').addClass('hide');
    }
});

$(function()
{
    /* MATERIALIZECSS */
    materialize();

    /* MUESTRA Y OCULTA ALGO */
    $('body').on('click', '[data-toggle]', function()
    {
        var to = $(this).data('toggle');
        $(to).toggle();
    });

    /* EL VELO NEGRO CIERRA LOS ASIDE AL PINCHAR SOBRE EL */
    $('body').on('click', '#sidenav-overlay', function()
    {
        $(this).hide();
        $('aside').hide();
    });

    /* CARGA CONTENIDO EN UN MODAL Y LO ABRE */
    $('body').on('click', '.load-modal', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        $('.modal').load(url).modal('open');
    });

    /* BOTON PARA IR ARRIBA DEL TODO */
    $('body').on('click', '.scroll-top', function(e)
    {
        e.preventDefault();
        window.scrollTo(0, 0);
    });
});
