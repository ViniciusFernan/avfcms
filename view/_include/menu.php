<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */

$dsMmenu = Util::loadMenu();
if($dsMmenu instanceof Exception) echo $dsMmenu->getMessage();
if(!empty($dsMmenu) && is_string($dsMmenu)) echo $dsMmenu;
?>
<ul class="nav">
    <?php if(is_array($dsMmenu)): ?>
        <?php foreach ($dsMmenu as $key => $menuView): ?>
            <li class="nav-item <?=($key==0 ? 'active': '')?>">
                <a href="<?=HOME_URI?>/<?=$menuView->controller?>">
                    <?php if(!empty($menuView->icon)):?>
                        <i class="<?=$menuView->icon?>"></i>
                    <?php endif; ?>
                    <p><?=$menuView->nome?></p>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>


<!--    <li class="nav-item">-->
<!--        <a href="forms.html">-->
<!--            <i class="la la-keyboard-o"></i>-->
<!--            <p>Forms</p>-->
<!--            <span class="badge badge-count">novo</span>-->
<!--        </a>-->
<!--    </li>-->
</ul>


