<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$anuncios = (!empty($Param['anuncios']) ? $Param['anuncios'] : NULL);
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
            <?php include THEME_DIR . "/_include/menu.php"; ?>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Meus Anuncios
                    <a class="btn btn-success btn-sm pull-right" href="<?=HOME_URI?>/anuncio/criaranuncio/">Add Anuncio</a>
                </h4>
                <div class="card">
                    <div class="card-body">
                        <tr class="table-responsive">
                            <table class="table table-striped table-hover table-head-bg-info table-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SLUG</th>
                                    <th>TITULO</th>
                                    <th>STATUS</th>
                                    <th>AÇÕES</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if(!empty($anuncios)): ?>
                                    <?php foreach($anuncios as $key => $anuncio): ?>
                                        <tr data-id="<?=$usuario->idAnuncio ?>" >
                                            <td><?=$anuncio->idAnuncio ?></td>
                                            <td><?=$anuncio->SlugAnuncio?> </td>
                                            <td><?=$anuncio->titulo ?></td>
                                            <td class="align-center">
                                            <span class="p-1 <?=(( $anuncio->status=='0' ) ? "btn-danger" : (($anuncio->status=='1') ? "btn-success" : "btn-primary" ) )?> ">
                                                <?=(( $anuncio->status=='0' ) ? "DELETADO" : (($anuncio->status=='1') ? "ATIVO" : "INATIVO" ) )?>
                                            </span>
                                            </td>
                                            <td>
                                                <a href="<?=HOME_URI?>/usuario/viewUsuarioEdit/<?=$anuncio->idAnuncio?>" class="btn btn-primary btn-sm">EDITAR</a>
                                                <a href="<?=HOME_URI?>/usuario/inativarUsuario/<?=$anuncio->idAnuncio?>"  class="btn btn-danger btn-sm">INATIVAR</a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <tr><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></tr>
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
