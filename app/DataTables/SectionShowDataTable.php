<?php

namespace App\DataTables;

use App\Models\Shelf;
use App\Models\Section;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\DataTables\{DesignButton,DataTableFunc};
use Carbon\Carbon;
use DB;
use App\DataTables\ShelvesDataTable;
class SectionShowDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $current = url()->current();
        $arr = explode("/",$current);
        $section_id = end($arr);

        $query = $query->where('shelves.section_id', '=', $section_id );
        $design = new DesignButton;
        return (new EloquentDataTable($query))
        ->editColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
          })
        ->editColumn('updated_at', function ($query) {
               return Carbon::parse($query->created_at)->format('Y-m-d');
           })
        ->editColumn('section_id', function ($query) {
              return $query->section->s_name??'';
           })
        ->addColumn('count_books', function ($query) {
              return $query->loadCount('books')->books_count;
          })
        ->addIndexColumn()
        ->addColumn('action', function ($query) use($design) {
              $datatable  = new ShelvesDataTable;

              $model_edit = $design->make_modal($datatable->editRow(route("admin.shelves.store"),$query,$query->section_id,"Update"),"Shelf","Edit",$query->id);
              $model_delete = $design->make_modal($datatable->deleteRow(route("admin.shelves.destroy",$query->id)),"Shelf","Delete",$query->id);
            return '<div class="btn-group ">'.$design->make_show(route("admin.shelves.show",$query->id))." ".$design->make_edit_modal($query->id)." ".$design->make_delete_modal($query->id).'</div>' .$model_edit.$model_delete;
          })
        ->rawColumns([
            'checkbox', 'action'
         ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Shelf $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $datatable  = new ShelvesDataTable;
        return  $datatable->html();

    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $datatable  = new ShelvesDataTable;
        return $datatable->getColumns();
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SectionShow_' . date('YmdHis');
    }
}
