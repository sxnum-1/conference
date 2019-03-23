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
      <h1>Sponsors</h1>
    </header>
    <div class="main">
    
      <?php include 'pdo.php'; ?>
      
      <!-- persist a new attendee -->
      <div id="newsponsorpersistence">
            <?php
            if (!empty($_POST)) {
              $delete = isset($_POST['var']) ? $_POST['var'] : false;;
              
              if ($delete == 0){
                $sponsor = ucwords($_POST["sponsor"]);
                $companyName = $_POST["companyName"];
                $companyLocation = $_POST["companyLocation"];
                $query = "insert into SponsorCompany values (\"$companyName\",\"$companyLocation\", \"$sponsor\");";
                $stmt = $pdo->prepare($query);
                $hasPersisted = $stmt->execute();

                if ($hasPersisted)
                    echo "New sponsoring company successfully added";
                else
                    echo "Error adding the new company";
              } elseif ($delete == 1){
                $sponsor = $_POST['deleteName'];
                $query = "DELETE FROM SponsorCompany WHERE companyName='$sponsor'";
                $stmt = $pdo->prepare($query);
                $hasPersisted = $stmt->execute();
                if ($hasPersisted)
                    echo "Company has been deleted";
                else
                    echo "Error deleting company";
              }
            }
            ?>
        </div>


      <div id='newsponsor'>
            <h2>List of sponsors</h2>
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
                <input type = 'hidden' name = "var" value = 0><br>
                <input type="submit">
                <div id="attendeeselection"></div>
            </form>
            <h2>Delete a Sponsor Company</h2> 

            <form name = "deletesponsorform" action = "" method = "post">
              <p> Company Name to Delete</p>
              <input type = 'text' name = "deleteName"><br>
              <input type = 'hidden' name = "var" value = 1><br>
              <input type= "submit">
            </form>
    <!-- placeholder -->
    </div>
    <footer>
      
    </footer>
  </body>
</html>
