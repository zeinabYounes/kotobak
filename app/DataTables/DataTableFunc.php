<?php
namespace App\DataTables;



/**
 *
 */
class DataTableFunc
{

  function __construct()
  {
    // code...
  }

  //////////////////////////////////////////////////////////////////////////////
  public static function make_col_search($col = [],$col_sum = [],$total =0){
    $string = "";
    $string2 = "";
    if($col !==[]){
      $string = "[".implode(",",$col)."]";
      $string2 = "[".implode(",",$col_sum)."]";

    }
    $design = new DesignButton;
    $form = $design->make_del_all(route("admin.sections.index"));
    return "function () {
      this.api().table(function () {
        var x = document.createElement('TFOOT');
        var footer = this.createTFoot();
        var row1 = footer.insertRow(-1);
        $(row1).attr( 'id', 'my_tr');
        var arr = ".$string2.";
        var all_column = arr[0];
        for (var i=0; i <all_column ; i++) {
          var th1 = document.createElement('TH');
          $(th1).attr( 'id', 'th_'+i);
          $(th1).attr( 'class', 'font-weight-bold dt-text font-italic');
          $(th1).appendTo($(row1));
        }
      });
      ////////////////////////////////////////////////////
      this.api().columns(".$string.").every(function () {
          var column = this;
          var input = document.createElement(\"input\");
          $(input).attr( 'class', 'col-12 form-control form-control-sm ');
          $(input).appendTo($(column.footer()).empty())
          .on('keyup', function () {
              column.search($(this).val(), false, false, true).draw();
          });
      });

/////////////////////////////////////////////////////////////////////
      jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }

                return a + b;
            }, 0 );
        } );
        ////////////////////////
        this.api().columns(".$string2.").every(function () {
            var arr = ".$string2.";
            var all_column = arr[0];
            var column = this;
            var test = column[0];
            var test2 = test[0];
            if(test2 != all_column){
              var tablesum = this.data().sum();

                var th1 = document.getElementById('th_'+test2);
                var input = '<span>'+tablesum + ' </span>';
                 if(test2 == 0){
                   var input = '<span > SUM </span>';
                 }
                 if(test2 == 1){
                   var input = '<span > '+ ".$total." +' </span>';
                 }
                 $(input).appendTo($(th1).empty());

             }



        });
      ////////  ////////////////////////////////////////////////////////////////////////
      this.api().columns([0]).every(function () {
          var column = this;
          var lable = document.createElement(\"LABEL\");
          $(lable).attr( 'class', 'Banzima-check-container');

          var input = document.createElement(\"input\");

           $(input).attr( 'type', 'checkbox');
           $(input).attr( 'id', 'check_all');
           $(input).attr( 'onclick', 'check_all_func()');

           var span = document.createElement(\"SPAN\");
           $(span).attr( 'class', 'banzima-check-checkmark');

          $(lable).appendTo($(column.footer()).empty());
          $(input).appendTo($(lable).empty());
          $(span).appendTo($(lable));

      });

      this.api().row().every(function () {
         var row =  $('td.table-td');
          var input = document.createElement(\"span\");
          $(input).attr( 'class', 'badge badge-info');
         $(input).appendTo($('td.table-td'));

      });
      // var td_badge = document.querySelectorAll('td.table-td');
      // var padge = document.createElement('span');
      // td_badge.appendChild(padge);



    }";
  }
}
