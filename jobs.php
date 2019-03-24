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
                <li><a class="active" href="jobs.php">Jobs</a></li>
                <li><a href="hotel.php">Hotel</a></li>
                <li><a href="committees.php">Committees</a></li>
                <li><a href="logistics.php">Logistics</a></li>
            </ul>
        </nav>
        <header>
            <!-- placeholder -->
            <h1>Jobs:</h1>
        </header>
        <div class="main">
            <!-- set up PDO -->
            <?php include 'pdo.php'; ?>
            <!--Company and job related information -->
            <div class="box-component">
                <h2>Lists jobs at a Company:</h2>
                <div class='select-one-line-header'>
                    <p>Company Name:</p>
                    
                    <?php
                        // Gets the company names from SponsorCompany table
                        $query = 'SELECT companyName FROM SponsorCompany;';
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        //Prepares dropdown menu with company names. 
                        //Calls function displayJobs when menu changes to a new selection and passes selection as parameter
                        echo "<select id='companyname' onChange='displayJobs(this.value)'>";
                        //Constructs the options looping from the query call. 
                        while ($company = $stmt->fetch()){
                            $companyName = $company["companyName"];
                            echo "<option value=\"$companyName\">$companyName</option>";
                        }
                        echo "</select><br>";
                    ?>
                </div>
                <div id="companyjobdisplay"></div>
            </div>
            <div class="box-component">
                <h2>list all jobs</h2>
                <?php
                    //Lists the job title and locations
                    $query = 'SELECT jobTitle, CONCAT(jobCity,\', \',jobProvince) as jobLocation FROM JobPostings;';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    //creates a table
                    echo "<table>";
                        echo "<tr><th>Title</th><th>Location</th></tr>";
                        // Loops through and displays each row.
                        while ($job = $stmt->fetch()) {
                            $jobTitle = $job["jobTitle"];
                            $jobLocation = $job["jobLocation"];
                            echo "<tr><td>$jobTitle</td><td>$jobLocation</td></tr>";
                        }
                    echo "</table>";
                ?>
            </div>
        </div>
        <footer>
            
        </footer>
    <!-- placeholder -->
    </body>

    <script>
    // Function used to display job specific rolls taking in the selected company as a parameter
        function displayJobs(company){
            //Target div to display info
            let content = document.getElementById("companyjobdisplay");
            //Uses fetch API to call script that provides database data dynamically.
            fetch("./jobsCompanyDisplay.php?company=" + company)
            .then(response => { //Promises 1
                if (response.status == 200){
                    return response.text()
                }
                else{
                    content.innerHTML= "<p> Unable to retrieve job information </p>";
                }
            }).then(text => { //2nd layer promises
                //Gets the html data from the php file and displays all info in the target div.
                content.innerHTML = text;
            }).catch((err) => {
                console.log('Fetch Error :-S', err);
                
            });
        }
        window.addEventListener("load", () => {
            const select = document.getElementById('companyname');
            displayJobs(select.value);
        });
    </script>


</html>
