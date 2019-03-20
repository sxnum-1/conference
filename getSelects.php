<?php
    //This file is for getting user information for switching data 
    // Allows the use of a single pdo variable throughout all scripts
    include './pdo.php';
    //gets possible day selections
    echo "<div id='dayselectdiv'>";
        echo "<h3>Select Day:</h3>";
        //Gets the days to select from;
        echo "<select id='sessionselect' name='sessionday' form='setEventForm'>";
        echo "<option value='saturday'>Saturday</option>";
        echo "<option value='sunday'>Sunday</option>";
        echo "</select><br>";
    echo "</div>";

//Gets the possible rooms to select from";
    echo "<div id='roomselectdiv'>";
        echo "<h3>Rooms:</h3>";
        echo "<select id='roomselect' name='sessionroom' form='setEventForm'>";
            for($i = 0; $i <= 4; $i++){ //assuming less 4 floors
                for($j = 0; $j < 10; $j++){ //assuming 10 rooms on each floor
                    $rm = "$i" ."0" . "$j";
                    echo "<option value=" . $rm. ">" . $rm . "</option>";
                }
            }
        echo "</select><br>";
    echo "</div>";
    echo "<div id='divtimeselect'>";
        //Gets the possible rooms to select from";
        echo "<h3>Time:</h3>";
        echo "<select id='timeselect' name='sessiontime' form='setEventForm'>";
        $min = 0;
        for($hr = 8; $hr <= 20; $hr++){ //assuming less 4 floors
            for($i = 0; $i < 2; $i++){
                //Time stamp used for easy conversion
                $stamp = mktime($hr, $min, 1, 2, 9, 2019); //assumes saturday as default. Will change if user specifies 'sunday'
                $time = date("h:i A", $stamp);
                //time stamp will be passed to the form
                echo "<option value=" . $stamp . ">" . $time . "</option>";
                if ($min == 0){
                    $min = 30;
                }
                else{
                    $min = 0;
                }
            }
        }
        echo "</select><br></br>";
    echo "</div>";
    echo "<form action='./setEvent.php?' id='setEventForm' method='post'>";
        echo "<input type='submit'>";
    echo "</form>";
?>