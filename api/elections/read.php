<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id, title, description, start_date, end_date, status FROM elections ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();

$elections_arr = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $election_item = array(
        "id" => $id,
        "title" => $title,
        "description" => html_entity_decode($description),
        "start_date" => $start_date,
        "end_date" => $end_date,
        "status" => $status
    );
    array_push($elections_arr, $election_item);
}

http_response_code(200);
echo json_encode(array("status" => "success", "data" => $elections_arr));
?>
