<?php

include "config.php";

// Function defnition 
function alert($message)
{

    // Display the alert box  
    echo "<script>alert('$message');</script>";
}

$vapeSuggestions = array(
    "There’s a strong link between smoking and cardiovascular disease, and between smoking and cancer",
    "Quitting smoking is one of the best things you can do for your health — smoking harms nearly every organ in your body, including your heart.",
    "Talk to your doctor about what smoking cessation program or tools would be best for you."
);

function printVapeSuggestions()
{
    $randomIndex = rand(0, 2); //min=0 and max=2 for now can change based on array items

    global $vapeSuggestions;

    print($vapeSuggestions[$randomIndex]);
}



//store first and last name
$email = $_SESSION['user_email'];
$sql = "SELECT first_name,last_name,user_id FROM user WHERE user_email='$email'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['user_id'] = $row['user_id'];
    }
}

//Printing journal entries
$user_id = $_SESSION['user_id'];
$sql = "SELECT j_id,user_id,entry FROM journal WHERE user_id='$user_id'";
$result = $con->query($sql);


//BUTTONS BEING CLICKED

if (isset($_POST['addNewEntry'])) {

    $newEntry = $_POST['newEntry'];

    $sql = "INSERT INTO journal(user_id,entry) VALUES('$user_id','$newEntry')";

    //check if a connection is made
    if ($con->query($sql) == TRUE) {
        echo "A new entry was successfully added";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}


if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}


// $con->close();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- <!-- <link rel="stylesheet" type="text/css" href="css/util.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div></div>

    <div class="container-fluid">


        <!---Main header -->
        <nav class="navbar navbar-light bg-light shadow-lg">
            <div class="container-fluid ">
                <a class="navbar-brand" href="#">
                    <img src="assets/vapefree_logo.png" alt="" width="90" height="90">
                </a>
                <h3 class="text-center text-primary">VapeFree</h3>
            </div>
        </nav>

        <br>
        <br>


        <div class="d-flex justify-content-evenly shadow-lg">
            <h1>Welcome Home</h1>
        </div>


        <br>
        <br>

        <!-- User Info -->
        <div class="container text-center display-3">
            <h4 class="display-5">User Info</h4>
            <h6 class="display-6">First Name: <?php print($_SESSION['first_name']) ?></h6>
            <h6 class="display-6">Last Name: <?php print($_SESSION['last_name']) ?></h6>
            <h6 class="display-6">User ID: <?php print($_SESSION['user_id']) ?></h6>
            <h6 class="display-6">Email: <?php print($_SESSION['user_email']) ?></h6>
            <div class="container text-center">
                <div class="row">
                    <div class="col text-center">
                        <form action="home.php" method="post">
                            <button name="logout" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <br>
        <br>

        <!-- healthy suggestions -->
        <div class="container text-center ">
            <h1 class="display-3">Healthy Suggestions</h1>
            <?php printVapeSuggestions(); ?>
        </div>

        <br>
        <br>

        <!-- Personal Journal -->
        <div class="container text-center ">
            <h1 class="display-3">Personal Journal</h1>

        </div>

        <br>
        <br>

        <?php
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT j_id,user_id,entry FROM journal WHERE user_id='$user_id' ORDER BY j_id DESC";
        $result = $con->query($sql);
        ?>
        <table class="table table-striped">
            <tr>
                <th>Entry ID</th>
                <th>User ID</th>
                <th>Journal Entry</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    print("<tr>");
                    print("<td>" . $row['j_id'] . "</td>");
                    print("<td>" . $row['user_id'] . "</td>");
                    print("<td>" . $row['entry'] . "</td>");
                }
            }

            ?>

            <?php
            print("<tr>");

            print("</table>");

            ?>
            <br>
            <br>
            <!--Adding a new journal entry -->
            <div class="form-group container text-center">
                <form action="home.php" method="post">
                    <label>Write a new entry</label>
                    <textarea class="form-control" name="newEntry" rows="3"></textarea>
                    <button name="addNewEntry" class="btn btn-primary">Add</button>
                </form>
            </div>


            <br>
            <br>

            <nav class="nav navbar-light bg-light d-flex justify-content-evenly shadow-lg nav-pills">
                <a class="nav-link active" aria-current="page" href="home.php"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg><br>Home</a>
                <a class="nav-link" href="track.php"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5z" />
                    </svg><br>Track</a>
                <a class="nav-link" href="feed.php"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                    </svg><br>Feed</a>

            </nav>

            <br>



    </div>
    <br>




</body>

</html>