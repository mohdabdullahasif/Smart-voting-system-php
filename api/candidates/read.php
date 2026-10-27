<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$election_id = isset($_GET['election_id']) ? $_GET['election_id'] : die();

$query = "SELECT id, name, party, description, profile_pic FROM candidates WHERE election_id = ? ORDER BY id ASC";
$stmt = $db->prepare($query);
$stmt->bindParam(1, $election_id);
$stmt->execute();

$candidates_arr = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $candidate_item = array(
        "id" => $id,
        "name" => $name,
        "party" => $party,
        "description" => html_entity_decode($description),
        "profile_pic" => $profile_pic
    );
    array_push($candidates_arr, $candidate_item);
}

http_response_code(200);
echo json_encode(array("status" => "success", "data" => $candidates_arr));
?>
