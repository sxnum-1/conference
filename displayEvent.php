<?php
    include './pdo.php';
    // Gets the information passed through using fetch API
    $day = $_GET["day"];
    // Queries the database looking for events specific to the date selected
    $query = "SELECT sessionName, TIME_FORMAT(startTime,'%h:%i %p') as startTime, TIME_FORMAT(endTime, '%h:%i %p') as endTime, room FROM SessionEvent WHERE DAYNAME(startTime)='" . $day. "';";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    // Creates a table with the information. The information that is echoed is sent to fetch API.
    echo "<table id='displayTable'>";
    echo "<tr><th>Session</th><th>Start Time</th><th>End Time</th><th>Room</th>";
    while ($event = $stmt->fetch()) {
        $sessionName = $event["sessionName"];
        $startTime = $event["startTime"];
        $endTime = $event["endTime"];
        $room = $event["room"];
        echo "<tr><td>$sessionName</td><td>$startTime</td><td>$endTime</td><td>$room</td></tr>";
    }
    echo "</table>";
?>