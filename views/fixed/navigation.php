<?php
    include "models/functions.php";
    isset($_GET['page']) ? $page = $_GET['page'] : $page = "";

    #GET NAVIGATION
    $navNames = [];
    $navLinks = [];
    $arrNav = printNavigation();
    $categories = getAll("categories");
    if (!isset($_SESSION['user'])){
        foreach ($arrNav as $obj) {
            if ($obj->text != 'Admin panel' && $obj->text != 'Your profile') {
                $navNames[] = $obj->text;
                $navLinks[] = $obj->page;
            }
        }
    }

    if (isset($_SESSION['user']) && $_SESSION['user']->role != "admin") {// || (!isset($_SESSION['user']))
        foreach ($arrNav as $obj) {
            if ($obj->text != 'Admin panel') {
                $navNames[] = $obj->text;
                $navLinks[] = $obj->page;
            }
        }
    }

    if (isset($_SESSION['user']) && $_SESSION['user']->role == "admin") {
        foreach ($arrNav as $obj) {
            if ($obj->text != 'Your profile'){
                $navNames[] = $obj->text;
                $navLinks[] = $obj->page;
            }
        }
    }
?>
<!-- banner -->
<div class="ban-top">
    <div class="container-fluid">
        <div class="top_nav_left">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav menu__list">
                            <?php
                                $br = 0;
                                foreach ($navNames as $name){
                                    if ($br == 0) {
                            ?>
                                        <li class=" menu__item <?= $page ? '' : 'menu__item--current'?>"><a class="menu__link" href="index.php"><?= $name ?> <span class="sr-only">(current)</span></a></li>
                                 <?php }
                                    else if ($br == 1) {
                                 ?>
                                        <li class="dropdown menu__item <?= $page && $page == $navLinks[$br] ? 'menu__item--current' : ''?>">
                                            <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $name ?> <span class="caret"></span></a>
                                            <ul class="dropdown-menu p-5">
                                                <div class="agile_inner_drop_nav_info">
                                                    <div class="col-sm-3">
                                                        <ul class="multi-column-dropdown">
                                                            <?php
                                                                foreach ($categories as $category) {
                                                            ?>
                                                                    <li><a href='index.php?page=<?=$navLinks[$br]?>&category=<?=strtolower($category->name)?>'><?=$category->name?></a></li>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </ul>
                                        </li>
                                    <?php }
                                        else {
                                    ?>
                                            <li class=" menu__item <?= $page && $page == $navLinks[$br] ? 'menu__item--current' : ''?>"><a class="menu__link <?= $navLinks[$br] == "admin_panel" || $navLinks[$br] == "profile" ? "mb-special-link" : ""?>" href="index.php?page=<?=$navLinks[$br]?>"><?= $name?></a></li>
                                        <?php }$br++;}?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="top_nav_right">
            <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                <form action="#" method="post" class="last">
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="display" value="1">
                    <button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //banner-top -->
<!-- Modal1 - SIGN IN -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-sub_agile">
                <div class="col-md-8 modal_body_left modal_body_left1">
                    <h3 class="agileinfo_sign">Sign In <span>Now</span></h3>
                    <form id="mb-form-login">
                        <div class="styled-input agile-styled-input-top">
                            <input type="email" name="login-email" id="login-email"/>
                            <label>Email</label>
                            <span></span>
                        </div>
                        <div class="styled-input">
                            <input type="password" name="login-password" id="login-password"/>
                            <label>Password</label>
                            <span></span>
                        </div>
                        <input type="submit" name="btn-login" id="mb-btn-submit-login" value="Sign In"/>
                        <p class="alert alert-danger mb-d-none" id="mb-login-message"></p>
                    </form>
                    <ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
                        <li><a href="#" class="facebook">
                                <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="twitter">
                                <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="instagram">
                                <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="pinterest">
                                <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div></a></li>
                    </ul>
                    <div class="clearfix"></div>
                    <p><a href="#" data-toggle="modal" data-target="#myModal2" > Don't have an account?</a></p>

                </div>
                <div class="col-md-4 modal_body_right modal_body_right1">
                    <img src="images/log_pic.jpg" alt=" "/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- //Modal content-->
    </div>
</div>
<!-- //Modal1 -->
<!-- Modal2 - SIGN UP-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body modal-body-sub_agile">
                <div class="col-md-8 modal_body_left modal_body_left1">
                    <h3 class="agileinfo_sign">Sign Up <span>Now</span></h3>
                    <form id="mb-form-register"> <!--action="models/register.php" method="post"-->
                        <div class="styled-input agile-styled-input-top">
                            <input type="text" name="first-name" id="first-name"/>
                            <label>First name</label>
                            <span></span>
                        </div>
                        <div class="styled-input">
                            <input type="text" name="last-name" id="last-name"/>
                            <label>Last name</label>
                            <span></span>
                        </div>
                        <div class="styled-input">
                            <input type="email" name="email" id="email"/>
                            <label>Email</label>
                            <span></span>
                        </div>
                        <div class="styled-input">
                            <input type="password" name="password" id="password"/>
                            <label>Password</label>
                            <span></span>
                        </div>
                        <div class="styled-input">
                            <input type="password" name="password-confirm" id="password-confirm"/>
                            <label>Confirm password</label>
                            <span></span>
                        </div>
                        <input type="submit" name="btn-register" id="mb-btn-submit-register" value="Sign Up"/>
                        <p class="alert alert-danger mb-d-none" id="mb-register-message"></p>
                    </form>
                    <ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
                        <li><a href="#" class="facebook">
                                <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="twitter">
                                <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="instagram">
                                <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div></a></li>
                        <li><a href="#" class="pinterest">
                                <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                                <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div></a></li>
                    </ul>
                    <div class="clearfix"></div>
                    <p><a href="#">By clicking register, I agree to your terms</a></p>

                </div>
                <div class="col-md-4 modal_body_right modal_body_right1">
                    <img src="images/log_pic.jpg" alt=" "/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- //Modal content-->
    </div>
</div>
<!-- //Modal2 -->