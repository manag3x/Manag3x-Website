<input type="hidden" id="site-name" value="<?php echo $config_inc::$site->name ?>">
<input type="hidden" id="support-mail" value="<?php echo $config_inc::$site->support ?>">
<input type="hidden" id="current-view" value="<?php echo $meta->view_url ?>">
<input type="hidden" id="ctrl-router" value="<?php echo $config_inc::$res->route ?>">
<input type="hidden" id="custom-img" value="<?php echo $config_inc::$res->custom->img ?>">
<input type="hidden" id="uploads-dir" value="<?php echo $config_inc::$res->upload->js ?>">
<span class="d-none request-status"><?php echo json_encode(\server\model\enum\RequestStatus::KEYS) ?></span>
<span class="d-none transaction-type"><?php echo json_encode(\server\model\enum\Transaction::KEYS) ?></span>
<span class="permission-levels d-none"><?php echo json_encode(\server\model\admin\Permissions::get(current_user: false)) ?></span>
