<?php
/**
 */
class DataController extends AdminController
{   
    public $cols_of_cols = ['Field'=>'Campo', 'Type'=>'Tipo', 'Null'=>'Nulo', 'Key'=>'Llave', 'Default'=>'Por defecto', 'Extra'=>'Extra'];

    #
    public function before_filter()
    {
        if ( $action = Input::post('action') )
        {
            unset($_POST['action']);
            $this->$action($_POST);
        }
    }

    #
    public function index($table='')
    {
        $this->tables = (new Data)->readTables();
        if ( ! $this->table ) $this->table = $table;
    }

    # REVISED
    public function rows($table='', $page=1)
    {
        if ($table) :
            $this->cols = (new Data)->readCols($table, 'Field');
            $this->n_rows = (new Data)->countRows($table);
            $this->rows = (new Data)->readRows($table, $page);

            $this->pk = (new Data)->getPK($table);
            $this->search_in = Session::has('search_in') ? Session::get('search_in') : $this->pk;
            $this->search_as = Session::has('search_as') ? Session::get('search_as') : '%%';
            $this->search_is = Session::has('search_is') ? Session::get('search_is') : '';
            $this->order = Session::has('order') ? Session::get('order') : 'DESC';
            $this->by = Session::has('by') ? Session::get('by') : $this->pk;
            $this->rows_per_page =
                Session::has('rows_per_page') ? Session::get('rows_per_page') : '10';
            $this->pages = floor($this->n_rows/$this->rows_per_page);
            $this->page = $page;
        endif;
        $this->table = $table;
        $this->tables = (new Data)->readTables();
    }

    # REVISED
    public function row($table, $row_id=0)
    {
        $this->cols = (new Data)->readCols($table);
        $this->row = ($row_id)
            ? (new Data)->readRow($table, $row_id)
            : '';
        $this->table = $table;
        $this->tables = (new Data)->readTables();
    }

    # REVISED
    public function table($table='', $col='')
    {
        $this->col = $col;
        $this->cols = $table ? (new Data)->readCols($table) : [];
        $this->table = $table;
        $this->tables = (new Data)->readTables();
    }

    public function create_col($data)
    {
        (new Data)->createCol($data);
        exit( Redirect::to("admin/data/table/{$data['table']}/{$data['Field']}") );
    }

    public function update_col($data)
    {
        (new Data)->updateCol($data);
        exit( Redirect::to("admin/data/table/{$data['table']}/{$data['Field']}") );
    }

    public static function delete_col($data)
    {
        (new Data)->deleteCol($data);
        exit( Redirect::to("admin/data/table/{$data['table']}") );
    }

    public function create_row($data)
    {
        $id = (new Data)->createRow($data);
        exit( Redirect::to("admin/data/row/{$data['table']}/$id") );
    }

    public function update_row($data)
    {
        (new Data)->updateRow($data);
    }

    public function delete_row($data)
    {
        (new Data)->deleteRow($data);
        exit( Redirect::to("admin/data/row/{$data['table']}") );
    }

    public function create_table($data)
    {
        (new Data)->createTable($data);
        exit( Redirect::to("admin/data/table/{$data['table']}") );
    }

    public function update_table($data)
    {
        (new Data)->updateTable($data);
        exit( Redirect::to("admin/data/table/{$data['table']}") );
    }

    public function delete_table($data)
    {
        (new Data)->deleteTable($data);
        exit( Redirect::to("admin/data/table") );
    }
}
