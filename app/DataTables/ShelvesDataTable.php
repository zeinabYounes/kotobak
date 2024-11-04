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
class ShelvesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
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
            $model_edit = $design->make_modal($this->editRow(route("admin.shelves.store"),$query,$query->section_id,"Update"),"Shelf","Edit",$query->id);
            $model_delete = $design->make_modal($this->deleteRow(route("admin.shelves.destroy",$query->id)),"Shelf","Delete",$query->id);
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
      $design = new DesignButton;
      // $model_edit   = $design->make_modal($this->editColumn(route("admin.shelves.store"),$query,$query->section_id,"Update"),"Shelf","Edit",$query->id);

      $model_create = $design->make_modal($this->editRow(route("admin.shelves.store"),null,null,"Create"),"Shelf","Create",0);

      $form = $design->make_create_modal(0) .$model_create;
      $parameters = [
        'dom' => 'Blfrtip',
        'buttons' => [
            [$form ,"excel"]
        ],
        'initComplete'=> DataTableFunc::make_col_search([2,3]),

      ];
      return $this->builder()
                  ->setTableId('shelves-table')
                  ->responsive(true)
                  ->columns($this->getColumns())
                  ->minifiedAjax()
                  ->dom('Bfrtip')
                  ->orderBy(1)
                  ->selectStyleSingle()
                  ->parameters($parameters);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
      return [
          // Column::computed('checkbox')->title('Select')->className('text-center small ')->orderable(false)->searchable(false)->exportable(false)->printable(false)->width('50'),
          Column::make('DT_RowIndex')->title('S/No')->orderable(false)->searchable(false)->addClass('font-weight-bold small  font-italic'),
          Column::make('sh_name')->title('Shelf Name')->addClass('font-weight-bold  font-italic small '),
          Column::make('section_id')->title('section Name')->addClass('font-weight-bold  font-italic small '),
          Column::make('count_books')->title('count books')->addClass('font-weight-bold  font-italic small '),

          Column::make('created_at')->addClass('font-weight-bold  font-italic small '),
          Column::make('updated_at')->addClass('font-weight-bold dt-text font-italic small '),
          Column::computed('action')->title('Action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(60)->addClass('text-center')
      ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Shelves_' . date('YmdHis');
    }
    ///////////////////////////////////////////////
    /*
    * function update section colunm in datatable with modal
    * @param route for editing
    * @return form
    */

    ///////////////////////////////
    // Form::select('section', $sections??[] ,old($section),[ 'data-live-search'=>'true','data-size'=>'3','class'=>'form-control selectpicker '.($errors->has('purchase_account')? 'is-invalid' : null),]).'

    public function editRow($route,$query,$section,$action){
      $sections = Section::pluck('s_name','id')->toArray();
      $id = ($query !=null)?$query->id :"";
      $name = ($query !=null)?$query->sh_name :"";


      $body = '<form action="'.$route.'" method="post">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="shelf_id" value="'.$id.'">

                <div class="row">
                  <div >
                     <label for="" class="form-label"> Name :</label>

                     <input type="text"  value ="'.$name.'" class="form-control" id="nm" placeholder="Enter Shelf Name" name="sh_name">
                  </div>
                  <div >
                     <label for="" class="form-label"> Section :</label>'.
                     html()->select('section_id', $sections??[] ,$section)->class('form-control').'

                  </div>
                  <br>
                  <div class="d-grid mt-2">
                  <button type = "submit" class="btn btn-warning btn-block"> '.$action.'</button>
                  </div>
                </div>
              </form>
      ';
      return $body;
    }
    ////////////////////////////////////////////////////////
    /*
    * function delete  confirm section colunm in datatable with modal
    * @param route for delete
    * @return form
    */
    public function deleteRow($route){
      $text = ' <div class =" text-danger text-bold"> Are You Sure To Delete !? </div>
      ';
      $design = new DesignButton;

      $form = $design->make_delete($route);
      $body =$text . $form;
      return $body;
    }
}
