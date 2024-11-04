<?php

namespace App\DataTables;

use App\Models\{Role,Permission};
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
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
      ->addIndexColumn()

      ->addColumn('action', function ($query) use($design) {

            $model_edit = $design->make_modal($this->editRow(route("admin.roles.store"),$query,"Update"),"Role","Edit", $query->id);
            $model_delete = $design->make_modal($this->deleteRow(route("admin.roles.destroy",$query->id)),"Role","Delete",$query->id);
          return '<div class="btn-group ">'.$design->make_show(route("admin.roles.show",$query->id))." ".$design->make_edit_modal($query->id)." ".$design->make_delete_modal($query->id).'</div>' .$model_edit.$model_delete;

        })
      ->rawColumns([
          'action'
       ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
      $design = new DesignButton;
      $model_create = $design->make_modal($this->editRow(route("admin.roles.store"),null,"Create"),"Role","Create",0);

      $form = $design->make_create_modal(0) .$model_create;
      $parameters = [
        'dom' => 'Blfrtip',
        'buttons' => [
            [$form ,"excel"]
        ],
        'initComplete'=> DataTableFunc::make_col_search([2,3]),

      ];
      return $this->builder()
                  ->setTableId('roles-table')
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
            Column::make('name')->addClass('font-weight-bold  font-italic small '),
            Column::make('display_name')->addClass('font-weight-bold  font-italic small '),
            Column::make('description')->addClass('font-weight-bold  font-italic small '),
            Column::computed('action')->title('Action')->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(60)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
    ///////////////////////////////////////////////
    /*
    * function update section colunm in datatable with modal
    * @param route for editing
    * @return form
    */
    public function editRow($route,$qry,$action){
      $permissions = Permission::pluck('display_name','id')->toArray();
      $perm ="";

      $perm_id = "";
      if($qry){
        $perm =$qry->permissions;

        $perm_id = ($perm?$perm->pluck('id')->toArray():'');
      }
      $body = '<form action="'.$route.'" method="post">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="role_id" value="'.($qry?$qry->id:'').'">

                <div class="row">
                  <div >
                     <label for="" class="form-label"> Name :</label>
                     <input type="text"  value ="'.($qry?$qry->name:'').'" class="form-control" id="nm" placeholder="Enter  Name" name="name">
                  </div>
                  <div >
                     <label for="" class="form-label"> Dispaly Name :</label>
                     <input type="text"  value ="'.($qry?$qry->display_name:'').'" class="form-control" id="nm" placeholder="Enter Display Name" name="display_name">
                  </div>
                  <div >
                     <label for="" class="form-label"> Description :</label>
                     <textarea class="form-control" name="description"> '.($qry?$qry->description:'').'</textarea>
                  </div>
                  <div >
                     <label for="" class="form-label"> Permissions :</label>'.
                     html()->select('permissions[]', $permissions??[] ,$perm_id)->multiple()->class('form-select').'

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
