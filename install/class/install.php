<?php
function autoload($class){  require_once $_SERVER['DOCUMENT_ROOT']. "/install/class/".$class.".php"; }
spl_autoload_register("autoload");

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
    
    $arrayUrl = explode('://', $_POST['url_projeto']);
    foreach ($arrayUrl as $key => $url){
        if(in_array(strtolower($url), ['http', 'https', '/', '//', '?', ]) ){
            unserialize($arrayUrl[$key]);
        }
    }
    $_POST['url_projeto'] = '//'.implode('/', $arrayUrl);

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
}

$configClass = new configClass();
$return = $configClass->createConfigAvf($configCms);
if($return instanceof Exception) echo 'deu ruim aqui';

$return = $configClass->createTables($configCms);
if($return instanceof Exception) echo 'deu ruim aqui tambem';

echo 'Instalação concluida';
?>
<script>
window.location.replace("<?="http://" . $_SERVER['SERVER_NAME']; ?>");
</script>




