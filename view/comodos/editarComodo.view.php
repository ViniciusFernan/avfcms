<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$dadosComodo = (!empty($Param['dadosComodo']) ? $Param['dadosComodo'][0] : NULL);
$locatarios = (!empty($Param['locatarios']) ? $Param['locatarios'] : NULL);
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
                <h1 class="h2">Editar Comodo</h1>
            </div>
            <form >
                <div class="row">
                    <div class="container">
                        <div class="row centered-form">
                            <form role="form">
                                <div class="col-xs-12 col-sm-12 col-md-12 ">
                                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                                        <input type="text" name="idComodo" hidden class="form-control" value="<?=(isset($dadosComodo['idComodo'])) ? $dadosComodo['idComodo'] : ''?>">
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-8 col-sm-8 col-md-8 ">
                                                    <div class="form-group">
                                                        <label class="control-label" >Comodos</label>
                                                        <input type="text" name="imovel"  class="form-control" placeholder="Comodo" value="<?=(isset($dadosComodo['imovel'])) ? $dadosComodo['imovel'] : ''?>">
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 ">
                                                    <div class="form-group">
                                                        <label class="control-label" >Numero</label>
                                                        <input type="text" name="numero" class="form-control" placeholder="Numero" value="<?=(isset($dadosComodo['numero'])) ? $dadosComodo['numero'] : ''?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4 ">
                                                    <div class="form-group">
                                                        <label class="control-label" >Registro Padrão de Luz</label>
                                                        <input type="text" name="registroLuz"  class="form-control" placeholder="Registro Padrão de Luz" value="<?=(isset($dadosComodo['registroLuz'])) ? $dadosComodo['registroLuz'] : ''?>">
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 ">
                                                    <div class="form-group">
                                                        <label class="control-label" >Valor do Aluguel</label>
                                                        <input type="text" name="valor" class="form-control" placeholder="Valor do Aluguel" value="<?=(isset($dadosComodo['valor'])) ? Util::formatRealMoney($dadosComodo['valor']) : ''?>">
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4 ">
                                                    <div class="form-group">
                                                        <label class="control-label" >Situação do comodo</label>
                                                        <select name="status" class="form-control" >
                                                            <option value="1" <?= ($dadosComodo['status']==1) ? "selected" : "" ?> >Desalugado</option>
                                                            <option value="2" <?= ($dadosComodo['status']==2) ? "selected" : "" ?> >Alugado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        <h3 class="form-group">
                                            <?=($dadosComodo['status']==1) ? "Selecionar locatário" : "Alugado" ?>
                                        </h3>


                                        <div class="form-group">
                                            <label class="control-label" >Locatario atual</label>
                                            <select name="status" class="form-control" >
                                                <option >Selecione locatario ... </option>
                                                <?php if(!empty($locatarios)):?>
                                                    <?php foreach($locatarios as $key => $locatario): ?>
                                                        <option value="<?=$locatario['idUsuario']?>" <?= ($locatario['idUsuario']==$dadosComodo['idUsuario']) ? "selected" : "" ?> ><?=$locatario['nome'] .' - '. $locatario['telefone']; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>



                                        <div class="painel-footer" >
                                            <input type="submit" value="SALVAR" class="btn btn-info fa-pull-right">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
</body>

<?php include THEME_DIR . "/_include/footer.php"; ?>


</html>
