<?php
    // Allows the use of a single pdo variable throughout all scripts
    include './pdo.php';
    //Variables passed by the user in a post method from the form created in getSelects.php
    $sname = $_POST["sessionname"];
    $day = $_POST["sessionday"];
    $time = $_POST["sessiontime"];
    $room = $_POST["sessionroom"];
    // Queries the database looking for events specific to the event selected
    $query = "SELECT * FROM SessionEvent WHERE sessionName='$sname' AND room='$room' AND startTime=FROM_UNIXTIME($time);";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //If not in the database
    if ($stmt->rowCount() <= 0){
        if ($day == "saturday"){
            //updates the session event to a new time. Sessions are assumed to be an hour long.
            $query = "UPDATE SessionEvent SET startTime=FROM_UNIXTIME($time), endTime=MAKEDATE($time+3600), room=$room WHERE sessionName=$sname";
        }
        else{//sunday
            $time = $time + 86400;//this constant represents 24hrs in seconds
            $query = "UPDATE SessionEvent SET startTime=FROM_UNIXTIME($time), endTime=MAKEDATE($time+3600), room='$room' WHERE sessionName='$sname'";
        }
        echo $query;
        //sends query to database
        // $stmt = $pdo->prepare($query);
        // if(!$stmt->execute()) {
        //     echo "<p>Something went wrong. Could not update entry";
        // }
        echo "<p>Session Event is updated</p>";
    }
    // If already in the database then prints a back button to event page and informs user. 
    else{
        echo "<p>Cannot include duplicates. Please try again</p>";
    }
    echo "<button><a href='http://192.168.64.3/conference/index.php'>Back</a></button>";
?>

