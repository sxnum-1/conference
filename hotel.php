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
      <h1>Stuff for the hotel</h1>
    </header>
    <div class="main">
       <!-- set up PDO -->
       <?php include 'pdo.php'; ?>
      <!--Company and job related information -->
      <div id="studentrooms">
        <h2>list all students in a room</h2>
        <div id="roomselection">
          <p>Select a Room Number you would like to check:</p>
          
          <?php
            // Select Room number from hotel rooms
            $query = 'SELECT roomNumber FROM hotelroom;';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            echo "<select name=\"roomNumber\" onChange=\"displayRoom(this)\">";
            echo "<option value=''></option>";
            //Constructs the options looping from the query call. 
            while ($room = $stmt->fetch()){
              echo "<option value=" . $room['roomNumber'] . ">" . $room["roomNumber"] . "</option>";
            }
            echo "</select><br>";
          ?>
        </div>
        <div id="display"></div>
      </div>
      <?php
        //Lists the students name and id
        $query = 'SELECT CONCAT(firstName,\', \',lastName) as FName FROM student;';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        //creates a table
        echo "<table>";
        echo "<tr><th>Name</th></tr>";
        // Loops through and displays each row.
        while ($name = $stmt->fetch()) {
          $name = $name["FName"];
          echo "<tr><td>$name</td></tr>";
        }
        echo "</table>";
      ?>
    </div>
    <footer>
      
    </footer>
    <!-- placeholder -->

  <script>
    // Function used to display job specific rolls taking in the selected company as a parameter
    function displayRoom(room){
      //Target div to display info
      let content = document.getElementById("display");
      let a = room.value;
      const query = `
        <?php
          // $query = "SELECT roomNumber FROM HotelRoom";
          $room = '';
          $room = isset($_POST['roomNumber']) ? $_POST['roomNumber'] : '';
          $query = "SELECT student.firstName, student.lastName, roomNumber FROM student WHERE student.roomNumber = '$room' GROUP BY student.roomNumber";
          $stmt = $pdo->prepare($query);
          $stmt->execute();

          while ($room = $stmt->fetch()) {
              echo "<option>$room</option>";
          }

          echo "</select><br>";
          ?>
        `;
      content.innerHTML = "<h3>" + "Student Name" + "</h3>" + query;
    }
  </script>
</body>

</html>
