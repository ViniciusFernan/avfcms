<?php
$configCms = null;
if (!empty($_POST) && isset ($_POST)) {
    if(empty($_POST['db_host'])) echo'Necessário informar a url do banco de dados <br/>';
    if(empty($_POST['db_name'])) echo 'Necessário informar o nome do banco de dados <br/>';
    if(empty($_POST['db_user'])) echo 'Necessário informar o usuario do banco de dados <br/>';
    if(empty($_POST['db_password'])) echo 'Necessário informar a senha do banco de dados <br/>';
    if(empty($_POST['nome_projeto'])) echo 'Necessário informar o nome do projeto <br/>';
    if(empty($_POST['url_projeto'])) echo 'Necessário informar a  url do projeto <br/>';
    if(empty($_POST['user_email'])) echo 'Necessário informar o email de acesso ao CMS <br/>';
    if(empty($_POST['password'])) echo 'Necessário informar a senha de acesso ao CMS <br/>';

    $configCms = [
        'db_host' => $_POST['db_host'],
        'db_name' => $_POST['db_name'],
        'db_user' => $_POST['db_user'],
        'db_password' => $_POST['db_password'],
        'db_port' => $_POST['db_port'],
        'nome_projeto' => $_POST['nome_projeto'],
        'url_projeto' => $_POST['url_projeto'],
        'user_email' => $_POST['user_email'],
        'password' => $_POST['password']
    ];

    $configAVF = fopen($_SERVER['DOCUMENT_ROOT'].'/config/config.avf','w');
    if ($configAVF == false) die('Não foi possível criar o arquivo.');

$conteudo = "[DataBase]
db_host     = {$configCms['db_host']}
db_name     = {$configCms['db_name']}
db_user     = {$configCms['db_user']}
db_password = {$configCms['db_password']}
db_port = {$configCms['db_port']}

[Application]
project_name = {$configCms['nome_projeto']} 
app_url   = {$configCms['url_projeto']}

[EmailConfg]
mail_host = smtp.gmail.com
mail_user = avf.sistema@gmail.com
mail_pass = ajsmema
mail_port = 587
mail_send = smtp.gmail.com
mail_send_name = SISTEMA";

    fwrite($configAVF, $conteudo);
    fclose($configAVF);

    header('Location: ./');
}

?>

<html >
<head>
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
        <form class="form-horizontal" role="form" method="post" action="#">
            <div class="mainbox col-md-6 col-sm-8">
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
            <div class="mainbox col-md-6 col-sm-8">
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