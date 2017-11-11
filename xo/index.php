<?php
    require_once __DIR__.'/../vendor/autoload.php';
    $smarty = new Smarty;
    $smarty->addTemplateDir('../templates');
    $smarty->addConfigDir('../configs');
    $smarty->display('xo.tpl.html');
