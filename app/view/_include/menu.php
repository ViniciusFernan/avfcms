<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */
$usuarioLogado = unserialize($_SESSION['usuario']);

$dsMmenu = Util::loadMenu();
if($dsMmenu instanceof Exception) echo $dsMmenu->getMessage();
if(!empty($dsMmenu) && is_string($dsMmenu)) echo $dsMmenu;
?>
<ul class="nav">
    <?php if(is_array($dsMmenu)): ?>
        <?php foreach ($dsMmenu as $key => $menuView): ?>
            <?php if($menuView->getPrivate() == 1 && ($usuarioLogado->getIdPerfil() !='1' && $usuarioLogado->getSuperAdmin() != '1')) continue; ?>
            <li class="nav-item <?=($key==0 ? 'active': '')?>">
                <a href="<?=HOME_URI?>/<?=$menuView->getController()?>">
                    <?php if(!empty($menuView->getIcon())):?>
                        <i class="<?=$menuView->getIcon()?>"></i>
                    <?php endif; ?>
                    <p><?=$menuView->getNome()?></p>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php unset($usuarioLogado); ?>


<!--    <li class="nav-item">-->
<!--        <a href="forms.html">-->
<!--            <i class="la la-keyboard-o"></i>-->
<!--            <p>Forms</p>-->
<!--            <span class="badge badge-count">novo</span>-->
<!--        </a>-->
<!--    </li>-->
</ul>


