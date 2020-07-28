<?php

?>
<html >
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h2 class="title">Instalando AVFCMS - <a href="avfweb.com.br">[http://avfweb.com.br]</a> </h2>
        </div>
        <form id="loginform" class="form-horizontal" role="form" action="">
            <div class="mainbox col-md-6 col-sm-8">
            <div class="panel panel-success" >
                <div class="panel-heading"><div class="panel-title">Configurar Banco de dados</div></div>
                <div style="padding-top:30px" class="panel-body" >

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="text" class="form-control" name="db_host" placeholder="Url do banco">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="text" class="form-control" name="db_name" placeholder="Nome do banco">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="db_user" placeholder="Usuario do banco">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="text" class="form-control" name="db_password" placeholder="Senha do banco">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-door"></i></span>
                        <input type="text" class="form-control" name="db_port" placeholder="Porta do banco" value="3306">
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <a id="btn-login" href="#" class="btn btn-success">Salvar  </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="mainbox col-md-6 col-sm-8">
            <div class="panel panel-info" >
                <div class="panel-heading"><div class="panel-title">Configurar usuario de acesso ao CMS</div></div>
                <div style="padding-top:30px" class="panel-body" >
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <a id="btn-login" href="#" class="btn btn-success">Salvar  </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</body>
</html>