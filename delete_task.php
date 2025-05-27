<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'No task ID']);
    exit;
}

$userId = $_SESSION['user_id'];
$taskId = $data['id'];

$sql = "DELETE FROM planner WHERE PlannerID = ? AND ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $taskId, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Delete failed']);
}
?>
