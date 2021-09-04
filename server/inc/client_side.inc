<!--  BEGIN SIDEBAR  -->
<?php $aTask = $Helper::nClientTask("active"); $page_view = $page_view ?? ""; ?>
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottoms"></div>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="./client" <?php echo $page_view == "dashboard" ? "data-active='true'" : "" ?>
                   aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-home mr-3 fa-xl"></i>
                        <span> Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="./client?project" <?php echo $page_view == "project" ? "data-active='true'" : "" ?>
                   aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-clipboard mr-3 fa-xl"></i>
                        <span>Start Campaign</span>
                    </div>
                </a>
            </li>
            <!-- inventory -->
            <li class="menu">
                <a href="./client?inventory" <?php echo $page_view == "inventory" ? "data-active='true'" : "" ?>  aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-globe mr-3 fa-xl"></i>
                        <span>View Inventory</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="./client?recommended" <?php echo $page_view == "recommended" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-globe mr-3 fa-xl"></i>
                        <span>Recommended Sites</span>
                    </div>
                </a>
            </li>

            
            <li class="menu">
                <a href="./client?articles" <?php echo $page_view == "articles" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-newspaper mr-3 fa-xl"></i>
                        <span>Articles</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="./client?content" <?php echo $page_view == "content" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-shopping-cart mr-3 fa-xl"></i>
                        <span>Order Content</span>
                    </div>
                </a>
            </li>
            <!-- Task -->
            <li class="menu">
                <a href="#submenu09" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fa fa-tasks mr-3 fa-xl"></i>
                        <span>Tasks <?php if($aTask > 0): ?><span class="badge badge-secondary badge-pills"><?php echo $aTask; ?></span><?php endif; ?></span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu09" data-parent="">
                    <li>
                        <a href="./client?a-task" <?php echo $page_view == "a-task" ? "data-active='true'" : "" ?>> Active Tasks <?php if($aTask > 0): ?><span class="badge badge-secondary "><?php echo $aTask; ?></span><?php endif; ?></a>
                    </li>
                    <li>
                        <a href="./client?tasks" <?php echo $page_view == "tasks" ? "data-active='true'" : "" ?>> All Tasks </a>
                    </li>
                </ul>
            </li>
            
        </ul>
        
    </nav>
</div>
<!--  END SIDEBAR  -->