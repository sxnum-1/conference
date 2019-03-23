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
          <li><a href="index.php">Events</a></li>
          <li><a href="attendees.php">Attendees</a></li>
          <li><a class="active" href="sponsors.php">Sponsors</a></li>
          <li><a href="jobs.php">Jobs</a></li>
          <li><a href="hotel.php">Hotel</a></li>
          <li><a href="committees.php">Committees</a></li>
          <li><a href="logistics.php">Logistics</a></li>
        </ul>
      </nav>
    <header>
      <!-- placeholder -->
      <h1>stuff for sponsors/companies</h1>
    </header>
    <div class="main">
      <h2>list the sponsors and their sponsorship levels</h2>
      <h2>add a new sponsoring company</h2>
      <h2>delete a sponsoring company and all its attendees</h2>
    
      <?php include 'pdo.php'; ?>
      
      <!-- persist a new attendee -->
      <div id="newsponsorpersistence">
            <?php
            if (!empty($_POST)) {
              $delete = isset($_POST['var']) ? $_POST['var'] : true;;
              if ($delete == true){
                echo "2";
              } else {
                echo "3";
              }
                // empty values are turned into empty strings, not 'NULL'
                /*
                if ($attendeeType == "Student") {
                    $roomnumber = $_POST["roomnumber"];
                    $query = "INSERT INTO $attendeeType(firstName, lastName, email, roomNumber) VALUES(\"$firstname\", \"$lastname\", \"$email\", \"$roomnumber\")";
                } else if ($attendeeType == "Sponsor") {
                    $sponsoringcompany = $_POST["sponsoringcompany"];
                    $query = "INSERT INTO $attendeeType(firstName, lastName, email, emailsSent, companyName) VALUES(\"$firstname\", \"$lastname\", \"$email\", 0, \"$sponsoringcompany\")";
                } else { // Professional
                    $query = "INSERT INTO $attendeeType(firstName, lastName, email) VALUES(\"$firstname\", \"$lastname\", \"$email\")";
                }
                $stmt = $pdo->prepare($query);
                $hasPersisted = $stmt->execute();

                if ($hasPersisted)
                    echo "New attendee successfully added";
                else
                    echo "Error adding the new attendee";
                */
            }
            ?>
        </div>


      <div id='newsponsor'>
            <h3>Sponsors</h3>
            <?php
            $query = "SELECT companyName, companyLocation, ranking FROM SponsorCompany";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            echo "<table>";
            echo "<tr><th>Name</th><th>Location</th><th>Ranking</th></tr>";
            while ($sponsor = $stmt->fetch()) {
                $companyName = $sponsor["companyName"];
                $companyLocation = $sponsor["companyLocation"];
                $Ranking = $sponsor["ranking"];
                echo "<tr><td>$companyName</td><td>$companyLocation</td><td>$Ranking</td></tr>";
            }
            echo "</table>";
            ?>
            <h2>Add a new Sponsor Company</h2>

            <form name="newsponsorform" action="" method="post">
               <p>Company Name:</p>
                <input type="text" name="companyName"><br>
                <p>Company Location:</p>
                <input type="text" name="companyLocation"><br>
                <p>Sponsor Ranking:</p>
                <input type="radio" name="sponsor" value="Platinum">Platinum<br>
                <input type="radio" name="sponsor" value="Gold">Gold<br>
                <input type="radio" name="sponsor" value="Silver">Silver<br>
                <input type="radio" name="sponsor" value="Bronze">Bronze<br>
                <input type="submit">
                <div id="attendeeselection"></div>
            </form>
            <h2>Delete a Sponsor Company</h2> 
            <form name = "deletesponsorform" action = "" method = "post">
              <p> Company Name to Delete</p>
              <input type = 'text' name = "deleteName"><br>
              <input type="submit">
              <input type = 'hidden' name = "var" value = false>
            </form>
    <!-- placeholder -->
    </div>
    <footer>
      
    </footer>
  </body>
</html>
