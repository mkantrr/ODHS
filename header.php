<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <?php if ($_SESSION['system_type'] == 'VMS') {
        echo('<link rel="stylesheet" href="css/vms_base.css" type="text/css">');
    } else if ($_SESSION['system_type'] == 'MedTracker') {
        echo('<link rel="stylesheet" href="css/medtracker_base.css" type="text/css">');
    } else {
        echo('<link rel="stylesheet" href="css/base.css" type="text/css">');
    } ?>

</head>

<header>

    <?PHP
    //Log-in security
    //If they aren't logged in, display our log-in form.
    $showing_login = false;
    if (!isset($_SESSION['logged_in'])) {
        echo '
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/odhs.png">
                    <span id="vms-logo"> ODHS </span>
                </span>
                <img id="menu-toggle" src="images/menu.png">
            </span>
            <ul>
                <li><a href="login.php">Log in</a></li>
            </ul>
        </nav>';
        //      <li><a href="register.php">Register</a></li>     was at line 35

    } else if ($_SESSION['logged_in']) {

        if ($_SESSION['system_type'] == 'MedTracker') {
            if($_SESSION['dark_mode'] == true){
                echo '<script>darkModeToggle();</script>';
                
            }

        /*         * Set our permission array.
         * anything a guest can do, a volunteer and manager can also do
         * anything a volunteer can do, a manager can do.
         *
         * If a page is not specified in the permission array, anyone logged into the system
         * can view it. If someone logged into the system attempts to access a page above their
         * permission level, they will be sent back to the home page.
         */
        //pages guests are allowed to view
        $permission_array['index.php'] = 0;
        $permission_array['about.php'] = 0;
        $permission_array['apply.php'] = 0;
        $permission_array['logout.php'] = 0;
        $permission_array['register.php'] = 0;
        $permission_array['findanimal.php'] = 0;
        //pages volunteers can view
        $permission_array['vms_index.php']= 1;         // Volunteer Management Service
        $permission_array['help.php'] = 1;
        $permission_array['dashboard.php'] = 1;
        $permission_array['calendar.php'] = 1;
        $permission_array['eventsearch.php'] = 1;
        $permission_array['changepassword.php'] = 1;
        $permission_array['editprofile.php'] = 1;
        $permission_array['inbox.php'] = 1;
        $permission_array['date.php'] = 1;
        $permission_array['event.php'] = 1;
        $permission_array['viewprofile.php'] = 1;
        $permission_array['viewnotification.php'] = 1;
        $permission_array['volunteerreport.php'] = 1;
        //pages only managers can view
        $permission_array['personsearch.php'] = 2;
        $permission_array['personedit.php'] = 0; // changed to 0 so that applicants can apply
        $permission_array['viewschedule.php'] = 2;
        $permission_array['addweek.php'] = 2;
        $permission_array['log.php'] = 2;
        $permission_array['reports.php'] = 2;
        $permission_array['eventedit.php'] = 2;
        $permission_array['modifyuserrole.php'] = 2;
        $permission_array['addevent.php'] = 2;
        $permission_array['editevent.php'] = 2;
        $permission_array['roster.php'] = 2;
        $permission_array['report.php'] = 2;
        $permission_array['reportspage.php'] = 2;
        $permission_array['resetpassword.php'] = 2;
        $permission_array['addappointment.php'] = 2;
        $permission_array['addanimal.php'] = 2;
        $permission_array['addservice.php'] = 2;
        $permission_array['addlocation.php'] = 2;
        $permission_array['viewservice.php'] = 2;
        $permission_array['viewlocation.php'] = 2;
        $permission_array['animal.php'] = 2;
        $permission_array['editanimal.php'] = 2;

        $permission_array['centralmenu.php'] = 2;   // admin/main users choose between VMS and Medtracker Dashboard
        // pages adoption center can view
        $permission_array['loghours.php'] = 0;
        $permission_array['loghoursform.php'] = 0;
        $permission_array['template.php'] = 0;

        //Check if they're at a valid page for their access level.
        $current_page = strtolower(substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1));
        $current_page = substr($current_page, strpos($current_page,"/"));
        
        if($permission_array[$current_page]>$_SESSION['access_level']){
            //in this case, the user doesn't have permission to view this page.
            //we redirect them to the index page.
            echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
            //note: if javascript is disabled for a user's browser, it would still show the page.
            //so we die().
            die();
        }
        //This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
        $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
		$venues = array("portland"=>"RMH Portland");
        
        //they're logged in and session variables are set.
        if ($_SESSION['venue'] =="") { 
        	echo(' <a href="' . $path . 'personEdit.php?id=' . 'new' . '">Apply</a>');
        	echo(' | <a href="' . $path . 'logout.php">Logout</a><br>');
        }
        else {
            echo('<nav>');
            echo('<span id="nav-top"><span class="logo"><a class="navbar-brand" href="' . $path . 'index.php"><img src="images/odhs.png"></a>');
            echo('<a class="navbar-brand" id="vms-logo"> MedTracker </a></span><img id="menu-toggle" src="images/menu.png"></span>');
            echo('<ul>');
            //echo " <br><b>"."Gwyneth's Gift Homebase"."</b>|"; //changed: 'Homebase' to 'Gwyneth's Gift Homebase'

            echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'index.php">Home</a></li>');
            //echo('<span class="nav-divider">|</span>');

            echo('<li class="nav-item dropdown">');
            echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Appointments</a>');
            echo('<div class="dropdown-menu" aria-labelledby="navbarDropdown">');
            echo('<a class="dropdown-item" href="' . $path . 'calendar.php">Calendar</a>');
            echo('<a class="dropdown-item" href="' . $path . 'inbox.php">Notifications</a>');
            echo('<a class="dropdown-item" href="' . $path . 'addEvent.php">Add</a>');
            echo('</div>');
            echo('</li>');

	        //echo('<span class="nav-divider">|</span>');
            echo('<li class="nav-item dropdown">');
	        echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Volunteers</a>');
            echo('<div class="dropdown-menu">');
            echo('<a class="dropdown-item" href="' . $path . 'personSearch.php">Search</a>
		        <a class="dropdown-item" href="register.php">Add</a>');
            echo('</div>');
            echo('</li>');

            //echo('<span class="nav-divider">|</span>');
            echo('<li class="nav-item dropdown">');
            echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Animals</a>');
            echo('<div class="dropdown-menu">');
            echo('<a class="dropdown-item" href="' . $path . 'findAnimal.php">Search</a>');
            echo('<a class="dropdown-item" href="' . $path . 'addAnimal.php">Add</a>');
	        echo('<a class="dropdown-item" href="' . $path . 'report.php">Reports</a>');

            echo('</div>');
            echo('</li>');

            //echo('<span class="nav-divider">|</span>');
            echo('<li class="nav-item dropdown">');
            echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>');
            echo('<div class="dropdown-menu">');
            echo('<a class="dropdown-item" href="' . $path . 'addService.php">Add Service</a>');
            echo('<a class="dropdown-item" href="' . $path . 'addLocation.php">Add Location</a>');
	        echo('<a class="dropdown-item" href="' . $path . 'changePassword.php">Change Password</a>');


            echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'darkMode.php">Toggle Dark Mode</a></li>');

            echo('</div>');
            echo('</li>');

	        //if ($_SESSION['access_level'] >= 1) {
                
                // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                //echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'eventSearch.php">Search</a></li>');
                //echo('<button type="button" class="btn btn-link"><a href="' . $path . 'index.php" class="link-primary">home</a></button>');
	        	//echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'about.php">about</a></button>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">help</a></button>');
	            //echo(' | calendars: <a href="' . $path . 'calendar.php?venue=bangor'.''.'">Bangor, </a>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'calendar.php?venue=portland'.''.'">calendar</a></button>'); //added before '<a': |, changed: 'Portland' to 'calendar'
	        //}
	        //if ($_SESSION['access_level'] >= 2) {
	            //echo('<br>master schedules: <a href="' . $path . 'viewSchedule.php?venue=portland'."".'">Portland, </a>');
	            //echo('<a href="' . $path . 'viewSchedule.php?venue=bangor'."".'">Bangor</a>');
	            
                // TODO: update animal search to direct to animal search page and animal add to direct to animal add page
                
	        //}
            //echo('<span class="nav-divider">|</span>');
	        echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Log out</a></li>');
            echo '</ul></nav>';
        }
        }  else if ($_SESSION['system_type'] == 'VMS') {

            /*         * Set our permission array.
             * anything a guest can do, a volunteer and manager can also do
             * anything a volunteer can do, a manager can do.
             *
             * If a page is not specified in the permission array, anyone logged into the system
             * can view it. If someone logged into the system attempts to access a page above their
             * permission level, they will be sent back to the home page.
             */
            if($_SESSION['dark_mode'] == true){
                echo '<script>darkModeToggle();</script>';
                
            }
            //pages guests are allowed to view
            $permission_array['index.php'] = 0;
            $permission_array['about.php'] = 0;
            $permission_array['apply.php'] = 0;
            $permission_array['logout.php'] = 0;
            $permission_array['register.php'] = 0;
            $permission_array['findanimal.php'] = 0;
            //pages volunteers can view
            $permission_array['vms_index.php']= 1;         // Volunteer Management Service
            $permission_array['help.php'] = 1;
            $permission_array['dashboard.php'] = 1;
            $permission_array['calendar.php'] = 1;
            $permission_array['eventsearch.php'] = 1;
            $permission_array['signup.php'] = 1;
            $permission_array['eventsignup.php'] = 1;
            $permission_array['changepassword.php'] = 1;
            $permission_array['editprofile.php'] = 1;
            $permission_array['inbox.php'] = 1;
            $permission_array['date.php'] = 1;
            $permission_array['event.php'] = 1;
            $permission_array['viewprofile.php'] = 1;
            $permission_array['viewnotification.php'] = 1;
            $permission_array['volunteerreport.php'] = 1;
            //pages only managers can view
            $permission_array['personsearch.php'] = 2;
            $permission_array['personedit.php'] = 0; // changed to 0 so that applicants can apply
            $permission_array['viewschedule.php'] = 2;
            $permission_array['addweek.php'] = 2;
            $permission_array['log.php'] = 2;
            $permission_array['reports.php'] = 2;
            $permission_array['eventedit.php'] = 2;
            $permission_array['modifyuserrole.php'] = 2;
            $permission_array['addevent.php'] = 2;
            $permission_array['editevent.php'] = 2;
            $permission_array['roster.php'] = 2;
            $permission_array['report.php'] = 2;
            $permission_array['reportspage.php'] = 2;
            $permission_array['resetpassword.php'] = 2;
            $permission_array['addappointment.php'] = 2;
            $permission_array['addanimal.php'] = 2;
            $permission_array['addservice.php'] = 2;
            $permission_array['addlocation.php'] = 2;
            $permission_array['viewservice.php'] = 2;
            $permission_array['viewlocation.php'] = 2;
            $permission_array['viewarchived.php'] = 2;
            $permission_array['animal.php'] = 2;
            $permission_array['editanimal.php'] = 2;
    
            $permission_array['centralmenu.php'] = 2;   // admin/main users choose between VMS and Medtracker Dashboard
            // pages adoption center can view
            $permission_array['loghours.php'] = 0;
            $permission_array['loghoursform.php'] = 0;
            $permission_array['verificationform.php'] = 0;
            $permission_array['template.php'] = 0;
    
            //Check if they're at a valid page for their access level.
            $current_page = strtolower(substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1));
            $current_page = substr($current_page, strpos($current_page,"/"));
            
            if($permission_array[$current_page]>$_SESSION['access_level']){
                //in this case, the user doesn't have permission to view this page.
                //we redirect them to the index page.
                echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
                //note: if javascript is disabled for a user's browser, it would still show the page.
                //so we die().
                die();
            }
            //This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
            $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
            $venues = array("portland"=>"RMH Portland");
            
            //they're logged in and session variables are set.
            if ($_SESSION['venue'] =="") { 
                echo(' <a href="' . $path . 'personEdit.php?id=' . 'new' . '">Apply</a>');
                echo(' | <a href="' . $path . 'logout.php">Logout</a><br>');
            }
            else {
                echo('<nav>');
                echo('<span id="nav-top"><span class="logo"><a class="navbar-brand" href="' . $path . 'VMS_index.php"><img src="images/odhs.png"></a>');
                echo('<a class="navbar-brand" id="vms-logo"> VMS </a></span><img id="menu-toggle" src="images/menu.png"></span>');
                echo('<ul>');
                //echo " <br><b>"."Gwyneth's Gift Homebase"."</b>|"; //changed: 'Homebase' to 'Gwyneth's Gift Homebase'
                echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'VMS_index.php">Home</a></li>');
                //echo('<span class="nav-divider">|</span>');
    
                // EVENTS DROPDOWN
                echo('<li class="nav-item dropdown">');
                echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Events</a>');
                echo('<div class="dropdown-menu" aria-labelledby="navbarDropdown">');
                echo('<a class="dropdown-item" href="' . $path . 'calendar.php">Calendar</a>');
                echo('<a class="dropdown-item" href="' . $path . 'inbox.php">Notifications</a>');
                if ($_SESSION['type'] == 'main' || $_SESSION['type'] == 'admin') {
                    echo('<a class="dropdown-item" href="' . $path . 'addEvent.php">Add</a>');
                }
                echo('</div>');
                echo('</li>');
                
                //   VOLUNTEERS DROPDOWN
                //echo('<span class="nav-divider">|</span>');
                if ($_SESSION['type'] == 'main' || $_SESSION['type'] == 'admin') {
                    echo('<li class="nav-item dropdown">');
                    echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Volunteers</a>');
                    echo('<div class="dropdown-menu">');
                    echo('<a class="dropdown-item" href="' . $path . 'personSearch.php">Search</a>
                        <a class="dropdown-item" href="register.php">Add</a>');
                    echo('</div>');
                    echo('</li>');
                }
                // OTHERS DROPDOWN
                //echo('<span class="nav-divider">|</span>');
                echo('<li class="nav-item dropdown">');
                echo('<a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>');
                echo('<div class="dropdown-menu">');
                if ($_SESSION['type'] == 'main' || $_SESSION['type'] == 'admin') {
                    echo('<a class="dropdown-item" href="' . $path . 'addLocation.php">Add Location</a>');
                }
                echo('<a class="dropdown-item" href="' . $path . 'changePassword.php">Change Password</a>');
    
                echo('</div>');
                echo('</li>');
    
                //if ($_SESSION['access_level'] >= 1) {
                    
                    // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                    // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                    //echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'eventSearch.php">Search</a></li>');
                    //echo('<button type="button" class="btn btn-link"><a href="' . $path . 'index.php" class="link-primary">home</a></button>');
                    //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'about.php">about</a></button>');
                    //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">help</a></button>');
                    //echo(' | calendars: <a href="' . $path . 'calendar.php?venue=bangor'.''.'">Bangor, </a>');
                    //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'calendar.php?venue=portland'.''.'">calendar</a></button>'); //added before '<a': |, changed: 'Portland' to 'calendar'
                //}
                //if ($_SESSION['access_level'] >= 2) {
                    //echo('<br>master schedules: <a href="' . $path . 'viewSchedule.php?venue=portland'."".'">Portland, </a>');
                    //echo('<a href="' . $path . 'viewSchedule.php?venue=bangor'."".'">Bangor</a>');
                    
                    // TODO: update animal search to direct to animal search page and animal add to direct to animal add page
                    
                //}
                //echo('<span class="nav-divider">|</span>');


                echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'darkMode.php">Toggle Dark Mode</a></li>');

                echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Log out</a></li>');
                echo '</ul></nav>';
            }
        } else {

                /*         * Set our permission array.
                 * anything a guest can do, a volunteer and manager can also do
                 * anything a volunteer can do, a manager can do.
                 *
                 * If a page is not specified in the permission array, anyone logged into the system
                 * can view it. If someone logged into the system attempts to access a page above their
                 * permission level, they will be sent back to the home page.
                 */
                //pages guests are allowed to view
                $permission_array['index.php'] = 0;
                $permission_array['about.php'] = 0;
                $permission_array['apply.php'] = 0;
                $permission_array['logout.php'] = 0;
                $permission_array['register.php'] = 0;
                $permission_array['findanimal.php'] = 0;
                //pages volunteers can view
                $permission_array['VMS_index.php']= 1;         // Volunteer Management Service
                $permission_array['help.php'] = 1;
                $permission_array['dashboard.php'] = 1;
                $permission_array['calendar.php'] = 1;
                $permission_array['eventsearch.php'] = 1;
                $permission_array['changepassword.php'] = 1;
                $permission_array['editprofile.php'] = 1;
                $permission_array['inbox.php'] = 1;
                $permission_array['date.php'] = 1;
                $permission_array['event.php'] = 1;
                $permission_array['viewprofile.php'] = 1;
                $permission_array['viewnotification.php'] = 1;
                $permission_array['volunteerreport.php'] = 1;
                //pages only managers can view
                $permission_array['personsearch.php'] = 2;
                $permission_array['personedit.php'] = 0; // changed to 0 so that applicants can apply
                $permission_array['viewschedule.php'] = 2;
                $permission_array['addweek.php'] = 2;
                $permission_array['log.php'] = 2;
                $permission_array['reports.php'] = 2;
                $permission_array['eventedit.php'] = 2;
                $permission_array['modifyuserrole.php'] = 2;
                $permission_array['addevent.php'] = 2;
                $permission_array['editevent.php'] = 2;
                $permission_array['roster.php'] = 2;
                $permission_array['report.php'] = 2;
                $permission_array['reportspage.php'] = 2;
                $permission_array['resetpassword.php'] = 2;
                $permission_array['addappointment.php'] = 2;
                $permission_array['addanimal.php'] = 2;
                $permission_array['addservice.php'] = 2;
                $permission_array['addlocation.php'] = 2;
                $permission_array['viewservice.php'] = 2;
                $permission_array['viewlocation.php'] = 2;
                $permission_array['viewarchived.php'] = 2;
                $permission_array['animal.php'] = 2;
                $permission_array['editanimal.php'] = 2;
        
                $permission_array['centralmenu.php'] = 2;   // admin/main users choose between VMS and Medtracker Dashboard
                // pages adoption center can view
                $permission_array['loghours.php'] = 0;
                $permission_array['loghoursform.php'] = 0;
        
                //Check if they're at a valid page for their access level.
                $current_page = strtolower(substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1));
                $current_page = substr($current_page, strpos($current_page,"/"));
                
                if($permission_array[$current_page]>$_SESSION['access_level']){
                    //in this case, the user doesn't have permission to view this page.
                    //we redirect them to the index page.
                    echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
                    //note: if javascript is disabled for a user's browser, it would still show the page.
                    //so we die().
                    die();
                }
                //This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
                $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                $venues = array("portland"=>"RMH Portland");
                
                //they're logged in and session variables are set.
                if ($_SESSION['venue'] =="") { 
                    echo(' <a href="' . $path . 'personEdit.php?id=' . 'new' . '">Apply</a>');
                    echo(' | <a href="' . $path . 'logout.php">Logout</a><br>');
                }
                else {
                    echo('<nav>');
                    echo('<span id="nav-top"><span class="logo"><a class="navbar-brand"><img src="images/odhs.png"></a>');
                    echo('<a class="navbar-brand" id="vms-logo"> ODHS Menu </a></span><img id="menu-toggle" src="images/menu.png"></span>');
                    echo('<ul>');
                    echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Log out</a></li>');
                    echo '</ul></nav>';
                }
                }   
    }
    ?>
</header>
