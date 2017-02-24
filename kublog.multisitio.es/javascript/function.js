
function materialize()
{
    /* DESPEGABLES */
    $('select').material_select();

    /* POPUP */
    //if ( $('.modal').hasClass('autoopen') ) $('.modal').openModal();
    $('.modal').modal();

    /* CALENDARIO */
    $('.datepicker').pickadate(
    {
        selectMonths: true,
        labelMonthNext: 'Mes siguiente',
        labelMonthPrev: 'Mes anterior',
        labelMonthSelect: 'Seleccione un mes',
        labelYearSelect: 'Seleccione un año',
        monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
        monthsShort: [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
        weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado' ],
        weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],
        weekdaysLetter: [ 'D', 'L', 'M', 'X', 'J', 'V', 'S' ],
        today: 'Hoy',
        clear: 'Limpiar',
        close: '',
        format: 'yyyy-mm-dd',
        firstDay: -50,
        selectYears: 150,
        onSet: function(arg)
        {
            if ('select' in arg) this.close();
        }
    });

    /* PESTANYAS */
    //$('ul.tabs').tabs( 'select_tab', $('#body').data('tab') );
    $('ul.tabs').tabs();

    /* BOTON DESPEGABLE DE LA BARRA DE NAVEGACION */
    $('.dropdown-button').dropdown();

    /* ETIQUETAS */
    $('.chips').material_chip();

    /* AUTO AJUSTAR CAMPOS DE AREA DE TEXTO */
    $('.materialize-textarea').trigger('autoresize');

    /* INFO EMERGENTE EN BOTONES */
    $('.tooltipped').tooltip( {delay:50} );

    /* VENTANA EMERGENTE */
    $('.modal').modal();
}
