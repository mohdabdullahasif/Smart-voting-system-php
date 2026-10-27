<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->title)) {
    $query = "INSERT INTO elections (title, description, start_date, end_date, status) VALUES (:title, :desc, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 'active')";
    $stmt = $db->prepare($query);
    
    $stmt->execute([
        ':title' => htmlspecialchars(strip_tags($data->title)),
        ':desc' => isset($data->description) ? htmlspecialchars(strip_tags($data->description)) : ''
    ]);
    
    http_response_code(201);
    echo json_encode(array("status" => "success", "message" => "Election created."));
} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Title is required."));
}
?>
