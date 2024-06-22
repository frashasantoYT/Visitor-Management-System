<?php
include_once '../config/database.php';
include_once '../src/VisitorController.php';

$visitorController = new VisitorController($conn);

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
$last7Days = date('Y-m-d', strtotime('-7 days'));

$todayVisitors = $visitorController->getVisitorsByDateRange($today, $today);
$yesterdayVisitors = $visitorController->getVisitorsByDateRange($yesterday, $yesterday);
$last7DaysVisitors = $visitorController->getVisitorsByDateRange($last7Days, $today);

$activityFeed = $visitorController->getRecentActivities(); 

$response = [
    'labels' => [],
    'visitors' => [],
    'activity' => []
];

for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i day"));
    $count = count($visitorController->getVisitorsByDateRange($date, $date));
    $response['labels'][] = $date;
    $response['visitors'][] = $count;
}

foreach ($activityFeed as $activity) {
    $response['activity'][] = [
        'time' => $activity['time'],
        'message' => $activity['message']
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
