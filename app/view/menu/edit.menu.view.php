<?php
if (!defined('APP'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$menuEdit = (!empty($Param['menu']) ? $Param['menu'] : NULL);
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

    <!-- Custom styling plus plugins -->
    <link href="<?= THEME_URI; ?>/_assets/css/myperfil.css" rel="stylesheet">

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
                <div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>

                <?php if(empty($menuEdit->idMenu)):?>
                    <div class="msg-instrucion">
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <h4 class="alert-heading">Atenção!</h4>
                            <p>Após a criação de um menu é necessario criar seus [Controlles, Models, Daos e Etcs...] </p>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif;?>

                <form action="<?=HOME_URI?>/menu/<?=(!empty($menuEdit->idMenu) ? 'editarMenu/'.$menuEdit->idMenu  : 'criarMenu')?>" method="post"  enctype="multipart/form-data" >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <?=(!empty($menuEdit->idMenu) ? ' Editar Menu' : 'Novo Menu')?>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($menuEdit->idMenu)):?>
                            <input type="hidden" name="idMenu" value="<?=$menuEdit->idMenu?>">
                        <?php endif;?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome" tabindex="0" value="<?=(!empty($menuEdit->nome ) ? $menuEdit->nome  : '')?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label for="sobreNome">Controller:</label>
                                    <input type="text" name="controller" class="form-control" placeholder="Controller" tabindex="1" value="<?=(!empty($menuEdit->controller ) ? $menuEdit->controller : '')?>" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-1">
                                    <label for="cpf">Icon:</label>
                                    <input type="text" name="icon" class="form-control" placeholder="ICON" tabindex="2"  value="<?=(!empty($menuEdit->icon ) ? $menuEdit->icon  : '')?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ordem">Ordem:</label>
                                    <input type="text" name="ordem" class="form-control" placeholder="ORDEM" tabindex="7"  value="<?=(!empty($menuEdit->ordem ) ? $menuEdit->ordem  : '')?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Visão Menu:</label>
                                    <select class="form-control" name="private">
                                        <option value="1" <?=((!empty($menuEdit->private) && $menuEdit->private =='1')  ? 'selected' : '')?>>PRIVADO</option>
                                        <option value="0" <?=((!empty($menuEdit->private) && $menuEdit->private =='0') ? 'selected' : '')?>>PUBLICO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?=((!empty($menuEdit->status) && $menuEdit->status =='1')  ? 'selected' : '')?>>ATIVO</option>
                                        <option value="2" <?=((!empty($menuEdit->status) && $menuEdit->status =='2') ? 'selected' : '')?>>INATIVO</option>
                                        <option value="0" <?=((!empty($menuEdit->status) && $menuEdit->status =='0') ? 'selected' : '')?>>DELETADO</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                        <a class="btn btn-danger" href="<?=HOME_URI?>/menu">Cancel</a>
                    </div>
                </div>
                </form>

            </div>
        </div>
        <?php include THEME_DIR . "/_include/footer.php"; ?>
    </div>
</div>
</div>

<?php include THEME_DIR . "/_include/after-footer.php"; ?>

<script>
    $(function () {});

</script>

</html>
