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
        <?php foreach ($dsMmenu as $menu): ?>
            <li class="nav-item active">
                <a href="<?=HOME_URI?>/<?=$menu->controller?>">
                    <?php if(!empty($menu->icon)):?>
                        <i class="<?=$menu->icon?>"></i>
                    <?php endif; ?>
                    <p><?=$menu->nome?></p>
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


