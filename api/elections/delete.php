<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $query = "DELETE FROM elections WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => $data->id]);
    
    http_response_code(200);
    echo json_encode(array("status" => "success", "message" => "Election deleted."));
}
?>
