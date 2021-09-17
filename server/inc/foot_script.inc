<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo $config::$assets->custom->js ?>osai.js"></script>
<script src="<?php echo $config::$assets->custom->js ?>CONSTANTS.js"></script>
<script src="<?php echo $config::$assets->plugin ?>jquery-3.6.0.js"></script>
<script src="<?php echo $config::$assets->plugin ?>bootstrap/js/popper.min.js"></script>
<script src="<?php echo $config::$assets->plugin ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $config::$assets->plugin ?>perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo $config::$assets->js ?>app.js"></script>
<script>$(document).ready(function() {App.init();});</script>
<script src="<?php echo $config::$assets->js ?>custom.js"></script>

<script src="<?php echo $config::$assets->custom->js ?>content.js"></script>
<script src="<?php echo $config::$assets->custom->js ?>protocoll.js"></script>
<script src="<?php echo $config::$assets->custom->js ?>script.js"></script>
<script src="<?php echo $config::$assets->custom->js ?>multi.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<?php
    foreach ($js as $script): ?> <script src="<?php echo $config::$assets->js . $script ?>.js"></script> <?php endforeach;
    foreach ($custom_js as $script): ?> <script src="<?php echo $config::$assets->custom->js .$script ?>.js"></script> <?php endforeach;
    foreach ($plugin_js as $script): ?> <script src="<?php echo $config::$assets->plugin .$script ?>.js"></script> <?php endforeach;
?>
