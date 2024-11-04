<?php

namespace App\DataTables;

use App\Models\User;
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
class LibrarianDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
      $design = new DesignButton;
      $query = $query->whereHas('roles', function (QueryBuilder $query) {
        $query->where('name', '=', 'librarian');
      });
      return (new EloquentDataTable($query))
      ->editColumn('created_at', function ($query) {
              return Carbon::parse($query->created_at)->format('Y-m-d');
        })
      ->editColumn('updated_at', function ($query) {
             return Carbon::parse($query->created_at)->format('Y-m-d');
         })
      ->addColumn('role', function ($query) {
             return $query->roles[0]->name??"";
        })
      ->addIndexColumn()
      ->addColumn('action', function ($query) use($design) {
            $model_edit = $design->make_modal($this->editRow(route("admin.librarians.store"),$query,"Update"),"Librarian","Edit" ,$query->id);
            $model_delete = $design->make_modal($this->deleteRow(route("admin.librarians.destroy",$query->id)),"Librarian","Delete",$query->id);
          return '<div class="btn-group ">'.$design->make_show(route("admin.librarians.show",$query->id))." ".$design->make_edit_modal($query->id)." ".$design->make_delete_modal($query->id).'</div>' .$model_edit.$model_delete;
        })
      ->rawColumns([
          'action'
       ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $design = new DesignButton;
        $model_create = $design->make_modal($this->editRow(route("admin.librarians.store"),null,"Create"),"Librarian","Create",0);

        $form = $design->make_create_modal(0) .$model_create;
        $parameters = [
          'dom' => 'Blfrtip',
          'buttons' => [
              [$form ,"excel"]
          ],
          'initComplete'=> DataTableFunc::make_col_search([2,3]),

        ];
        return $this->builder()
                    ->setTableId('librarian-table')
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
            Column::make('name')->addClass('font-weight-bold  font-italic small '),
            Column::make('email')->addClass('font-weight-bold  font-italic small '),
            Column::make('role')->addClass('font-weight-bold  font-italic small '),

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
        return 'Librarian_' . date('YmdHis');
    }
    ///////////////////////////////////////////////
    /*
    * function update section colunm in datatable with modal
    * @param route for editing
    * @return form
    */
    public function editRow($route,$qry,$action ){
      $body = '<form action="'.$route.'" method="post">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="user_id" value="'.($qry?$qry->id:'').'">


                <div class="row">
                  <div >
                     <label for="" class="form-label"> Name :</label>
                     <input type="text"  value ="'.($qry?$qry->name:'').'" class="form-control" id="nm" placeholder="Enter Librarian Name" name="name">
                  </div>
                  <div >
                     <label for="" class="form-label"> Email :</label>
                     <input type="email"  value ="'.($qry?$qry->email:'').'" class="form-control" id="nm" placeholder="Enter Librarian Email" name="email">
                  </div>
                  <div >
                     <label for="" class="form-label"> Password :</label>
                     <input type="password"  value ="" class="form-control" id="nm" placeholder="Enter Librarian Password" name="password">
                  </div>
                  <div class="">
                      <label for="password-confirm" class="form-label">Confirm Password</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                  </div>
                  <input type="hidden" name="role" value="2">
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
