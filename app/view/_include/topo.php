<?php
$usuarioLogado = unserialize($_SESSION['usuario']);
?>

<div class="main-header">
    <div class="logo-header">
        <a href="<?=HOME_URI?>/" class="logo">AVF - CMS</a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
    </div>
    <nav class="navbar navbar-header navbar-expand-lg">
        <div class="container-fluid">

            <form class="navbar-left navbar-form nav-search mr-md-3" action="">
                <div class="input-group">
                    <input type="text" placeholder="Search ..." class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-search search-icon"></i>
                        </span>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-envelope"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="la la-bell"></i>
                        <span class="notification">1</span>
                    </a>
                    <ul class="dropdown-menu notif-box" aria-labelledby="navbarDropdown">
                        <li>
                            <div class="dropdown-title">Você tem 1 notificação</div>
                        </li>
                        <li>
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-img">
                                        <img src="<?=(!empty($usuarioLogado->getImgPerfil()) ?  UP_URI."/usuario/{$usuarioLogado->getIdUsuario()}/perfil/{$usuarioLogado->getImgPerfil()}"  :  THEME_URI.'/_assets/images/profile.jpg').'?v-'. rand(0, 1000)  ?>" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
												<span class="block">
													Bem Vindo - <?=$usuarioLogado->getNome(); ?>
												</span>
                                        <span class="time">1 minute ago</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="la la-angle-right"></i> </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                        <img src="<?=(!empty($usuarioLogado->getImgPerfil()) ?  UP_URI."/usuario/{$usuarioLogado->getIdUsuario()}/perfil/{$usuarioLogado->getImgPerfil()}"  :  THEME_URI.'/_assets/images/profile.jpg').'?v-'. rand(0, 1000)  ?>" alt="user-img" width="36" class="img-circle imgPerfil"><span >Vinicius</span></span>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <div class="user-box">
                                <div class="u-img"><img class="imgPerfil" src="<?=(!empty($usuarioLogado->getImgPerfil()) ?  UP_URI."/usuario/{$usuarioLogado->getIdUsuario()}/perfil/{$usuarioLogado->getImgPerfil()}"  :  THEME_URI.'/_assets/images/profile.jpg').'?v-'. rand(0, 1000)  ?>" alt="user"></div>
                                <div class="u-text">
                                    <h4><?=$usuarioLogado->getNome()?></h4>
                                    <p class="text-muted"><?=$usuarioLogado->getEmail()?></p>
                                    <a href="<?=HOME_URI?>/usuario/viewUsuarioEdit/<?=$usuarioLogado->getIdUsuario()?>" class="btn btn-rounded btn-danger btn-sm">Ver Perfil</a>
                                </div>
                            </div>
                        </li>
                        <div class="dropdown-divider"></div>
                        <!-- EXEMPLE <a class="dropdown-item" href="#"></i> My Balance</a>-->
                        <a class="dropdown-item" href="<?=HOME_URI?>/auth/logout"><i class="fa fa-power-off"></i> SAIR</a>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
        </div>
    </nav>
</div>
<?php unset($usuarioLogado);?>