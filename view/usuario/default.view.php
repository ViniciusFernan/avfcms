<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$usuarios = (!empty($Param['usuarios']) ? $Param['usuarios'] : NULL);
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
<div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>



<body>
<!-- TOPO -->
<?php require_once ABSPATH.'/view/_include/topo.php'; ?>
<!-- END TOPO -->

<div class="container-fluid">
    <div class="row">

        <!-- MENU -->
            <?php require_once ABSPATH.'/view/_include/menu.php'; ?>
        <!-- END MENU -->

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
<!--                    <div class="btn-group mr-2">-->
<!--                        <button class="btn btn-sm btn-outline-secondary">Share</button>-->
<!--                        <button class="btn btn-sm btn-outline-secondary">Export</button>-->
<!--                    </div>-->
                    <button class="btn btn-sm btn-outline-secondary ">Novo Usuario <i class="fas fa-user-plus"></i></button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NOME</th>
                        <th>EMAIL</th>
                        <th>TELEFONE</th>
                        <th>STATUS</th>
                        <th>AÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if(!empty($usuarios)): ?>
                        <?php foreach($usuarios as $key => $usuario): ?>
                            <tr data-id="<?=$usuario['idUsuario']?>" >
                                <td><?=$usuario['idUsuario']?></td>
                                <td><?=$usuario['nome']?>  <?=$usuario['sobreNome']?></td>
                                <td><?=$usuario['email']?></td>
                                <td><?=$usuario['telefone']?></td>
                                <td class="align-center">
                                    <span class=" <?=(( $usuario['status']=='0' ) ? "btn-danger" : (($usuario['status']=='1') ? "btn-success" : "btn-primary" ) )?> ">
                                        <?=(( $usuario['status']=='0' ) ? "DELETADO" : (($usuario['status']=='1') ? "ATIVO" : "INATIVO" ) )?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Editar</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>

<?php include THEME_DIR . "/_include/footer.php"; ?>


</html>
