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
      <h1>Committees:</h1>

      </header>
    <div class="main">
       <!-- set up PDO -->
       <?php include 'pdo.php'; ?>
      <!--Company and job related information -->
        <div id="committeetypes" class="box-component" >
            <h2>Committe Members:</h2>
            <?php
                //Lists the name of the subcommittees
                $query = 'SELECT subcommitteeName from Subcommittee';
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                //creates a table
                echo "<table>";
                echo "<tr><th>Name</th>";
                // Loops through and displays each row.
                while ($name = $stmt->fetch()) {
                $name = $name["subcommitteeName"];
                echo "<td>$name</td>";
                }
                echo "</tr></table>";
            ?>
        </div>
        <div id="committeepage" class="box-component">
            <h2>Comittee Member Details</h2>
            <div id="roomselection" class="select-one-line-header">
            <p>Select a subcommittee you would like to view:</p>
            
            <?php
                // Select Room number from hotel rooms
                $query = 'SELECT subcommitteename FROM Subcommittee;';
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                echo "<select id=\"subcommitteename\" onChange='displayCommittee(this)'>";
                //Constructs the options looping from the query call. 
                while ($name = $stmt->fetch()){
                $subcommitteename = $name["subcommitteename"];
                echo "<option value=\"$subcommitteename\">$subcommitteename</option>";
                }
                echo "</select>";
            ?>
            </div>
            <div id="display"></div>
      </div>
    </div>
    <footer>

    </footer>
  
    <script>
    // Function used to display job specific rolls taking in the selected company as a parameter
    function displayCommittee(company){
      //Target div to display info
      let content = document.getElementById("display");
      //Uses fetch API to call script that provides database data dynamically.
      fetch("./committeeDisplay.php?committee="+company.value)
        .then((response) => { //Promises 1
            if (response.status == 200){
              return response.text().then((text) => { //2nd layer promises
                //Gets the html data from the php file and displays all info in the target div.
                content.innerHTML = "<h3>" + company.value + "</h3>" + text;
              });
              return
            }
          }
        )
        .catch(
          function(err){
            console.log('Fetch Error :-S', err);
          }
        );
    }
    function init(){
        const sub = document.getElementById('subcommitteename');
        displayCommittee(sub[0]);
    }
    window.addEventListener('load', init);

  </script>
  </body>
</html>
