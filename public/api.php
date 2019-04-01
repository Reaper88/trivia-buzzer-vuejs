<?php
$timestamp = time();
include 'config.php';
$data = $_POST;

$dbc = new \PDO('mysql:host='. $db['host'] . ';port=' . $db['port']. ';dbname=' . $db['name'], $db['user'], $db['pass']);
$row = $dbc->prepare("SELECT * FROM config;");
$row->execute();
$config = [];
foreach ($row->fetchAll() as $result) {
    $config = array_merge($config, [$result['config_key'] => $result['value']]);
}
//header('Content-Type: application/json');
switch ($data['action']){
    case 'getRound':
        $row = $dbc->prepare("SELECT value FROM config WHERE config_key = 'round';");
        $row->execute();
        $result = $row->fetch();
        echo $result['value'];
        break;
    case 'getConfig':
        echo json_encode($config);
        break;
    case 'registerClick':    
        $groupeId = $_POST['groupe'];
        $row = $dbc->prepare("INSERT INTO click (groupe,time,round) VALUES ('" . $groupeId . "', '" . $timestamp . "', '" . $config['round'] . "');");
        $row->execute();
        echo json_encode(true);
        break;
    case 'setRound':
        $row = $dbc->prepare("UPDATE config SET value = '" . filter_input(INPUT_POST, 'round',FILTER_VALIDATE_INT) . "' WHERE config_key = 'round';");
        $row->execute();
        echo json_encode(true);
        break;
    case 'getResults':
        $row = $dbc->prepare("SELECT * FROM click WHERE round = '" .filter_input(INPUT_POST, 'round', FILTER_SANITIZE_NUMBER_INT) . "' ORDER BY time DESC LIMIT 0,5");
        $row->execute();
        $result = $row->fetchAll();
        $new_data = [];
        $new_array = [];
        foreach($result as $data) {
            foreach($data as $field => $value) {
                if(!is_int($field)) {
                    $new_array[$field] = $value;
                }
            }
            $new_data[] = $new_array;
        }
        echo json_encode($new_data);
        break;
}