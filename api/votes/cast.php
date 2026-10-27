<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->election_id) && !empty($data->candidate_id) && !empty($data->user_id)) {
    
    // Check if election is active
    $election_query = "SELECT status FROM elections WHERE id = :eid";
    $e_stmt = $db->prepare($election_query);
    $e_stmt->execute([':eid' => $data->election_id]);
    $election = $e_stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$election || $election['status'] !== 'active') {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "This election is not currently active."));
        exit;
    }

    // Attempt to insert vote (unique constraint prevents multiple votes)
    try {
        $query = "INSERT INTO votes (election_id, candidate_id, user_id) VALUES (:eid, :cid, :uid)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':eid' => $data->election_id,
            ':cid' => $data->candidate_id,
            ':uid' => $data->user_id
        ]);
        
        // Log vote
        $logQuery = "INSERT INTO logs (user_id, action, status) VALUES (:uid, 'Cast Vote', 'success')";
        $logStmt = $db->prepare($logQuery);
        $logStmt->execute([':uid' => $data->user_id]);

        http_response_code(201);
        echo json_encode(array("status" => "success", "message" => "Your vote has been submitted successfully."));
    } catch(PDOException $e) {
        if($e->getCode() == 23000) { // Integrity constraint violation (Duplicate entry)
            // Log failed vote attempt
            $logQuery = "INSERT INTO logs (user_id, action, status) VALUES (:uid, 'Duplicate Vote Attempt', 'warning')";
            $logStmt = $db->prepare($logQuery);
            $logStmt->execute([':uid' => $data->user_id]);
            
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "You have already voted in this election."));
        } else {
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Failed to cast vote."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Incomplete data."));
}
?>
