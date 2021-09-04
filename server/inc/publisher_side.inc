<?php $user = "publisher"; $newMsg = $Helper::nUser("new-message",$user) ?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottoms"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="<?php echo $user ?>/" <?php echo ($page_view == "dashboard" or $page_view == "dashboard" or $page_view == "dashboard") ? "data-active='true'" : "" ?>  class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span> Dashboard</span>
                    </div>
                </a>
            </li>
            
            <!-- inventory -->
            <li class="menu">
                <a href="<?php echo $user ?>/?inventory" <?php echo ($page_view == "inventory" or $page_view == "inventory" or $page_view == "inventory") ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-clipboard mr-3 fa-xl"></i>
                        <span>My Inventory</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="<?php echo $user ?>/?new" <?php echo ($page_view == "new" or $page_view == "new" or $page_view == "new") ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-globe mr-3 fa-xl"></i>
                        <span>Upload Website</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="<?php echo $user ?>/?message"  <?php echo $page_view == "message" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-comment mr-3 fa-xl"></i>
                        <span>Messages <span class="badge badge-danger "><?php echo ($newMsg > 0) ? $newMsg : ""; ?></span></span>
                    </div>
                </a>
            </li>
            <!-- Task -->
            <!-- <li class="menu">
                <a href="#submenu09" data-toggle="collapse" <?php // echo ($page_view == "n-task" or $page_view == "a-task" or $page_view == "tasks") ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-tasks mr-3 fa-xl"></i>
                        <span>Tasks <span class="badge badge-primary badge-pills"><?php // echo 1 //($Helper::nWriter($page_type,"awaiting-editor") > 0) ?  $Helper::nWriter($page_type,"awaiting-editor") : ""?></span></span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu09" data-parent="">
                    <li>
                        <a href="<?php //echo $user ?>/?n-task"> New Tasks <span class="badge badge-danger "><?php //echo //($Helper::nWriter($page_type,"awaiting-editor") > 0) ?  $Helper::nWriter($page_type,"awaiting-editor") : ""?></span></a>
                    </li>
                    
                    <li>
                        <a href="<?php // echo $user ?>/?tasks"> All Tasks </a>
                    </li>
                </ul>
            </li>   -->
        </ul>
        
    </nav>

</div>
<!--  END SIDEBAR  -->

        