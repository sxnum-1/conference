<!DOCTYPE html>
<html>
  <head>
    <link href="conference.css" type="text/css" rel="stylesheet" />
  </head>
  <body>
    <nav>
        <ul class="navbar">
          <li><a href="index.php">Events</a></li>
          <li><a href="attendees.php">Attendees</a></li>
          <li><a href="sponsors.php">Sponsors</a></li>
          <li><a href="jobs.php">Jobs</a></li>
          <li><a class="active" href="hotel.php">Hotel</a></li>
          <li><a href="committees.php">Committees</a></li>
          <li><a href="logistics.php">Logistics</a></li>
        </ul>
      </nav>
    <header>
      <!-- placeholder -->
      <h1>Hotel</h1>
    </header>
    <div class="main">
       <!-- set up PDO -->
       <?php include 'pdo.php'; ?>
      <!--Company and job related information -->
      <div id="studentrooms" class="box-component">
        <h2>Students in a room</h2>
            <div id="selectroom" class="select-one-line-header">
                <p>Select a Room Number you would like to check:</p>
                
                <?php
                // Select Room number from hotel rooms
                $query = 'SELECT roomNumber FROM HotelRoom;';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                echo "<select id=\"roomNumber\" onChange=\"displayStudentsInRoom(this.value)\">";
                //Constructs the options looping from the query call. 
                while ($room = $stmt->fetch()){
                    $roomNumber = $room["roomNumber"];
                    echo "<option value=$roomNumber>$roomNumber</option>";
                    // echo "<option value=" . $room['roomNumber'] . ">" . $room["roomNumber"] . "</option>";
                }
                echo "</select><br><br>";
                ?>
            </div>
        <div id="display"></div>
      </div>
    </div>
    <footer>
      
    </footer>
    <!-- placeholder -->

  <script>
    // Function used to display job specific rolls taking in the selected company as a parameter
    function displayStudentsInRoom(room){
      //gets the div to display events for specific date.
      let content  = document.getElementById("display");
      fetch("./getHotelStudents.php?room=" + room)
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
    window.addEventListener("load", () => {
      const select = document.getElementById('roomNumber');
      displayStudentsInRoom(select.value);
    });
  </script>
</body>

</html>
