<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$menu = (!empty($Param['menu']) ? $Param['menu'] : NULL);
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
                <form action="<?=HOME_URI?>/menu/<?=(!empty($menu->idMenu) ? 'editarMenu/'.$menu->idMenu  : 'criarMenu')?>" method="post"  enctype="multipart/form-data" >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Editar Menu</div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="idMenu" value="<?=(!empty($menu->idMenu ) ? $menu->idMenu  : '')?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label for="nome">Nome:</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome" tabindex="0" value="<?=(!empty($menu->nome ) ? $menu->nome  : '')?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label for="sobreNome">Controller:</label>
                                    <input type="text" name="controller" class="form-control" placeholder="Controller" tabindex="1" value="<?=(!empty($menu->controller ) ? $menu->controller : '')?>" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-1">
                                    <label for="cpf">Icon:</label>
                                    <input type="text" name="icon" class="form-control" placeholder="ICON" tabindex="2"  value="<?=(!empty($menu->icon ) ? $menu->icon  : '')?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ordem">Ordem:</label>
                                    <input type="text" name="ordem" class="form-control" placeholder="ORDEM" tabindex="7"  value="<?=(!empty($menu->ordem ) ? $menu->ordem  : '')?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?=((!empty($menu->status) && $menu->status =='1')  ? 'selected' : '')?>>ATIVO</option>
                                        <option value="2" <?=((!empty($menu->status) && $menu->status =='2') ? 'selected' : '')?>>INATIVO</option>
                                        <option value="0" <?=((!empty($menu->status) && $menu->status =='0') ? 'selected' : '')?>>DELETADO</option>
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
    $(function () {

        $('.foto-perfil').on('click', function(){
            $('[name="imgPerfil"]').trigger('click');
        });

        $('input[name="imgPerfil"]').on("change", function(){
            $('input[name="imgPerfil"]').each(function(index){
                if ($('input[name="imgPerfil"]').eq(index).val() != ""){

                    $('html, body').animate({scrollTop: $('.timelineProfilePic').offset().top-80 }, 'slow');

                    $('.timelineProfilePic').find('.upload').fadeIn();
                }
            });
        });


        $('.foto-perfil-up').on('click', function(){
            var input = $(this).attr('data-up');
            var file_data = $('[name="'+input+'"]').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);

            $.ajax({
                url: '<?=HOME_URI?>/usuario/UploadImagemPerfil',
                dataType: 'text',
                method: 'POST',

                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend: function (xhr) {
                    loading();
                },
                success: function (x) {
                    var resp = JSON.parse(x);
                    $('.upload').fadeOut();
                    $(".loading").remove();  //location.reload(true);
                    $('.imgPerfil').attr({ 'src': resp.url+'?v-'+Math.floor((Math.random() * 1000) + 1) });
                }
            });
        });


        $('#showPassword').on('click', function(){
            var passwordField = $('.password');
            var passwordFieldType = passwordField.attr('type');
            if(passwordFieldType == 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            }else{
                passwordField.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });


    });



</script>

</html>
