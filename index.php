<!DOCTYPE html>
<html>
  <head>
    <link href="conference.css" type="text/css" rel="stylesheet" />
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
        <h2>list all events for a particular day</h2>
        <?php
          //Gets the possible days to select from
          $query = 'SELECT DISTINCT DAYNAME(startTime) as Day FROM SessionEvent;';
          $stmt = $pdo->prepare($query);
          $stmt->execute();
          echo "<h3>Event Date:</h3>";
          echo "<select id='dateselect' onChange=displayEvent(this.value)>";
          echo "<option value=''></option>";
          while($eventDate = $stmt->fetch()){
            echo "<option value=" . $eventDate["Day"] . ">" . $eventDate["Day"] . "</option>";
          }
          echo "</select><br>";

        ?>
        <div id="displayevent">
        </div>

      </div>
      <div id="eventManipulation">
        <h2>switch a session's day/time and/or location</h2>
      <!-- placeholder -->
        <?php


        ?>
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
            content.innerHTML =  text;
          });
        }
      })
      .catch((err) => {
        console.log('Fetch Error :-S', err);
      });
    }
  
  </script>
</html>


