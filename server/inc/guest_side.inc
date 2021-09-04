<?php $user = "guest"; $newMsg = $Helper::nUser("new-message",$user) ?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
    
    <nav id="sidebar">
        <div class="shadow-bottoms"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="<?php echo $user ?>/" <?php echo $page_view == "dashboard" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span> Dashboard</span>
                    </div>
                </a>
            </li>
            
            <!-- inventory -->
            <li class="menu">
                <a href="<?php echo $user ?>/?articles" <?php echo $page_view == "articles" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="far fa-clipboard mr-3 fa-xl"></i>
                        <span>My Articles</span>
                    </div>
                </a>
            </li>
            
            
            <li class="menu">
                <a href="<?php echo $user ?>/?topics" <?php echo $page_view == "topics" ? "data-active='true'" : "" ?> aria-expanded="false" class="dropdown-toggle">
                    <div class="icon-container">
                        <i class="fas fa-globe mr-3 fa-xl"></i><span> Topics </span>
                    </div>
                </a>
            </li>

        </ul>
        
    </nav>

</div>
<!--  END SIDEBAR  -->
