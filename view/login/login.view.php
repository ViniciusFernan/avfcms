<?php
$email = (!empty($this->Params['email']) ? $this->Params['email'] : "");
$senha = (!empty($this->Params['senha']) ? $this->Params['senha'] : "");
$boxMsg = (!empty($this->Params['boxMsg']) ? $this->Params['boxMsg'] : NULL);

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

    <title>Login</title>

    <?php include THEME_DIR . "/_include/head.php";?>
    <!-- Custom styling plus plugins -->
    <link href="<?= THEME_URI; ?>/_assets/css/custom.css" rel="stylesheet">

    <!-- Custom styling page -->
    <link href="<?= THEME_URI; ?>/_assets/css/login.css" rel="stylesheet">


</head>
<body>
    <div class="container-full avf_app">
        <div class="card card-container card-form ">
            <div class="profile-img-card">
                <img class="logo" src="<?=$logoSistema?>" />
            </div>

            <div class="msg-box"><?php if(!empty($boxMsg)): echo Util::getAlert($boxMsg['msg'], $boxMsg['tipo']); endif; ?></div>
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" style="color: #757575;" action="<?= HOME_URI ?>/login" method="post">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" class="form-control" placeholder="Email"  name="email" value="<?=$email?>" required autofocus>
                <input type="password" id="inputPassword" class="form-control" placeholder="Senha"  name="senha" value="<?=$senha?>" required>
                <div id="remember" class="checkbox">
                    <div class="d-flex justify-content-around">
                        <!-- Register -->
                        <p class="center">Não é menbro? <a href="<?=HOME_URI?>/cadastro">Registrar</a></p>
                    </div>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">LOGAR</button>
            </form><!-- /form -->
            <!-- Forgot password -->
            <p class="text-right"><a href="<?=HOME_URI?>/recuperarsenha">Esqueceu a senha?</a></p>
        </div><!-- /card-container -->
    </div><!-- /container -->
</body>


<?php include THEME_DIR . "/_include/after-footer.php";?>

</html>
