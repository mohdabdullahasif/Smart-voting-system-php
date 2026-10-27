<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->name) &&
    !empty($data->cnic) &&
    !empty($data->email) &&
    !empty($data->password)
){
    // Check if email or CNIC already exists
    $checkQry = "SELECT id FROM users WHERE email = :email OR cnic = :cnic";
    $checkStmt = $db->prepare($checkQry);
    $checkStmt->execute([':email' => $data->email, ':cnic' => $data->cnic]);
    
    if($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Email or CNIC is already registered."));
        exit;
    }

    $query = "INSERT INTO users SET name=:name, cnic=:cnic, email=:email, phone=:phone, password=:password, role=:role";
    $stmt = $db->prepare($query);
    
    // Sanitize and encrypt
    $name = htmlspecialchars(strip_tags($data->name));
    $cnic = htmlspecialchars(strip_tags($data->cnic));
    $email = htmlspecialchars(strip_tags($data->email));
    $phone = isset($data->phone) ? htmlspecialchars(strip_tags($data->phone)) : null;
    $password_hash = password_hash($data->password, PASSWORD_BCRYPT);
    $role = isset($data->role) && in_array($data->role, ['voter', 'candidate']) ? $data->role : 'voter';
    
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":cnic", $cnic);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":password", $password_hash);
    $stmt->bindParam(":role", $role);
    
    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("status" => "success", "message" => "User was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("status" => "error", "message" => "Unable to create user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Unable to create user. Data is incomplete."));
}
?>
