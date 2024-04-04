<?php
    session_start();
    include "config/conn.php";
    include "models/utility.php";

	include_once "views/fixed/head.php";
	include_once "views/fixed/header.php";

	#RUTIRANJE
	isset($_GET['page']) ? $page = $_GET['page'] : $page = "";
	if ($page){
        if ($page=="profile") {
            if (isset($_SESSION['user']) &&  $_SESSION['user']->role!="admin"){//admin doesn't have a profile page
                include_once "views/pages/${page}.php";
            }
            else {
                include_once "views/pages/home.php";
            }
        }
        else if ($page=="admin_panel" || $page=="insert-articles" || $page=="insert-users" || $page=="insert-categories" ||
                 $page=="insert-articles_genders" || $page=="edit-users" || $page=="edit-articles" || $page=="edit-categories" || $page=="edit-articles_genders"){
            if (isset($_SESSION['user']) &&  $_SESSION['user']->role=="admin") {
                include_once "views/pages/${page}.php";
            }
            else {
//                redirect("https://www.youtube.com/watch?v=E8nOJ4LGhIM");
                include_once "views/pages/home.php";
            }
        }
        else {
            include_once "views/pages/${page}.php";
        }
	}
	else {
		include_once "views/pages/home.php";
	}

	include_once "views/fixed/footer.php";
?>