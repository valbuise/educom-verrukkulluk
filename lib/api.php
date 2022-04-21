<?php 



$rating = isset($_POST['rating']) ? $_POST['rating'] : "";

$avgRating = $rating - 2; //placeholder, puur om de output te testen

header('Content-Type: application/json; charset=utf-8');
echo json_encode(["success" => true, "rating" => $rating, "avgRating" => $avgRating]);

?>