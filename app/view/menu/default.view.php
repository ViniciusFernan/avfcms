<?php
if (!defined('APP'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$listaMenu = (!empty($Param['listaMenu']) ? $Param['listaMenu'] : NULL);
$logoSistema = THEME_URI . "/_assets/images/LOGO_DEFAULT.png";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Usuarios</title>

    <?php include THEME_DIR . "/_include/head.php"; ?>

    <!-- Custom styling plus plugins -->
    <link href="<?= THEME_URI; ?>/_assets/css/custom.css" rel="stylesheet">


    <style>

    </style>

</head>
<div class="wrapper">
    <?php include THEME_DIR . "/_include/topo.php"; ?>
    <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
            <?php //include THEME_DIR . "/_include/sider-perfil.php"; ?>
            <?php include THEME_DIR . "/_include/menu.php"; ?>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>
                <h4 class="page-title">
                    Menu
                    <a class="btn btn-primary btn-xs pull-right" href="<?=HOME_URI?>/menu/criarMenu/">Criar Menu</a>
                </h4>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-head-bg-info table-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NOME</th>
                                    <th>CONTROLLER</th>
                                    <th>ORDEM</th>
                                    <th>STATUS</th>
                                    <th>AÇÕES</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(!empty($listaMenu)): ?>
                                    <?php foreach($listaMenu as $key => $menu): ?>
                                        <tr data-id="<?=$menu->idMenu ?>" >
                                            <td><?=$menu->idMenu?></td>
                                            <td><?=$menu->nome?></td>
                                            <td><?=$menu->controller?></td>
                                            <td><?=$menu->ordem?></td>
                                            <td >
                                                <span class="p-1 small <?=(( $menu->status=='0' ) ? "btn-danger" : (($menu->status=='1') ? "btn-success" : "btn-primary" ) )?> ">
                                                    <?=(( $menu->status=='0' ) ? "DELETADO" : (($menu->status=='1') ? "ATIVO" : "INATIVO" ) )?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if($_SESSION['usuario']->idPerfil=='1'): ?>
                                                    <a href="<?=HOME_URI?>/menu/visualizarMenu/<?=$menu->idMenu?>" class="btn btn-primary btn-sm">EDITAR</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include THEME_DIR . "/_include/footer.php"; ?>
    </div>
</div>
</div>

<?php include THEME_DIR . "/_include/after-footer.php"; ?>

</html>
