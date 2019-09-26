<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */
?>
<div class="user">
    <div class="photo">
        <img class="imgPerfil" src="<?=(!empty($usuario->imgPerfil ) ?  UP_URI."/usuario/{$_SESSION['usuario']->idUsuario}/perfil/{$usuario->imgPerfil}"  :  THEME_URI.'/_assets/images/profile.jpg').'?v-'. rand(0, 1000)  ?>">
    </div>
    <div class="info">
        <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?=$_SESSION['usuario']->nome?>
                            <span class="user-level"><?=$_SESSION['usuario']->nomePerfil?></span>
                            <span class="caret"></span>
                        </span>
        </a>
        <div class="clearfix"></div>

        <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
            <ul class="nav">
                <li>
                    <a href="<?=HOME_URI?>/usuario/viewUsuarioEdit/<?=$_SESSION['usuario']->idUsuario?>">
                        <span class="link-collapse">Meu Perfil</span>
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
