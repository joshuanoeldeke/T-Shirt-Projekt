<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$host = 'localhost'; // change to your host
$db   = 'silkskull'; // change to your database name
$user = 'root'; // change to your MySQL username
$pass = ''; // change to your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$data = json_decode(file_get_contents('php://input'));

if(isset($data->operation)){
    $operation = $data->operation;

    switch($operation){
        case 'write':
            $stmt = $pdo->prepare('INSERT INTO cart (product, name, price, quantity, id, timestamp) VALUES (?, ?, ?, ?, ?, ?)');
            foreach($data->cart->items as $item){
                $stmt->execute([$item->product, $item->name, $item->price, $item->quantity, $item->id, $data->datetime]);
            }
            echo json_encode(['result' => 'success']);
            break;
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            break;
    }
}
?>
