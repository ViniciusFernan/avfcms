<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$usuario = (!empty($Param['usuario']) ? $Param['usuario'][0] : NULL);
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

<div class="wrapper">
    <?php include THEME_DIR . "/_include/topo.php"; ?>
    <div class="sidebar">
        <div class="scrollbar-inner sidebar-wrapper">
            <?php include THEME_DIR . "/_include/sider-perfil.php"; ?>
            <?php include THEME_DIR . "/_include/menu.php"; ?>
        </div>
    </div>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">


                [sexo] => 1

                [status] => 1
                [detalhes] =>
                [imgPerfil] =>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Editar Usuário</div>
                    </div>
                    <div class="card-body">

                        <input type="hidden" value="<?=$usuario['idUsuario'];?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imgPerfil">Imagem de perfil:</label>
                                    <input type="imgPerfil" class="form-control" placeholder="imgPerfil">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nome">Nome:</label>
                                    <input type="nome" class="form-control" placeholder="Nome" tabindex="0" value="<?=$usuario['nome'];?>" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sobreNome">Sobre Nome:</label>
                                    <input type="sobreNome" class="form-control" placeholder="Sobre Nome" tabindex="1" value="<?=$usuario['sobreNome'];?>" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cpf">CPF:</label>
                                    <input type="cpf" class="form-control" placeholder="CPF" tabindex="2"  value="<?=$usuario['CPF'];?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" placeholder="Email" tabindex="3"  value="<?=$usuario['email'];?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefone">Telefone:</label>
                                    <input type="telefone" class="form-control" placeholder="Telefone" tabindex="4"  value="<?=$usuario['telefone'];?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="senha">Senha de acesso:</label>
                                    <input type="senha" class="form-control" placeholder="Senha de acesso" tabindex="5" value="" >
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dataNascimento">Data de nascimento:</label>
                                    <input type="dataNascimento" class="form-control" placeholder="Data de nascimento" tabindex="6"  value="<?=$usuario['dataNascimento'];?>" >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sexo">Sexo:</label><br />

                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="optionsRadios" value="M" checked="">
                                        <span class="form-radio-sign">M</span>
                                    </label>
                                    <label class="form-radio-label ml-3">
                                        <input class="form-radio-input" type="radio" name="optionsRadios" value="F">
                                        <span class="form-radio-sign">F</span>
                                    </label>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="1">ATIVO</option>
                                        <option value="2">INATIVO</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detalhes">Detalhes:</label>
                                    <textarea name="detalhes" class="form-control" placeholder="Detalhes"><?=$usuario['detalhes'];?></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                        <button class="btn btn-danger">Cancel</button>
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
