<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cadastro novo usuario</title>
        <?php include THEME_DIR . "/_include/head.php"; ?>


        <!-- Custom styling plus plugins -->
        <link href="<?= HOME_URI; ?>/_assets/css/custom.css" rel="stylesheet">


        <style>
            html, .BGcolorful {
                background:
                        -webkit-linear-gradient(315deg, hsla(196.18, 77.39%, 54.9%, 1) 0%, hsla(196.18, 77.39%, 54.9%, 0) 70%),
                        -webkit-linear-gradient(135deg, hsla(196.21, 100%, 35.84%, 1) 15%, hsla(196.21, 100%, 35.84%, 0) 80%);
                background:
                        linear-gradient(135deg, hsla(196.18, 77.39%, 54.9%, 1) 0%, hsla(196.18, 77.39%, 54.9%, 0) 70%),
                        linear-gradient(315deg, hsla(196.21, 100%, 35.84%, 1) 15%, hsla(196.21, 100%, 35.84%, 0) 80%);


                height: 100%;
                min-height: 100%;
                background-repeat: no-repeat;
            }
            body{background: none}

            .p-404 {
                color: #fff;
                font-size: x-large;
                margin-top: 100px;
                font-weight: bold;
            }

            .p-404 h1{
                color: #fff;
                font-size: x-large;
                font-weight: bold;
                font-size: 108px;
                text-shadow: 3px 3px #000;
            }
            .p-404 h2{
                color: #fff;
                font-size: x-large;
                font-weight: bold;
                font-size:50px;
                text-shadow: 3px 1px #000;
            }

            .p-404 a{
                background: #fff;
                padding: 15px;
                border-radius: 50px;
                box-shadow: 0px 27px 13px -22px #000;
                margin-top: 15px;
                display: inline-block;
            }
        </style>

    </head>


    <body class="nav-md">

        <div class="container body">

            <div class="main_container">

                <!-- page content -->
                <div class="col-md-12">
                    <div class="col-middle">
                        <div class="text-center text-center p-404 ">
                            <h1 class="error-number">404</h1>
                            <h2>Página não encontrada</h2>
                            <a href="<?= HOME_URI; ?>">Voltar para a Home?</a>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

            </div>
            <!-- footer content -->
        </div>

        <!-- /footer content -->
    </body>

    <?php include THEME_DIR . "/_include/footer.php"; ?>
</html>