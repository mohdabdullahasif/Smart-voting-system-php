<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $query = "SELECT id, name, password, role FROM users WHERE email = :email LIMIT 0,1";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':email', $data->email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password
        if (password_verify($data->password, $row['password'])) {
            // Log the successful login
            $logQuery = "INSERT INTO logs (user_id, action, status) VALUES (:uid, 'User Login', 'success')";
            $logStmt = $db->prepare($logQuery);
            $logStmt->execute([':uid' => $row['id']]);
            
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "message" => "Successful login.",
                "data" => array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "role" => $row['role']
                )
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("status" => "error", "message" => "Invalid Password."));
        }
    } else {
        http_response_code(404);
        echo json_encode(array("status" => "error", "message" => "User not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Incomplete data."));
}
?>
