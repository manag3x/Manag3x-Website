<?php
namespace server\core;

use server\model\Message;

abstract class Template{

   /**
    * Table Template
    *
    * @return void
    */
    public static function table(array $table = []){
        $i = 1; 
        $cols = "";
        // $table = Helper::object($table);
        $SN = ($table['checkbox']) ? '
            <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                <input type="checkbox" class="new-control-input todochkbox" id="todoAll">
                <span class="new-control-indicator"></span>
            </label>' : "S/N";
        foreach ($table['thead'] as $th) {
            if(is_array($th))
                $cols .= "<th class='text-center dt-no-sorting'>{$th[0]}</th>";
            else{
                $th = (strlen($th) > 3) ? ucwords($th) : strtoupper($th);
                $cols .= "<th class='dt-no-sorting'>$th</th>";
            }
            $i++;
        }
        $body = $table['tbody'] ?? '<tr class="no-results-found"><td colspan="' . $i . '" style="text-align: center">No Result Found</td></tr>';
        ?>
        <table id="dataTable" class="table <?php echo $table['pagination'] ?? "dt-live-dom" ?> table-striped  table-bordered
        table-checkable
        table-highlight-head table-hover non-hover">
            <thead><tr><th><?php echo $SN ?></th><?php echo $cols ?></tr></thead> 
            <tbody class="<?php echo $table['tclass'] ?? "" ?>" data-view="<?php echo $table['view'] ?? "" ?>"
                   id="<?php echo $table['tid'] ?? "tablebody" ?>" data-src="<?php echo $table['src'] ?? "" ?>"
                   data-id="<?php echo $table['id'] ?? ""
            ?>"><?php echo $body ?></tbody>
            <tfoot><tr><th>#</th><?php echo $cols ?></tr></tfoot>
        </table>
        <?php
    }
}
