<!DOCTYPE html>
<html>

<head>
    <link href="conference.css" type="text/css" rel="stylesheet" />
    <!-- prevents form resubmission when reloading -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body onload="newattendeeform.reset()">
    <nav>
        <ul class="navbar">
            <li><a href="index.php">Events</a></li>
            <li><a class="active" href="attendees.php">Attendees</a></li>
            <li><a href="sponsors.php">Sponsors</a></li>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="hotel.php">Hotel</a></li>
            <li><a href="committees.php">Committees</a></li>
            <li><a href="logistics.php">Logistics</a></li>
        </ul>
    </nav>

    <!-- placeholder -->
    <header>
        <h1>Stuff for attendees</h1>
    </header>
    <div class="main">
        <!-- set up PDO -->
        <?php include 'pdo.php'; ?>

        <!-- persist a new attendee -->
        <div id="newattendeepersistence">
            <?php
            if (!empty($_POST)) {
              $attendeeType = ucwords($_POST["attendeetype"]);
              $firstname = $_POST["firstname"];
              $lastname = $_POST["lastname"];
              $email = $_POST["email"];

              // empty values are turned into empty strings, not 'NULL'
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
            }
            ?>
        </div>

        <div id='newattendee'>

            <h2>Add a new attendee</h2>

            <form name="newattendeeform" action="" method="post">
                <p>Attendee type:</p>
                <input type="radio" name="attendeetype" value="student" onclick="selected(this)">Student<br>
                <input type="radio" name="attendeetype" value="professional" onclick="selected(this)">Professional<br>
                <input type="radio" name="attendeetype" value="sponsor" onclick="selected(this)">Sponsor<br>
                <div id="attendeeselection"></div>
            </form>
        </div>

        <div id="listattendees">

            <h2>Attendees</h2>
            <h3>Students</h3>
            <?php
            $query = "SELECT CONCAT(firstName, \" \", lastName) AS fullName, email, roomNumber FROM Student";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Hotel Room Number</th></tr>";
            while ($student = $stmt->fetch()) {
              $fullName = $student["fullName"];
              $email = $student["email"];
              $roomNumber = $student["roomNumber"];
              echo "<tr><td>$fullName</td><td>$email</td><td>$roomNumber</td></tr>";
            }
            echo "</table>";
            ?>
            <h3>Professionals</h3>
            <?php
            $query = "SELECT CONCAT(firstName, \" \", lastName) AS fullName, email FROM Professional";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th></tr>";
            while ($professional = $stmt->fetch()) {
              $fullName = $professional["fullName"];
              $email = $professional["email"];
              echo "<tr><td>$fullName</td><td>$email</td></tr>";
            }
            echo "</table>";
            ?>
            <h3>Sponsors</h3>
            <?php
            $query = "SELECT CONCAT(firstName, \" \", lastName) AS fullName, email, emailsSent, companyName FROM Sponsor";
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Emails Sent</th><th>Representative Sponsor</th></tr>";
            while ($sponsor = $stmt->fetch()) {
              $fullName = $sponsor["fullName"];
              $email = $sponsor["email"];
              $emailsSent = $sponsor["emailsSent"];
              $companyName = $sponsor["companyName"];
              echo "<tr><td>$fullName</td><td>$email</td><td>$emailsSent</td><td>$companyName</td></tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <footer>

    </footer>

    <script>
        function selected(self) {
            let content = document.getElementById('attendeeselection');
            const commonHTML = `
                <p>First name:</p>
                <input type="text" name="firstname"><br>
                <p>Last name:</p>
                <input type="text" name="lastname"><br>
                <p>Email:</p>
                <input type="email" name="email"><br>
            `;
            const studentPhp = `
                <?php
                // $query = "SELECT roomNumber FROM HotelRoom";
                $query = "SELECT HotelRoom.roomNumber, count(id) FROM HotelRoom LEFT JOIN Student ON HotelRoom.roomNumber = Student.roomNumber GROUP BY HotelRoom.roomNumber HAVING count(id) < 4";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                echo "<p>HotelRoom:</p><select name=\"roomnumber\">";

                while ($room = $stmt->fetch()) {
                  echo "<option>" . $room["roomNumber"] . "</option>";
                }

                echo "</select><br>";
                ?>
            `;
            const sponsorHTML = `
                <p>Sponsoring company:</p>
                <input type="text" name="sponsoringcompany"><br>
            `;
            const submitHTML = '<br><input type="submit">';
            if (self.value === 'student') {
                content.innerHTML = commonHTML + studentPhp + submitHTML;
            } else if (self.value === 'professional') {
                content.innerHTML = commonHTML + submitHTML;
            } else if (self.value === 'sponsor') {
                content.innerHTML = commonHTML + sponsorHTML + submitHTML;
            }
        }
    </script>
</body>

</html> 