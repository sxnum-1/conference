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
        <li><a href="hotel.php">Hotel</a></li>
        <li><a class="active" href="committees.php">Committees</a></li>
        <li><a href="logistics.php">Logistics</a></li>
      </ul>
    </nav>
    <header>
      <h1>stuff for committees</h1>

      </header>
    <div class="main">
       <!-- set up PDO -->
       <?php include 'pdo.php'; ?>
      <!--Company and job related information -->
      <div id="committeepage">
        <h2>list members of subcommittee (dropdown)</h2>
        <div id="roomselection">
          <p>Select a subcommittee you would like to view:</p>
          
          <?php
            // Select Room number from hotel rooms
            $query = 'SELECT subcommitteename FROM Subcommittee;';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            echo "<select name=\"subcommitteename\" onChange=\"\">";
            echo "<option value=''></option>";
            //Constructs the options looping from the query call. 
            while ($name = $stmt->fetch()){
              echo "<option value=" . $name['subcommitteename'] . ">" . $name["subcommitteename"] . "</option>";
            }
            echo "</select><br>";
          ?>
        </div>
        <div id="display"></div>
      </div>
      <?php
        //Lists the students name and id
        $query = 'SELECT CONCAT(firstName,\', \',lastName) as FName FROM isMember JOIN CommitteeMember ON CommitteeMember.id = isMember.memberId;';
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
  </body>
</html>
