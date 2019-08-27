<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */
?>
<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="../assets/img/profile.jpg">
            </div>
            <div class="info">
                <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Hizrian
									<span class="user-level">Administrator</span>
									<span class="caret"></span>
								</span>
                </a>
                <div class="clearfix"></div>

                <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
                    <ul class="nav">
                        <li>
                            <a href="#profile">
                                <span class="link-collapse">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#edit">
                                <span class="link-collapse">Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings">
                                <span class="link-collapse">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item active">
                <a href="<?=HOME_URI?>">
                    <i class="la la-dashboard"></i>
                    <p>Dashboard</p>
                    <span class="badge badge-count">5</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=HOME_URI?>/usuario">
                    <i class="fas fa-user-friends"></i>
                    <p>Usuarios</p>
                    <span class="badge badge-count">14</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="forms.html">
                    <i class="la la-keyboard-o"></i>
                    <p>Forms</p>
                    <span class="badge badge-count">50</span>
                </a>
            </li>
        </ul>
    </div>
</div>

