<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$lista = (!empty($Param['lista']) ? $Param['lista'] : NULL);
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

    <title>COMODOS</title>
    <?php include THEME_DIR . "/_include/head.php"; ?>

    <!-- Custom styling plus plugins -->
    <link href="<?= THEME_URI; ?>/_assets/css/custom.css" rel="stylesheet">
    <style>
        .block{ display: block }
        a:hover{text-decoration: none}
    </style>

</head>
<div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>

<body>
<!-- TOPO -->
<?php require_once ABSPATH.'/view/_include/topo.php'; ?>
<!-- END TOPO -->

<div class="container-fluid vh100">
    <div class="row vh100">

        <!-- MENU -->
            <?php require_once ABSPATH.'/view/_include/menu.php'; ?>
        <!-- END MENU -->

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Comodos</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" >#</th>
                        <th scope="col" >IMOVEL</th>
                        <th scope="col" >NUMERO</th>
                        <th scope="col" >VALOR DE MERCADO</th>
                        <th scope="col" >STATUS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($lista): ?>
                        <?php foreach($lista as $key => $item ): ?>
                            <tr>
                                <td><a class="block" href="<?=HOME_URI?>/comodos/verComodo/<?=$item['idComodo'];?>"><?=$item['idComodo'];?></a></td>
                                <td><a class="block" href="<?=HOME_URI?>/comodos/verComodo/<?=$item['idComodo'];?>"><?=$item['imovel'];?></a></td>
                                <td><a class="block" href="<?=HOME_URI?>/comodos/verComodo/<?=$item['idComodo'];?>"><?=$item['numero'];?></a></td>
                                <td><a class="block" href="<?=HOME_URI?>/comodos/verComodo/<?=$item['idComodo'];?>"><?=Util::formatRealMoney($item['valor']);?></a></td>
                                <td><a class="block" href="<?=HOME_URI?>/comodos/verComodo/<?=$item['idComodo'];?>"><?=$item['nomeStatus'];?></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
</body>

<?php include THEME_DIR . "/_include/footer.php"; ?>


</html>
