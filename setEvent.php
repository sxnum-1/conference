<!DOCTYPE html>
<html>
    <head>
        <link href="conference.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <?php
            //This page is used to pass information to the database recieving form data from getSelect.php 
            //notifying the user on its success or failure.
            include './pdo.php';
            //Variables passed by the user in a post method from the form created in getSelects.php
            $day = $_POST["sessionday"];
            $time = $_POST["sessiontime"];
            $room = $_POST["sessionroom"];
            $session = $_POST["session"]; //information used to identify the unique event
            $output = array();
            parse_str($session, $output);
            $origTime = $output["startTime"];
            $origRoom = $output["room"];
            $origName = $output["name"];
            //Queries the database looking for duplicates of the event
            $query = "SELECT * FROM SessionEvent WHERE sessionName='$origName' AND room='$room' AND startTime=FROM_UNIXTIME($time);";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            //If not in the database
            if ($stmt->rowCount() <= 0){
                //deletes existing entry
                $deleteQuery = "DELETE FROM SessionEvent WHERE startTime='$origTime' AND room='$origRoom'";
                if ($day == "sunday"){
                    //updates the session event to a new time.
                    $time = $time + 86400;//this constant represents 24hrs in seconds
                }
                // Sessions are assumed to be an hour long.
                $endTime = $time + 3600;//Represents an hour       
                //the query to reinsert the value with updated values.
                $updateQuery = "INSERT INTO SessionEvent VALUES('$origName', FROM_UNIXTIME($time), FROM_UNIXTIME($endTime),'$room');";
                //delete query
                $stmt = $pdo->prepare($deleteQuery);
                if(! $stmt->execute()){
                    echo "<p>Something went wrong. Could not update entry";
                }
                //reinserts value
                $stmt = $pdo->prepare($updateQuery);
                if(! $stmt->execute()){
                    echo "<p>Something went wrong. Could not update entry";
                }
                //notifies user action was successful
                echo "<p>Session Event is updated</p>";
            }
            // If already in the database then following message is sent
            else{
                echo "<p>Cannot include duplicates. Please try again</p>";
            }
            // This button is used to go back to the event page
            echo "<button><a href='http://192.168.64.3/conference/index.php'>Back</a></button>";
        ?>
    </body>
</html>

