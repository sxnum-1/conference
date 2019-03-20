<?php
    // Allows the use of a single pdo variable throughout all scripts
    include './pdo.php';
    //Variables passed by the user in a post method from the form created in getSelects.php
    $session = $_POST["session"];
    $output = array();
    parse_str($sname, $output);
    $origTime = $output["startTime"];
    $origRoom = $output["room"];
    $origName = $output["name"];
    $day = $_POST["sessionday"];
    $time = $_POST["sessiontime"];
    $room = $_POST["sessionroom"];
    // Queries the database looking for duplicates of the event
    $query = "SELECT * FROM SessionEvent WHERE sessionName='$origName' AND room='$room' AND startTime=FROM_UNIXTIME($time);";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //If not in the database
    if ($stmt->rowCount() <= 0){
        $deleteQuery = "DELETE FROM SessionEvent WHERE startTime='$origTime' AND room='$origRoom'";
        if ($day == "sunday"){
            //updates the session event to a new time. Sessions are assumed to be an hour long.
            $time = $time + 86400;//this constant represents 24hrs in seconds
        }
        $endTime = $time + 3600;       
        $updateQuery = "INSERT INTO $SessionEvent VALUES('$origName', FROM_UNIXTIME($time), FROM_UNIXTIME($endTime),'$room');";
        //delete query
        $stmt = $pdo->prepare($deleteQuery);
        if(! $stmt->execute()) {
            echo "<p>Something went wrong. Could not update entry";
        }
        //reinserts value
        $stmt = $pdo->prepare($updateQuery);
        if(! $stmt->execute()) {
            echo "<p>Something went wrong. Could not update entry";
        }

        echo "<p>Session Event is updated</p>";
    }
    // If already in the database then prints a back button to event page and informs user. 
    else{
        echo "<p>Cannot include duplicates. Please try again</p>";
    }
    echo "<button><a href='http://192.168.64.3/conference/index.php'>Back</a></button>";
?>

