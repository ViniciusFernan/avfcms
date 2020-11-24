<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 07/03/2019
 * Time: 11:51
 */
?>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/themes/default.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/themes/default.date.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickadate@3.6.4/lib/themes/default.time.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="<?=THEME_URI?>/_assets/css/ready.css">
<!--<link rel="stylesheet" href="--><?//=THEME_URI?><!--/_assets/css/demo.css">-->


<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<style>
    .picker__select--year{
        background: #f3f3f3;
        padding: 0 10px;
    }
</style>

<?php
$colorBusc = array('#2baaea', '#3FE69E', '#F98829', '#9264AA', '#db0a5b', '#27ae60', '#f2d710');
$pos = array_rand($colorBusc);
?>
<meta name="theme-color" content="<?= $colorBusc[$pos]?>">
<meta name="msapplication-navbutton-color" content="<?= $colorBusc[$pos]?>">
<meta name="apple-mobile-web-app-status-bar-style" content="<?= $colorBusc[$pos]?>">
