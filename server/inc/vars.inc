<input type="hidden" id="site-name" value="<?php echo $config::$site->name ?>">
<input type="hidden" id="support-mail" value="<?php echo $config::$site->support ?>">
<input type="hidden" id="ctrl" value="<?php echo $config::$user->ctrl ?>">
<input type="hidden" id="custom-img" value="<?php echo $config::$res->custom->img ?>">
<input type="hidden" id="uploads-dir" value="<?php echo $config::$res->upload ?>">
<span class="d-none request-status"><?php echo json_encode(server\enum\Status::KEYS) ?></span>
<span class="d-none permission"><?php echo json_encode(server\model\Permission::$permissions) ?></span>
<span class="d-none s-user-type"><?php echo json_encode(server\enum\User::KEYS) ?></span>
<span class="d-none order-type"><?php echo json_encode(server\enum\OrderType::KEYS) ?></span>
<?php $Helper = $Helper ?? ""; $GLOBALS['activeUser'] = $Helper::activeUser($page_type ?? ""); $activeUser = $GLOBALS['activeUser'];?>
<?php if($page_type == "client"){?>
<input type="hidden" id="project" value="<?php echo $activeUser->project ?>"><?php } ?>
<input type="hidden" id="img-root" value="<?php echo $config::$res->assets->img ?>">
<input type="hidden" id="activeUser" value="<?php echo $activeUser->guid ?>">
<input type="hidden" id="pageType" value="<?php echo $page_type ?>">
<input type="hidden" id="markAsRead" value="<?php echo $Helper::crypt("custom/markasread/") ?>">