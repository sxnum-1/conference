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
      
      
      <div id='newsponsor'>

            <h2>Add a new Sponsor Company</h2>

            <form name="newsponsorform" action="" method="post">
               <p>Company Name:</p>
                <input type="text" name="companyName"><br>
                <p>Company Location:</p>
                <input type="text" name="companyLocation"><br>
                <p>Sponsor Ranking:</p>
                <input type="radio" name="sponsor" value="Platinum" onclick="selected(this)">Platinum<br>
                <input type="radio" name="sponsor" value="Gold" onclick="selected(this)">Gold<br>
                <input type="radio" name="sponsor" value="Silver" onclick="selected(this)">Silver<br>
                <input type="radio" name="sponsor" value="Bronze" onclick="selected(this)">Bronze<br>
                <div id="attendeeselection"></div>
            </form>
            <h2>Delete a Sponsor Company</h2> 
            <form name = "deletesponsorform" action = "" method = "post">
              <p> Company Name to Delete</p>
              <>
              <>
            </form>
    <!-- placeholder -->
    </div>
    <footer>
      
    </footer>
  </body>
</html>
