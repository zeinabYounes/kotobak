<?php

namespace App\DataTables;


use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\{Book,Section,Shelf};
use App\DataTables\{DesignButton,DataTableFunc};
use Carbon\Carbon;
use App\DataTables\BooksDataTable;
class ShelfShowDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
      $design = new DesignButton;
      $current = url()->current();
      $arr = explode("/",$current);
      $shelf_id = end($arr);

      $query = $query->where('books.shelf_id', '=', $shelf_id );
      return (new EloquentDataTable($query))

      ->editColumn('section_id', function ($query) {
             return $query->section->s_name;
        })
      ->editColumn('shelf_id', function ($query) {
             return $query->shelf->sh_name;
        })

      ->editColumn('b_photo_path', function ($query) {
             $show = '<a href="'.asset($query->b_photo_path).'" ><img src ="'.asset($query->b_photo_path).'" style=" width:50px; height:50px;" /></>';
             return $show;
        })
      ->addIndexColumn()
      ->addColumn('action', function ($query) use($design) {
        $datatable  = new BooksDataTable;

            $model_edit = $design->make_modal($datatable->editRow(route("admin.books.store"),$query,"Update"),"Book","Edit" ,$query->id);
            $model_delete = $design->make_modal($datatable->deleteRow(route("admin.books.destroy",$query->id)),"Book","Delete",$query->id);
          return '<div class="btn-group ">'.$design->make_disable_show()." ".$design->make_edit_modal($query->id)." ".$design->make_delete_modal($query->id).'</div>' .$model_edit.$model_delete;
        })
      ->rawColumns([
          'b_photo_path', 'action'
       ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Book $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
      $datatable  = new BooksDataTable;
      return  $datatable->html();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
      $datatable  = new BooksDataTable;
      return $datatable->getColumns();
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ShelfShow_' . date('YmdHis');
    }
    /*
    * function update section colunm in datatable with modal
    * @param route for editing
    * @return form
    */

}
