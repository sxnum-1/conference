<!DOCTYPE html>
<html>
    <head>
        <link href="./conference.css" type="text/css" rel="stylesheet" />
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
            <h1>Session Events:</h1>
        </header>
        <div class="main">
            <?php include 'pdo.php'?>

            <div id="listDayEvents" class="box-component">
                <div class='select-one-line-header'>
                    <h2>Event Date:</h2>
                    <select id='dateselect' onChange='displayEvent(this.value)'>
                        <option value='saturday' selected='selected'>saturday</option>
                        <option value='sunday'>sunday</option>
                    </select>
                </div>
                <div id="displayevent">
                    <table>
                        <tr>
                            <th>Session</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Room</th>
                        <tr>
                    </table>
            </div>

            </div>
            <div id="eventManipulation" class="box-component">
                <h2>Select Session to Change:</h2>
                <div id="sessionselectdiv">
                <?php
                    //Gets the possible rooms to select from";
                    $query = "SELECT DISTINCT sessionName, TIME_FORMAT(startTime,'%h:%i%p') as startTimeReadable, startTime, room FROM SessionEvent;";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    //Displays a select menu with all unique session events
                    echo "<select id='sessionselect' name='session' onChange=provideChoices(this.value) form='setEventForm'>";
                        while ($session = $stmt->fetch()){
                            $sessionName = $session["sessionName"];
                            $startTime = $session["startTime"];
                            $startTimeReadable = $session["startTimeReadable"];
                            $room = $session["room"];
                            echo "<option value='startTime=" . $startTime . "&room=" . $room . "&name=" . $sessionName . "'>" . $sessionName . ", Room: " . $room . ", " . $startTimeReadable . "</option>";
                        }
                    echo "</select>";

                    ?>
                </div>
                <h3>Change Session:</h3>
                <div id="displayoptions" class="display-option"></div>
            </div>
        </div>
        <footer>
        
        </footer>
    </body>
  <script>
        function init(){
            let displayDay = document.getElementById("dateselect");
            let changeSession = document.getElementById("sessionselect");
            displayEvent(displayDay.value);
            provideChoices(changeSession.value);
        }
        //Function is used to display events associated with a specific day
        function displayEvent(day){
        //gets the div to display events for specific date.
            let content  = document.getElementById("displayevent");
            fetch("./displayEvent.php?day=" + day)
            .then(response => {
                if (response.status == 200){
                    return response.text()
                }
            }).then(text => {
                    content.innerHTML = text;
            }).catch((err) => {
                console.log('Fetch Error :-S', err);
            });
        }
        //function is used to fetch select items
        function provideChoices(session){
            //target div to display select items in
            let display = document.getElementById("displayoptions");
            fetch("./getSelects.php?sessionName=" + session)//sends unique session information
            .then((response) => {
                if (response.status == 200){
                    return response.text().then((text) => {
                        display.innerHTML = text;//the select items
                    });
                }
            })
            .catch((err) => {
                console.log('Fetch Error :-S', err);
            });
        }
        window.addEventListener("load",init);
    </script>
</html>


