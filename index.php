<?php

/**
 * Primeiro arquivo a ser executado.
 *
 * @package Sistema de Lead
 * @author AVFWEB
 * @version 1.0
 */
//Importa as configurações iniciais do sistema [bd|autoload|etc]
require __DIR__.'/config/config.php';
require __DIR__.'/core/autoload_avf.php';
$ExecApp = new Application();
$ExecApp->dispatch();
