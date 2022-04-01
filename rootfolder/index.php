<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
        <h1>Welcome, Superadministrator</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 center">
                <div class="container">
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        
                        // Create connection
                        $conn = new mysqli($servername, $username);
                        
                        // Check connection
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $conn->select_db("project_db");
                        $result = $conn->query("SELECT * FROM `public_events` WHERE approved = 1");
                        $events = $result->fetch_all();
                        for($i = 0; $i < count($events); $i++)
                        {
                            $result = $conn->query("SELECT * FROM `events` WHERE event_ID = '{$events[$i][0]}'");
                            $e = $result->fetch_row();
                            echo "<h3><b>Event name: " . $e[4] . "</b></h3>";
                            echo "<p>Event desc: " . $e[1] . "</p>";
                            echo "<p>Event time: " . $e[2] . "</p>";
                            echo "<p>Event loc: " . $e[3] . "</p>";
                            echo "<hr />";
                        }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 center">
                <div class="container">
                    <h2>Event name</h2>
                    <p>event description</p>
                    <p>other event stuff</p>
                </div>
                <div class="container">
                    <h2>Second event name</h2>
                    <p>event description</p>
                    <p>other event stuff</p>
                </div>
            </div>
        </div>
    </div>
    
    


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>