<?php
require 'db_config.php';

$query = "SELECT * FROM sections";
$result = $conn->query($query);

$sections = array();
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

echo json_encode($sections);
