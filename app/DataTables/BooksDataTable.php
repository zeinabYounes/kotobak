<?php

namespace App\DataTables;

use App\Models\{Book,Section,Shelf};
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
class BooksDataTable extends DataTable
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
              $model_edit = $design->make_modal($this->editRow(route("admin.books.store"),$query,"Update"),"Book","Edit" ,$query->id);
              $model_delete = $design->make_modal($this->deleteRow(route("admin.books.destroy",$query->id)),"Book","Delete",$query->id);
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
      $design = new DesignButton;
      $model_create = $design->make_modal($this->editRow(route("admin.books.store"),null,"Create"),"Section","Create",0);

      $form = $design->make_create_modal(0) .$model_create;
      $parameters = [
        'dom' => 'Blfrtip',
        'buttons' => [
            [$form ,"excel"]
        ],
        'initComplete'=> DataTableFunc::make_col_search([2,3]),

      ];
      return $this->builder()
                  ->setTableId('books-table')
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
          Column::make('DT_RowIndex')->title('S/No')->orderable(false)->searchable(false)->addClass('font-weight-bold small  font-italic'),
          Column::make('title')->addClass('font-weight-bold  font-italic small '),
          Column::make('auther')->addClass('font-weight-bold  font-italic small '),
          Column::make('copies_all')->addClass('font-weight-bold dt-text font-italic small '),

          Column::make('b_photo_path')->title('photo book')->addClass('font-weight-bold  font-italic small '),
          Column::make('edition')->addClass('font-weight-bold  font-italic small '),
          Column::make('genre')->addClass('font-weight-bold dt-text font-italic small '),
          Column::make('ISBN')->addClass('font-weight-bold dt-text font-italic small '),
          Column::make('published_year')->addClass('font-weight-bold dt-text font-italic small '),
          Column::make('copies_borrowed')->addClass('font-weight-bold dt-text font-italic small '),

          Column::make('published_year')->addClass('font-weight-bold dt-text font-italic small '),

          Column::make('section_id')->title('book section')->addClass('font-weight-bold dt-text font-italic small '),
          Column::make('shelf_id')->title('book shelf')->addClass('font-weight-bold dt-text font-italic small '),
          Column::make('allowed_days')->addClass('font-weight-bold dt-text font-italic small '),

          Column::computed('action')->title('Action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(60)->addClass('text-center')
      ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Books_' . date('YmdHis');
    }
    /*
    * function update section colunm in datatable with modal
    * @param route for editing
    * @return form
    */
    public function editRow($route,$qry,$action){
      $sections = Section::pluck('s_name','id')->toArray();
      $shelves = Shelf::pluck('sh_name','id')->toArray();

      $body = '<form action="'.$route.'" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="book" value="'.($qry?$qry->id:'').'">

                <div class="row">
                  <div >
                     <label for="" class="form-label"> Title :</label>
                     <input type="text" name="title"  value ="'.($qry?$qry->title:'').'" class="form-control" id="nm" placeholder="Enter Book Title" >
                  </div>
                  <div >
                     <label for="" class="form-label"> Auther :</label>
                     <input type="text" name="auther"  value ="'.($qry?$qry->auther:'').'" class="form-control" id="nm" placeholder="Enter Book Auther" >
                  </div>
                  <div >
                     <label for="" class="form-label"> Edition :</label>
                     <input type="text" name="edition"  value ="'.($qry?$qry->edition:'').'" class="form-control" id="nm" placeholder="Enter Book Edition" >
                  </div>
                  <div >
                     <label for="" class="form-label"> Genre :</label>
                     <input type="text" name="genre"  value ="'.($qry?$qry->genre:'').'" class="form-control" id="nm" placeholder="Enter Book Genre" >
                  </div>
                  <div >
                     <label for="" class="form-label"> ISBN :</label>
                     <input type="text" name="ISBN"  value ="'.($qry?$qry->ISBN:'').'" class="form-control" id="nm" placeholder="Enter Book ISBN" >
                  </div>
                  <div >
                     <label for="" class="form-label"> Book Photo :</label>
                     <input type="file" name="b_photo_path"  value ="'.($qry?$qry->b_photo_path:'').'" class="form-control" id="nm" placeholder="Select Book Photo" >
                  </div>
                  <div >
                     <label for="year" class="form-label"> Published Year :</label>
                     <input type="number" name="published_year" step="1" min="1" max="2100" value ="'.($qry?$qry->published_year:'').'" class="form-control" id="nm" placeholder="Enter Book Published Year" >
                  </div>
                  <div >
                     <label for="year" class="form-label"> Counts Copies :</label>
                     <input type="number" name="copies_all" step="1" min="1"  value ="'.($qry?$qry->copies_all:'').'" class="form-control" id="nm" placeholder="Enter counts copies all " >
                  </div>
                  <div >
                     <label for="year" class="form-label"> Allowed Days To Borrow :</label>
                     <input type="number" name="allowed_days" step="1" min="1" max="30"  value ="'.($qry?$qry->allowed_days:'').'" class="form-control" id="nm" placeholder="Enter Allowed Days   " >
                  </div>
                  <div >
                     <label for="" class="form-label"> Section :</label>'.
                     html()->select('section', $sections??[] ,($qry?$qry->section_id:''))->class('form-control').'
                  </div>
                  <div >
                     <label for="" class="form-label"> Shelf:</label>'.
                     html()->select('shelf', $shelves??[] ,($qry?$qry->shelf_id:''))->class('form-control').'
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
    ////////////////////////////////////////////////////////
}
