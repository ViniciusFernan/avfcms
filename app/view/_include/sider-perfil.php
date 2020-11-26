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
        <img class="imgPerfil" src="<?=(!empty(unserialize($_SESSION['usuario'])->getImgPerfil()) ?  UP_URI."/usuario/".unserialize($_SESSION['usuario'])->getIdUsuario()."/perfil/".unserialize($_SESSION['usuario'])->getImgPerfil()  :  THEME_URI.'/_assets/images/profile.jpg').'?v-'. rand(0, 1000)  ?>">
    </div>
    <div class="info">
        <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?=unserialize($_SESSION['usuario'])->getNome?>
                            <span class="user-level"><?=unserialize($_SESSION['usuario'])->getNomePerfil?></span>
                            <span class="caret"></span>
                        </span>
        </a>
        <div class="clearfix"></div>

        <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
            <ul class="nav">
                <li>
                    <a href="<?=HOME_URI?>/usuario/viewUsuarioEdit/<?=unserialize($_SESSION['usuario'])->getIdUsuario()?>">
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
