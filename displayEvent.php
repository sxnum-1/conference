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
    echo "<tr><th>Session</th><th>Start Time</th><th>End Time</th><th>Room</th><th>Speakers</th>";
    while ($event = $stmt->fetch()) {
        $sessionName = $event["sessionName"];
        $query = "SELECT CONCAT(firstName, ' ', lastName) as Student";
        $startTime = $event["startTime"];
        $endTime = $event["endTime"];
        $room = $event["room"];
        echo "<tr><td>$sessionName</td><td>$startTime</td><td>$endTime</td><td>$room</td><td>";
        //Student speakers associated
        $studentQuery = "SELECT concat(firstName, ' ', LastName) as fullName FROM StudentSpeaksFor INNER JOIN Student ON studentId=id WHERE sessionName='$sessionName'";
        $stmt2 = $pdo->prepare($studentQuery);
        $stmt2->execute();
        $profQuery = "SELECT concat(firstName, ' ', LastName) as fullName FROM ProfessionalSpeaksFor INNER JOIN Professional ON professionalId=id WHERE sessionName='$sessionName'";
        $stmt3 = $pdo->prepare($profQuery);
        $stmt3->execute();
        $sponQuery = "SELECT concat(firstName, ' ', LastName) as fullName FROM SponsorSpeaksFor INNER JOIN Sponsor ON sponsorId=id WHERE sessionName='$sessionName'";
        $stmt4 = $pdo->prepare($sponQuery);
        $stmt4->execute();

        $speakerArr = array();
        while($student = $stmt2->fetch()){
            $speakerArr[] = $student["fullName"];
        }
        //prof Query
        while ($prof = $stmt3->fetch()){
            $speakerArr[] = $prof["fullName"];
        }
        //sponsor query
        while ($spon = $stmt4->fetch()){
            $speakerArr[] = $spon["fullName"];
        }
        for($i=0; $i< sizeof($speakerArr); $i++){
            echo $speakerArr[$i];
            if ($i < sizeof($speakerArr) - 1){
                echo ", ";
            }
        }

        echo "</td></tr>";
    }
    echo "</table>";
?>