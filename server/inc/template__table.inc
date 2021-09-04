<?php
    $loc = $local;
    $i = 1; $cols = "";
  
    foreach ($loc->thead as $th) {
        if(is_array($th)) $cols .= "<th class='text-center dt-no-sorting'>{$th[0]}</th>";
        else $cols .= "<th class='dt-no-sorting'>$th</th>";
        $i++;
    } 
    $body = $loc->tbody ?? '<tr class="no-results-found"><td colspan="' . $i . '" style="text-align: center">No Result Found</td></tr>';
?>
<table class="table dt-live-dom table-striped table-hover non-hover">
    <thead><tr><th>#</th><?php echo $cols ?></tr></thead> 
    <?php if(@$loc->user): ?>
        <tbody class="<?php echo @$loc->tclass ?>" data-view="<?php echo @$loc->view ?>" id="tablebody" data-src="<?php echo @$loc->src ?>">
        </tbody>
    <?php else : ?>
        <tbody class="table-view-body <?php echo @$loc->tclass ?>"><?php echo $body ?></tbody>
    <?php endif; ?>
</table>