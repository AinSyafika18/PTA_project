<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM planner WHERE ID = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $date = $row['Date'];
    if (!isset($tasks[$date])) {
        $tasks[$date] = [];
    }
    $tasks[$date][] = [
        'id' => $row['PlannerID'],
        'content' => $row['Content']
    ];
}

header('Content-Type: application/json');
echo json_encode($tasks);
?>
