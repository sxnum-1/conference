<?php
    // Allows the use of a single pdo variable throughout all scripts
    include './pdo.php';
    $sname = $_POST["sessionname"];
    $day = $_POST["sessionday"];
    $time = $_POST["sessiontime"];
    $room = $_POST["sessionroom"];
    // Queries the database looking for events specific to the event selected
    $query = "SELECT sessionName, UNIX_TIMESTAMP(startTime) as startTime, room FROM SessionEvent WHERE sessionName='$sname';";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    // Creates a table with the information. The information that is echoed is sent to fetch API.
    while ($event = $stmt->fetch()) {
        if ($room == $event["room"] && $time == $event["startTime"]){
            echo "<p>Cannot include duplicates. Please try again</p>";
            echo "<button><a href='http://192.168.64.3/conference/attendees.php'>Back</a></button>";
        }
        else{
            if ($day == "saturday"){
                //updates the session event to a new time.
                $query = "UPDATE SessionEvent SET startTime=FROM_UNIXTIME($time) endTime=MAKEDATE($endTime) room=$room WHERE sessionName=$sname";
            }
            else{

            }
        }
    }
?>

