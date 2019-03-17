<!-- Allows the use of a single pdo variable throughout all scripts -->
<?php include './pdo.php'; ?>
<?php
    // Gets the information passed through using fetch API
    $company = $_GET["company"];
    // Queries the database looking for jobs specific to the company selected
    $query = "SELECT * FROM JobPostings WHERE companyName=\"" . $company . "\";";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    // Creates a table with the information. The information that is echoed is sent to fetch API.
    echo "<table>";
    echo "<tr><th>Title</th><th>City</th><th>Province</th><th>Pay Rate</th>";
    while ($job = $stmt->fetch()) {
        $jobTitle = $job["jobTitle"];
        $jobCity = $job["jobCity"];
        $jobProvince = $job["jobProvince"];
        $payRate = $job["payRate"];
        echo "<tr><td>$jobTitle</td><td>$jobCity</td><td>$jobProvince</td><td>$payRate</td></tr>";
    }
    echo "</table>";

?>