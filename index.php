<!DOCTYPE html>
<html>
    <head>
        <link href="conference.css" type="text/css" rel="stylesheet" />
            <script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>
    </head>
    <body>
        <nav>
            <ul class="navbar">
                <li><a class="active" href="index.php">Events</a></li>
                <li><a href="attendees.php">Attendees</a></li>
                <li><a href="sponsors.php">Sponsors</a></li>
                <li><a href="jobs.php">Jobs</a></li>
                <li><a href="hotel.php">Hotel</a></li>
                <li><a href="committees.php">Committees</a></li>
                <li><a href="logistics.php">Logistics</a></li>
            </ul>
        </nav>
        <header>
            <h1>Session Events</h1>
        </header>
        <div class="main">
            <?php include 'pdo.php'?>
            <div id="listDayEvents">
                <?php
                //Gets the possible days to select from
                echo "<h2>Event Date:</h2>";
                echo "<select id='dateselect' onChange=displayEvent(this.value)>";
                    echo "<option value=''></option>";
                    echo "<option value='saturday'>saturday</option>";
                    echo "<option value='sunday'>sunday</option>";
                echo "</select><br>";
                ?>
                <div id="displayevent">
                </div>

            </div>
            <div id="eventManipulation">
                <h2>Change Session:</h2>
                <div id="sessionselectdiv">
                <?php
                        //Gets the possible rooms to select from";
                    $query = "SELECT DISTINCT sessionName FROM SessionEvent;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    echo "<select id='sessionselect' name='sessionname' onChange=provideChoices(this.value) form='setEventForm'>";
                        echo "<option value=''></option>";
                        while ($session = $stmt->fetch()){
                            $sessionName = $session["sessionName"];
                            echo "<option value=" . $sessionName . ">" . $sessionName . "</option>";
                        }
                    echo "</select><br>";

                    ?>
                </div>
                
                <div id="displayoptions">
                    <p>output</p>
                </div>
            </div>
        </div>
        <footer>
        
        </footer>
    </body>
  <script>
        //Function is used to display events associated with a specific day
        function displayEvent(day){
        //gets the div to display events for specific date.
            let content  = document.getElementById("displayevent");
            fetch("./displayEvent.php?day=" + day)
            .then((response) => {
                if (response.status == 200){
                    return response.text().then((text) => {
                        content.innerHTML = text;
                    });
                }
            })
            .catch((err) => {
                console.log('Fetch Error :-S', err);
            });
        }
        //function is used both by room select and time select. 
        //Either one selected provides a list of submit buttons
        function provideChoices(session){
            //gets radio and button, putting in display div
            let display = document.getElementById("displayoptions");
            fetch("./getSelects.php?sessionName=" + session)//sends the time 
            .then((response) => {
                if (response.status == 200){
                    return response.text().then((text) => {
                        display.innerHTML = text;
                    });
                }
            })
            .catch((err) => {
                console.log('Fetch Error :-S', err);
            });
        }
    </script>
</html>


