<!-- Allows the use of a single pdo variable throughout all scripts -->
<?php include './pdo.php'; ?>
<?php
    // Gets the information passed through using fetch API
    $name = $_GET["committee"];
    $query = "SELECT firstName, lastName, isChair FROM IsMember JOIN CommitteeMember ON IsMember.memberId = CommitteeMember.id WHERE IsMember.subcommitteeName=\"" . $name . "\";";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    // Creates a table with the information. The information that is echoed is sent to fetch API.
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Position</th>";
    while ($member = $stmt->fetch()) {
        $first = $member['firstName'];
        $last = $member['lastName'];
        $chair = $member['isChair'];
        if ($chair == 1){
            echo "<tr><td>$first</td><td>$last</td><td>Chair</td></tr>";
        } else {
            echo "<tr><td>$first</td><td>$last</td><td>Member</td></tr>";
        }
    }
    echo "</table>";

?>