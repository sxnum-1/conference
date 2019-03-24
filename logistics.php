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
            <li><a href="committees.php">Committees</a></li>
            <li><a class="active" href="logistics.php">Logistics</a></li>
        </ul>
    </nav>
    <header>
        <h1>Logistics</h1>
    </header>
    <div class="main">

        <!-- set up pdo -->
        <?php include "pdo.php" ?>

        <div id="registrationintake">
            <?php
            $studentQuery = "SELECT count(id) AS studentCount FROM Student";
            $studentStmt = $pdo->prepare($studentQuery);
            $studentStmt->execute();

            $studentAmount = (int)$studentStmt->fetch()["studentCount"] * 50;

            $profQuery = "SELECT count(id) AS profCount FROM Professional";
            $profStmt = $pdo->prepare($profQuery);
            $profStmt->execute();

            $profAmount = (int)$profStmt->fetch()["profCount"] * 100;

            $attendeeTotal = $studentAmount + $profAmount;

            echo "<div id=\"registrationintake\"class='box-component'>";
            echo "<h3>Registration intake</h3>";
            echo "<table>";
            echo "<tr><td>Student registration intake</td><td>\$$studentAmount</td></tr>";
            echo "<tr><td>Professional registration intake</td><td>\$$profAmount</td></tr>";
            echo "<tr><th>Total registration intake</th><th>\$$attendeeTotal</th></tr>";
            echo "</table>";
            echo "</div>";

            $sponsorshipLevels = array("Bronze", "Silver", "Gold", "Platinum");
            $sponsorshipTotal = 0;

            echo "<div id=\"sponsorshipregistrationintake\" class='box-component'>";
            echo "<h3>Sponsorship intake</h3>";
            echo "<table>";
            foreach ($sponsorshipLevels as $level) {
                $sponsorshipTotal += createRowEntry($level, $pdo);
            }
            echo "<tr><th>Total sponsorship intake</th><th>\$$sponsorshipTotal</th></tr>";
            echo "</table>";
            
            $total = $attendeeTotal + $sponsorshipTotal;
            echo "<h2>Total intake: \$$total</h2>";
            echo "</div>";

            function createRowEntry($grade, $pdo)
            {
              switch ($grade) {
                case "Bronze":
                  $multiplier = 1000;
                  break;
                case "Silver":
                  $multiplier = 3000;
                  break;
                case "Gold":
                  $multiplier = 5000;
                  break;
                default: // Platinum
                  $multiplier = 10000;
              }

              $query = "SELECT count(companyName) AS cnt FROM SponsorCompany GROUP BY ranking HAVING ranking=\"$grade\"";
              $stmt = $pdo->prepare($query);
              $stmt->execute();

              $amount = (int)$stmt->fetch()["cnt"] * $multiplier;

              echo "<tr><td>$grade sponsor intake</td><td>\$$amount</td></tr>";
              return $amount;
            }
            ?>
        </div>
    </div>
    <footer>

    </footer>

</body>

</html> 