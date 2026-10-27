<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
$database = new Database();
$db = $database->getConnection();

$election_id = isset($_GET['election_id']) ? $_GET['election_id'] : die(json_encode(["status"=>"error"]));

// Get total votes for this election to calculate percentages
$tq = "SELECT COUNT(*) as total FROM votes WHERE election_id = ?";
$ts = $db->prepare($tq);
$ts->execute([$election_id]);
$total_votes = $ts->fetch(PDO::FETCH_ASSOC)['total'];

// Get votes per candidate
$q = "SELECT c.id, c.name, c.party, COUNT(v.id) as vote_count 
      FROM candidates c 
      LEFT JOIN votes v ON c.id = v.candidate_id 
      WHERE c.election_id = ? 
      GROUP BY c.id ORDER BY vote_count DESC";

$stmt = $db->prepare($q);
$stmt->execute([$election_id]);

$results_arr = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $results_arr[] = array(
        "candidate_id" => $row['id'],
        "name" => $row['name'],
        "party" => $row['party'],
        "votes" => $row['vote_count'],
        "percentage" => $total_votes > 0 ? round(($row['vote_count'] / $total_votes) * 100, 2) : 0
    );
}

http_response_code(200);
echo json_encode(array(
    "status" => "success", 
    "total_votes" => $total_votes,
    "data" => $results_arr
));
?>
