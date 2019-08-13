<?php

if (!empty($_GET['senha'])):
    include './config.php';
    echo md5(HASH . $_GET['senha']);
endif;


