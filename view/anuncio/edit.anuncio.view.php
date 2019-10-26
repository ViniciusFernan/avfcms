<?php
if (!defined('ABSPATH'))
    exit;
$Param = $this->getParams();
$boxMsg = (!empty($Param['boxMsg']) ? $Param['boxMsg'] : NULL);
$anuncio = (!empty($Param['anuncio']) ? $Param['anuncio'] : NULL);
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
        a[disabled] {
            pointer-events: none;
            opacity: .5;
        }
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
                <form action="<?=HOME_URI?>/anuncio/criaranuncio/<?=(!empty($anuncio->idAnuncio ) ? $anuncio->idAnuncio  : '')?>" method="post"  enctype="multipart/form-data" >
                    <div class="previl"></div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Meu Anuncio
                            <a class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#galeriaAnuncio" <?=(empty($anuncio->idAnuncio ) ?'disabled="disabled" ' : '')?> href="#">Galeria Anuncios</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="idAnuncio" value="<?=(!empty($anuncio->idAnuncio ) ?' $anuncio->idAnuncio ' : '')?>">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group mb-1 col-md-6">
                                    <label for="tituloAnuncio">Titulo:</label>
                                    <input type="text" name="tituloAnuncio" class="form-control" placeholder="Titulo" tabindex="0" value="<?=(!empty($anuncio->tituloAnuncio ) ? $anuncio->tituloAnuncio  : '')?>" >
                                </div>

                                <div class="form-group mb-1 col-md-6">
                                    <label for="slugAnuncio">Slug:</label>
                                    <input type="text" name="slugAnuncio" disabled="disabled" readonly="readonly" class="form-control" placeholder="meuanuncio.com" tabindex="1" value="<?=(!empty($anuncio->slugAnuncio ) ? $anuncio->slugAnuncio  : '')?>" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group mb-1 col-md-3">
                                    <label for="telefone">Telefone:</label>
                                    <input type="text" name="telefone" class="form-control" placeholder="Telefone" tabindex="2"  value="<?=(!empty($anuncio->telefone ) ? $anuncio->telefone  : '')?>">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="telWhatsApp" class="form-control" <?=(!empty($anuncio->telWhatsApp ) ? 'checked' : '')?> value="1">
                                            <span class="form-check-sign font-small">Este numero possui WhatsApp</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-1 col-md-3">
                                    <label for="cpf">Telefone Alt:</label>
                                    <input type="text" name="telefoneAlt" class="form-control" placeholder="Telefone" tabindex="2"  value="<?=(!empty($anuncio->telefoneAlt ) ? $anuncio->telefoneAlt : '')?>">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="telAltWhatsApp" class="form-control" <?=(!empty($anuncio->telAltWhatsApp ) ? 'checked' : '')?> value="1">
                                            <span class="form-check-sign font-small">Este numero possui WhatsApp</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-1 col-md-6">
                                    <label for="cpf">Email:</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email" tabindex="2"  value="<?=(!empty($anuncio->telefone ) ? $anuncio->telefone  : '')?>">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="telAltWhatsApp" class="form-control" <?=(!empty($anuncio->naoReceberEmail ) ? 'checked' : '')?> value="1">
                                            <span class="form-check-sign font-small">Não Exibir Email</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group mb-1 col-md-4">
                                    <label for="cep">CEP:</label>
                                    <input type="text" name="cep" class="form-control" placeholder="CEP" tabindex="2"  value="<?=(!empty($anuncio->cep ) ? $anuncio->cep : '')?>">
                                </div>
                                <div class="form-group mb-1 col-md-6">
                                    <label for="rua">Rua:</label>
                                    <input type="text" name="rua" class="form-control" placeholder="Rua" tabindex="2"  value="<?=(!empty($anuncio->rua ) ? $anuncio->rua : '')?>">
                                </div>
                                <div class="form-group mb-1 col-md-2">
                                    <label for="numero">Numero:</label>
                                    <input type="text" name="numero" class="form-control" placeholder="Numero:99" tabindex="2"  value="<?=(!empty($anuncio->numero ) ? $anuncio->numero  : '')?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group mb-1 col-md-4">
                                    <label for="bairro">Bairro:</label>
                                    <input type="text" name="bairro" class="form-control" placeholder="Bairro" tabindex="2"  value="<?=(!empty($anuncio->bairro ) ? $anuncio->bairro : '')?>">
                                </div>
                                <div class="form-group mb-1 col-md-4">
                                    <label for="cidade">Cidade:</label>
                                    <input type="text" name="cidade" class="form-control" placeholder="Cidade" tabindex="2"  value="<?=(!empty($anuncio->cidade ) ? $anuncio->cidade  : '')?>">
                                </div>
                                <div class="form-group mb-1 col-md-4">
                                    <label for="mapa">Link Maps:</label>
                                    <input type="text" name="maps" class="form-control" placeholder="Maps" tabindex="2"  value="<?=(!empty($anuncio->maps ) ? $anuncio->maps  : '')?>">
                                </div>
                            </div>
                        </div>





                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sobre">Dscrição completa:</label>
                                    <textarea name="sobre" class="form-control" placeholder="Detalhes" style="height: 150px"><?=(!empty($anuncio->sobre ) ? $anuncio->sobre  : '')?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?=((!empty($anuncio->status) && $anuncio->status =='1')  ? 'selected' : '')?>>ATIVO</option>
                                    <option value="2" <?=((!empty($anuncio->status) && $anuncio->status =='2') ? 'selected' : '')?>>INATIVO</option>
                                    <option value="0" <?=((!empty($anuncio->status) && $anuncio->status =='0') ? 'selected' : '')?>>DELETADO</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                        <a class="btn btn-danger" href="<?=HOME_URI?>/anuncio">Cancel</a>
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

<!-- Modal -->
<div class="modal fade" id="galeriaAnuncio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Galeria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

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