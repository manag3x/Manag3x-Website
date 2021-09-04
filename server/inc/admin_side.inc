<?php $user = "admin" ?>
<!--  BEGIN SIDEBAR  -->
<?php $newTask = $Helper::nTask("new"); $newArticle = $Helper::nUser("new-garticles"); $page_view = $page_view ?? ""; $newMsg = $Helper::nUser("new-message",$user) ?>
<div class="sidebar-wrapper sidebar-theme">
    
    <nav id="sidebar">
        <div class="shadow-bottoms"></div>

        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu">
                <a href="./admin" <?php echo $page_view == "dashboard" ? "data-active='true'" : "" ?>
                   aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-home mr-3 fa-xl"></i>
                        <span> Dashboard</span>
                    </div>
                </a>
            </li>

            <!-- customer -->
            <!-- <li class="menu">
                <a href="admin?client" <?php // echo $page_view == "client" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-users mr-3 fa-xl"></i>
                        <span>Clients</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="admin?publisher" <?php // echo $page_view == "publisher" ? "data-active='true'" : "" ?>
                   aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-users mr-3 fa-xl"></i>
                        <span>Publishers</span>
                    </div>
                </a>
            </li> -->
            <!-- inventory -->
            <li class="menu">
                <a href="#submenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-list-alt mr-3 fa-xl"></i>
                        <span>Inventory</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu4" data-parent="#accordionExample">
                    <li>
                        <a href="admin?inventory" <?php echo $page_view == "inventory" ? "data-active='true'" : "" ?>>
                        Active Websites </a>
                    </li>
                    <li>
                        <a href="admin?archive"> Archives </a>
                    </li>
                    <!-- <li>
                        <a href="javascript:void(0);"> Pending Websites </a>
                    </li>
                     -->
                </ul>
            </li>

            <!-- Task -->
            <li class="menu">
                <a href="#submenu09" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-file mr-3 fa-xl"></i>
                        <span>Tasks <span class="badge badge-danger badge-pills"><?php echo ($newTask > 0) ? $newTask : ""; ?></span></span>
                    </div>
                    
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu09" data-parent="">
                    <li>
                        <a href="admin?create-task"> Create Task </a>
                    </li>
                    <li>
                        <a href="admin?new-task"> New Tasks <span class="badge badge-danger "><?php echo ($newTask > 0) ? $newTask : ""; ?></span></a>
                    </li>
<!--                    <li>-->
<!--                        <a href="admin?p-task"> Pending Tasks </a>-->
<!--                    </li>-->
                    <li>
                        <a href="admin?a-task"> Active Tasks </a>
                    </li>
                    <li>
                        <a href="admin?tasks"> All Tasks </a>
                    </li>
                </ul>
            </li>

            <!-- articles -->
            <?php if($Helper::permission("articles")): ?>
            <li class="menu">
                <a href="#submenu00" data-toggle="collapse" aria-expanded="<?php echo ($page_view == "articles" or $page_view == "garticles" or $page_view == "ngarticles") ? "true" : "false" ?>" class="dropdown-toggle ">
                    <div class="icon-container">
                        <i class="far fa-list-alt mr-3 fa-xl"></i>
                        <span>Articles <span class="badge badge-danger badge-pills"><?php echo ($newArticle > 0) ? $newArticle : ""; ?></span></span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu00" data-parent="#accordionExample">
                    <li>
                        <a href="admin?articles" <?php echo $page_view == "articles" ? "data-active='true'" : "" ?>>
                        Writers Articles </a>
                    </li>
                    <li>
                        <a href="admin?ngarticles">New Guest Articles <span class="badge badge-danger "><?php echo ($newArticle > 0) ? $newArticle : ""; ?></span></a>
                    </li>
                    <li>
                        <a href="admin?garticles"> All Guest Articles </a>
                    </li>
                    
                </ul>
            </li>
            <?php endif; ?>
            <!-- user -->
            <?php if($Helper::permission("system_user")): ?>
            <li class="menu">
                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-user mr-3 fa-xl"></i>
                        <span>System Users</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu3" data-parent="#accordionExample">
                    <li>
                        <a href="admin?client"> Clients </a>
                    </li>
                    <li>
                        <a href="admin?publisher"> Publishers </a>
                    </li>
                    <li>
                        <a href="admin?admin"> Admin </a>
                    </li>
                    <li>
                        <a href="admin?editor"> Editors </a>
                    </li>
                    <li>
                        <a href="admin?writer"> Writers </a>
                    </li>
                    <li>
                        <a href="admin?guest"> Guest Writers </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <li class="menu">
                <a href="<?php echo $user ?>/?message"  <?php echo $page_view == "message" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-comment mr-3 fa-xl"></i>
                        <span>Messages <span class="badge badge-danger "><?php echo ($newMsg > 0) ? $newMsg : ""; ?></span></span>
                    </div>
                </a>
            </li>
            <!-- settings -->
            <?php if($Helper::permission("settings")): ?>
            <li class="menu">
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-cogs mr-3 fa-xl"></i>
                        <span>Settings</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu2" data-parent="#accordionExample">
                    <li>
                        <a href="admin?settings&tb=category&nm=Category"> Categories </a>
                    </li>
                    <li>
                        <a href="admin?settings&tb=topics&nm=Topic"> Topics </a>
                    </li>
                    <li>
                        <a href="admin?settings&tb=word_count&nm=Word Count">Content Word Counts </a>
                    </li>
                    <li>
                        <a href="admin?settings&tb=website_limitations&nm=Constraint"> Website Constraints </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <!-- settings -->
            <?php if($Helper::permission("system_logs")): ?>
            <li class="menu">
                <a href="#submenu8" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-cog mr-3 fa-xl"></i>
                        <span>System Log</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu8" data-parent="#accordionExample">
                    <li>
                        <a href="admin?login-log"> User Logins </a>
                    </li>
                    <li>
                        <a href="admin?client-log">Client Activities </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
        
    </nav>

</div>
<!--  END SIDEBAR  -->
