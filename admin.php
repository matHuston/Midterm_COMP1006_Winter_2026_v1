<?php
require "includes/connect.php";

// query to get all benders, ordered by team name alphabetically
$sql = "SELECT * FROM benders ORDER BY team_name ASC";
$stmt = $pdo->prepare($sql);