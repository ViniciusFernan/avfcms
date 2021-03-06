<?php
if (!defined('APP'))
    exit;
$Param = $this->getParams();
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

    <title>Default</title>

    <?php include THEME_DIR . "/_include/head.php"; ?>

    <style>

    </style>

</head>

<body>
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
                <h4 class="page-title">Title</h4>
            </div>
        </div>

        <?php include THEME_DIR . "/_include/footer.php"; ?>

    </div>
</div>
</div>

</body>
<?php include THEME_DIR . "/_include/after-footer.php"; ?>


</html>
