<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$dadosForm = (!empty($Param['post']) ? $Param['post'] : NULL  );
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);

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

    <title>Cadastro novo usuario</title>

    <?php include THEME_DIR . "/_include/head.php"; ?>

    <!-- Custom styling plus plugins -->
    <link href="<?= THEME_URI; ?>/_assets/css/custom.css" rel="stylesheet">


    <style>

        html {
            background: linear-gradient(315deg, hsl(36, 100%, 51%) 15%, hsla(196.18, 77.39%, 54.9%, 0) 80%),
            linear-gradient(135deg, hsla(196.21, 100%, 35.84%, 1) 0%, hsla(196.21, 100%, 35.84%, 0) 70%);

            background: -webkit-linear-gradient(135deg, hsla(196.18, 77.39%, 54.9%, 1) 15%, hsla(196.18, 77.39%, 54.9%, 0) 80%),
            -webkit-linear-gradient(315deg, hsla(196.21, 100%, 35.84%, 1) 0%, hsla(196.21, 100%, 35.84%, 0) 70%);

            height: auto;
            min-height: 100%;
            background-repeat: no-repeat;
        }
        body{background: none}



        .card-container.card { max-width: 400px; padding: 0  }



    </style>

</head>
<body>

<div class="container">
    <!-- Material form login -->
    <div class="card card-container card-form  card-border-none">

        <h5 class="card-header bg-roxo white-text text-center py-4">
            <img src="<?=$logoSistema?>" style="width: 118px;">
        </h5>


        <!-- Form -->
        <form class="" style="color: #757575;" method="post" action="<?=HOME_URI?>/cadastro/gerarNovaSenha" >

            <div class="card-body">

                <div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>


                <div class="row">
                    <div class="col">
                        <!-- E-mail -->
                        Insira o email que deseja recuperar a senha
                    </div>
                    <br/>
                </div>

                <div class="row">
                    <div class="col">
                        <!-- E-mail -->
                        <div class="form-group">
                            <label ><i style="color: #ff0219">*</i> E-mail</label>
                            <input type="email" class="form-control" name="email" value="<?=(!empty($dadosForm['email'])? $dadosForm['email'] : '' )?>" >
                        </div>
                    </div>
                </div>







                <div class="md-form mt-0 mb-0" style="text-align: left">
                    <a class="btn btn-mdb-color btn-sm my-0" href="<?=HOME_URI?>"  ><i class="fas fa-reply"></i> Voltar ao login </a>
                </div>


            </div>

            <div class="card-footer">
                <!-- Sign in button -->
                <button class="btn bg-roxo btn-rounded btn-block waves-effect " type="submit">Nova Senha</button>
            </div>

        </form>
        <!-- Form -->
    </div>
    <!-- Material form login -->
</div>

</body>

<?php include THEME_DIR . "/_include/footer.php"; ?>



</html>
