<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Slim\App();
$smarty = new Smarty;

$app->get('/[{page}[/]]', function ($req, $res, $args) use ($app, $smarty) {
    $page = @$args['page'];
    if (!isset($page)) {
        $page = 'home';
    }
    // $smarty->assign('page', $page);
    // $smarty->display("header.tpl.html");
    switch ($page) {
        case 'about':
            $smarty->display("about.tpl.html");
            break;
        case 'privacy':
            $smarty->display("privacy.tpl.html");
            break;
        default:
            $smarty->display("home.tpl.html");
    }
    // $smarty->display("footer.tpl.html");
});

$app->run();
