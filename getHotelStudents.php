<?php
include './pdo.php';
// Gets the information passed through using fetch API
$room = $_GET["room"];
// Queries the database looking for events specific to the date selected
$query = "SELECT CONCAT(firstName,' ',lastName) AS FName FROM Student WHERE roomNumber='$room'";
$stmt = $pdo->prepare($query);
$stmt->execute();
// Creates a table with the information. The information that is echoed is sent to fetch API.
echo "<table id='displayTable'>";
echo "<tr><th>Names:</th>";
while ($student = $stmt->fetch()) {
    $sessionName = $student["FName"];
    echo "<td>$sessionName</td>";
}
echo "</tr></table>";
 