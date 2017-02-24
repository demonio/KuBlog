
$(function()
{
    /* MUESTRA Y OCULTA EL ASIDE */
    $('body').on('click', '[data-toggle-aside]', function(e)
    {
        e.preventDefault();
        var to = $(this).data('toggle-aside');

        $('aside').not(to).addClass('s0').css('position', 'relative');
        $('#sidenav-overlay').hide();

        if ( $(to).hasClass('s0') )
        {
            $(to).removeClass('s0').addClass('s10').css(
            {
                position:'absolute',
                'z-index':998,
            });
            $('#sidenav-overlay').show();
        }
        else
        {
            $(to).removeClass('s10').addClass('s0').css('position', 'relative');
            $('#sidenav-overlay').hide();
        }
    });

    /* OCULTA EL ASIDE PINCHANDO EN EL OVERLAY O EN UN ENLACE DEL ASIDE */
    $('body').on('click', '#sidenav-overlay, aside a', function()
    {
        $('aside').addClass('s0').css('position', 'relative');
        $('#sidenav-overlay').hide();
    });
});
