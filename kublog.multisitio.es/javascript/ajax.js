
$(function()
{
    /* AJAX EN FORMULARIOS */
    $('body').on('click', 'form[data-ajax] button', function(e)
    {
        e.preventDefault();
        var form = $(this).parents('form');
        var url = form.attr('action');
        console.log(url);
        $('.url a').attr('href', url).text(url);
        var to = form.attr('data-ajax');
        var btn_name = $(this).attr('name');
        var btn_val = $(this).val();
        var post = btn_name+'='+btn_val+'&'+form.serialize();
        $.post(url, post, function(data)
        {
            $(to).html(data);
        });
    });

    /* AJAX EN ENLACES */
    $('body').on('click', 'a[data-ajax]', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        console.log(url);
        $('.url a').attr('href', url).text(url);
        var to = $(this).attr('data-ajax');
        console.log([to, url]);
        $(to).text('Loading...').load(url, {'to':to, 'url':url});

        /* GO TO TAB !! */
        var tab = url.split('#')[1];
        if (tab != 'undefined')
        {
            $('ul.tabs').tabs('select_tab', tab);
        }
    });
});
