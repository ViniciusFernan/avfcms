<?php
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/config.avf')) :
    header('Location: '.$_SERVER['SERVER_NAME'].'/login');
endif;

?>
<html >
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 minimal-ui" />
    <meta name=”mobile-web-app-capable” content=”yes”>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h2 class="title">Instalando AVFCMS - <a href="avfweb.com.br">[http://avfweb.com.br]</a> </h2>
        </div>
        <form class="form-horizontal row" role="form" method="post" action="/install/class/install.php">
            <div class="mainbox col-md-6 col-sm-12">
            <div class="panel panel-success" >
                <div class="panel-heading"><div class="panel-title">Configurar Banco de Dados</div></div>
                <div style="padding-top:30px" class="panel-body" >
                    <label>Url de acesso ao banco de dados</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="db_host" placeholder="Url do banco">
                    </div>

                    <label>Nome do banco de dados</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-database" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="db_name" placeholder="Nome do banco">
                    </div>

                    <label>usuario de acesso ao banco de dados</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="db_user" placeholder="Usuario do banco">
                    </div>

                    <label>Senha de acesso ao banco de dados</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock" aria-hidden="true"></i>
                        </span>
                        <input type="password" class="form-control" name="db_password" placeholder="Senha do banco">
                    </div>

                    <label>Porta de conexão ao banco de dados</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                           <i class="fa fa-cloud" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="db_port" placeholder="Porta do banco" value="3306">
                    </div>
                </div>
            </div>
        </div>
            <div class="mainbox col-md-6 col-sm-12">
            <div class="panel panel-info" >
                <div class="panel-heading"><div class="panel-title">Configurar CMS</div></div>
                <div style="padding-top:30px" class="panel-body" >

                    <label>Nome do projeto</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="nome_projeto" value="" placeholder="Loja do tio">
                    </div>

                    <label>Url do projeto</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="url_projeto" value="" placeholder="lojadotio.com.br">
                    </div>

                    <label>Usuario de acesso administrador (Email)</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="user_email" value="" placeholder="meuemail@admin.com.br">
                    </div>

                    <label>Senha de acesso administrador</label>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock" aria-hidden="true"></i>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="password">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-3 p-md-5">
            <div style="margin:10px 0 20px" class="col-sm-12 ">
                <div class="pull-right controls">
                    <button class="btn btn-success">Salvar</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
</html>