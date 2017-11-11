<?php
/**
* Copyright [2017] [jaiselrahman]
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*     http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/

ini_set('default_socket_timeout', 600);
ini_set('mysql.connect_timeout', 600);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/flames.php';
require_once __DIR__.'/config.php';
$db = new MySqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_errno) {
    throw new Exception('DataBase Connection Failed');
    exit;
}

$app = new Slim\App();
$smarty = new Smarty;
$smarty->addTemplateDir('../templates');
$smarty->addConfigDir('../configs');

$app->get('/', function ($req, $res, $args) use ($smarty) {
    $n1 = $_GET['name1'];
    $n2 = $_GET['name2'];
    if (isset($n1) and isset($n2) and $n1 == $n2) {
        $result = "Seems to be same person";
    } else {
        $result = flames($n1, $n2);
        global $db;
		$db->query("INSERT INTO flames VALUES('{$n1}', '{$n2}', '{$result}', DEFAULT);");
    }
    $smarty->assign('name1', $n1);
    $smarty->assign('name2', $n2);
    $smarty->assign('result', $result);
    $smarty->display('flames.tpl.html');
});

$app->map(['POST','GET'], '/{name1}[/[{name2}[/]]]', function ($req, $res, $args) use ($smarty) {
    if ($args['name1'] == $args['name2']) {
        $result = "Seems to be same person";
    } elseif (!isset($args['name2'])) {
        $result = "Enter Another Name";
    } else {
        $result = flames($args['name1'], $args['name2']);
        global $db;
		$db->query("INSERT INTO flames VALUES('{$n1}', '{$n2}', '{$result}', DEFAULT);");
    }
    $smarty->assign('name1', $args['name1']);
    $smarty->assign('name2', $args['name2']);
    $smarty->assign('result', $result);
    $smarty->display('flames.tpl.html');
});

$app->run();
