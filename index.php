<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3ff8bb9fb.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Farha Association</title>
</head>

<body>

    <body>
        <nav id="nav_home" class="navbar  sticky-top">
            <div class="container">
                <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Farha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#today">Next event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#listEvents">Upcoming events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#Contact">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profail.php">My account</a>
                            </li>
                        </ul>
                        <?php
                        // check if the user is connected; if the session is not empty, then the user is connected
                        if (isset($_SESSION['user_id'])) {
                            echo "<form id='signOutForm' action='profail.php' method='POST'>
                                     <i class='fa-solid fa-arrow-right-from-bracket d-flex' id='sign_out' onclick='submitForm()'>
                                     <input type='hidden' name='sign_out'>
                                      </i>
                               </form>";
                        }

                        if (isset($_GET['buy'])) {
                            $versionId = $_GET['event_id'];
                            $_SESSION['versionId'] = $versionId;
                            header("location: event_details.php");
                            exit();
                        }
                        ?>
                        <form class="d-flex mt-3" method="GET">
                            <input class="form-control me-2" name="search" type="search" placeholder="Search by titel" aria-label="Search" required>
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </form><br><br>
                        <span>search by date</span>
                        <form action="" class="d-flex mt-1 " method="GET">
                            <input type="text" onfocus="(this.type='date')" class="form-control m-1" name="from_date" required placeholder="From">
                            <input type="text" onfocus="(this.type='date')" class="form-control m-1" name="to_date" required placeholder="To">
                            <button type="submit" class="btn btn-outline-dark m-1" name="date_search">Ok</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <section id="home">
            <div class="container home">
                <div class="row">
                    <div class="col-md-7 col-sm-12 row">
                        <div class="block col-4  ">
                            <div class="img1 ms-auto" style="background-image: url(imgs/home9.jpg);"> </div>
                            <div class="img2 mt-3 ms-auto" style="background-image: url(imgs/home16.jpg);"> </div>
                            <div class="img3 mt-4 ms-4" style="background-image: url(imgs/home3.jpg);"> </div>
                        </div>
                        <div class="block col-3 ">
                            <div class="img4 mt-3 " style="background-image: url(imgs/home14.jpg);"> </div>
                            <div class="img5 mt-4" style="background-image: url(imgs/home19.jpg);"> </div>
                            <div class="img6 mt-4" style="background-image: url(imgs/home13.jpg);"> </div>
                        </div>
                        <div class="block d-flex align-items-start flex-column col-4 ">
                            <div class="img7 mb-3" style="background-image: url(imgs/eventMusic3.jpg);"> </div>
                            <div class="img4 mb-3 mt-2  ms-2 " style="background-image: url(imgs/home4.jpg);"> </div>
                            <div class="img8 mt-5 ms-1" style="background-image: url(imgs/home15.jpg);"> </div>
                        </div>
                    </div>

                    <div class="col-md-5  col-sm-12 mt-3">
                        <h1>Farha Association</h1><br>
                        <p>Farha is your go-to source for unforgettable parties, enchanting evenings,
                            and captivating theatrical performances. We specialize in curating events
                            that elevate entertainment to new heights. Join us for a celebration of joy,
                            culture, and unforgettable moments.</p><br>
                        <div class="d-flex">
                            <?php
                            // check if the user connected , if the session not empty then he is connected
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];

                                $row = User_info($user_id, $DB);

                                echo "<h4> Welcome {$row['prenom']} {$row['nom']} </h4>";
                            } else {

                                echo " <form action='sign_in.php' method='POST'>
                            <button class='btn btn-dark m-1' name='sign_in' type='submit' id='signInBtn'>Sign in</button>
                        </form>";
                                echo " <form action='sign_up.php' method='POST'>
                            <button class='btn m-1' id='signUpBtn' type='submit' name='sign_up'>Sign up</button>
                        </form>";
                            }
                            ?>
                        </div>
                        <br>
                        <hr>
                        <span>Have any questions?</span><br>
                        <span>Contact us </span><br><br>
                        <strong>+132 463 873 24</strong>
                    </div>
                </div>
            </div>
        </section>
        <section class="list">
            <section class="d-flex justify-content-center ">
                <div id="today" class="container-lg row  p-4 d-flex justify-content-around">
                    <div class="col-md-8 col-sm-12 ">
                        <h2>Next event</h2>
                        <?php

                        // affiche the next event 
                        $eventToday = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement)  FROM evenement 
                                        INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                                        where  DATE(dateEvenement) >= CURDATE()
                                        order by  DATE(dateEvenement) asc 
                                        limit 1";

                        $Statement_t = $DB->prepare($eventToday);
                        $Statement_t->execute();
                        $row_t = $Statement_t->fetch(PDO::FETCH_ASSOC);

                        $versionId = $row_t['numVersion'];
                        $capacity_room = capacity_room($versionId, $DB);
                        $count_ticket = count_ticket($versionId, $DB);

                        echo "<span class='categorie border-bottom border-2 border-black' > {$row_t['categorie']} </span> <br><br>";
                        echo "<h3> {$row_t['titre']} </h3>";
                        echo "<p class='w-75' > {$row_t['description']} </p>";
                        echo "<span> {$row_t['DATE(dateEvenement)']} </span><br>";
                        echo "<span> {$row_t['TIME(dateEvenement)']} </span> <br><br>";
                        echo "<form method='GET' action='index.php'>";
                        echo "<input hidden value='{$row_t['numVersion']}' name='event_id' >";
                        if ($count_ticket < $capacity_room) {
                            echo "<button class='mt-3 btn btn-dark' type='submit' name='buy'> Buy </button>";
                        } else {
                            echo "<button class='mt-3 SOLD_OUT' type='submit' name='buy'><s> Sold out </s></button>";
                        }
                        echo "</form>";
                        $path = "imgs";
                        ?>
                    </div>
                    <div id='todayImg' class="col-md-3 col-sm-12" style=" background-image: url('<?php echo $path . '/' . $row_t['image'] . '.jpg'; ?>');">

                    </div>
                </div>
            </section>
            <section id="listEvents">
                <div class="text-center">
                    <h2 style="color: white;"> What's Coming Up </h2>
                    <span style="color: white; opacity:0.8;">Discover the exciting events on the horizon. Join us for memorable moments</span>
                    <div class="catigorie m-3">
                        <?php
                        $buttonColor1 = 'background-color: black;';
                        $buttonColor2 = 'background-color: black;';
                        $buttonColor3 = 'background-color: black;';
                        $buttonColor4 = 'background-color: black;';
                        // if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            // check if the user click to music's button
                            if (isset($_GET['Musique'])) {
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement
                             WHERE dateEvenement > current_date()  and categorie = 'Musique' ";

                                $Statement = $DB->prepare($sql);
                                $buttonColor1 = 'background-color: #FCA311;';

                                // check if the user click to cinema's button
                            } else if (isset($_GET['Cinema'])) {
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE dateEvenement > current_date()  and categorie = 'Cinema' ";

                                $Statement = $DB->prepare($sql);
                                $buttonColor2 = 'background-color: #FCA311;';

                                // check if the user click to theatre's button
                            } else if (isset($_GET['Théatre'])) {
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement
                             INNER JOIN version ON evenement.idEvenement = version.idEvenement
                              WHERE dateEvenement > current_date()  and categorie = 'Théatre' ";

                                $Statement = $DB->prepare($sql);
                                $buttonColor3 = 'background-color: #FCA311;';

                                // check if the user click to All's button
                            } else if (isset($_GET['All'])) {
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE dateEvenement >= current_date()  ";

                                $Statement = $DB->prepare($sql);
                                $buttonColor4 = 'background-color: #FCA311;';

                                // check if the user search by titel
                            } else if (isset($_GET['search'])) {
                                $search_input = '%' . $_GET['search'] . '%';
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE titre LIKE :search AND dateEvenement >= current_date()";

                                $Statement = $DB->prepare($sql);
                                $Statement->bindParam(':search', $search_input);

                                // check if the user search by date
                            } else  if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE dateEvenement >= :from_date and dateEvenement <= :to_date ";

                                $Statement = $DB->prepare($sql);
                                $Statement->bindParam(':from_date', $from_date);
                                $Statement->bindParam(':to_date', $to_date);
                            } else {
                                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE dateEvenement >= current_date()  ";
                                $Statement = $DB->prepare($sql);
                            }
                        // }
                        ?>
                        <!-- catigorie form -->
                        <form action="#listEvents" method="GET">
                            <button  style=" <?php echo $buttonColor4; ?>" name="All">All</button>
                            <button style=" <?php echo $buttonColor1; ?>" name="Musique">Musique</button>
                            <button style=" <?php echo $buttonColor2; ?>" name="Cinema">Cinema</button>
                            <button style=" <?php echo $buttonColor3; ?>" name="Théatre">Théatre</button>
                        </form>
                    </div>
                </div>
                <section class='m-5 p-3 d-flex justify-content-around flex-wrap'>
                    <?php
                    $Statement->execute();
                    while ($row = $Statement->fetch(PDO::FETCH_ASSOC)) {

                        $versionId = $row['numVersion'];
                        $capacity_room = capacity_room($versionId, $DB);
                        $count_ticket = count_ticket($versionId, $DB);

                        echo "<div class='card_event'>";
                        echo "<img src='{$path}/{$row['image']}.jpg' class='card_img'>";
                        echo "<div class='card_info'>";
                        echo "<span style='color:#FCA311;'> {$row['categorie']} </span>";
                        echo "<h5 class='card_titel'> {$row['titre']} </h5>";
                        echo "<span style='color:#E5E5E5;'> {$row['DATE(dateEvenement)']} </span><br>";
                        echo "<span style='color:#E5E5E5;'> {$row['TIME(dateEvenement)']} </span>";
                        echo "<form method='GET' action='index.php'>";
                        echo "<input hidden value='{$row['numVersion']}' name='event_id' >";
                        if ($count_ticket < $capacity_room) {
                            echo "<button class='mt-3 BUY' type='submit' name='buy'> Buy </button>";
                        } else {
                            echo "<button class='mt-3 SOLD_OUT' type='submit' name='buy'><s> Sold out </s></button>";
                        }

                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </section>
            </section><br><br><br><br><br>
        </section>

        <footer id="Contact" style="margin-top: 100px;">
            <div class="container">
                <div>
                    <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha Logo">
                </div><br>
                <div class=" d-flex justify-content-between flex-wrap">
                    <div class="w-25">
                        <p> <strong>Farha</strong> is your go-to source for unforgettable parties, enchanting evenings,
                            and captivating theatrical performances. We specialize in curating events
                            that elevate entertainment to new heights. Join us for a celebration of joy,
                            culture, and unforgettable moments.</p>
                    </div>
                    <div>
                        <h5 style="font-weight: bold;">Quick access links</h5>
                        <span>Home</span><br>
                        <span>Our Events</span><br>
                        <span> Contact us</span><br>
                        <span>Terms and conditions</span><br>
                        <span>Additional information</span><br>
                        <span>Cookie settings</span>
                    </div>
                    <div>
                        <h5 style="font-weight: bold;">Company information</h5>
                        <span>About Farha</span><br>
                        <span>Vision and innovation</span><br>
                        <span>Careers</span><br>
                        <span>Partnerships</span><br>
                        <span>Investors</span>
                    </div>
                    <div>
                        <h5 style="font-weight: bold;">Follow us</h5>
                        <div>
                            <i class="fa-brands fa-facebook"></i>
                            <i class="fa-brands fa-instagram"></i>
                        </div>
                    </div>
                </div><br><br>
                <div class="text-center mb-4">
                    <span> 2024 © - all rights reserved</span>
                </div>
            </div>
        </footer>
        <script>
            function submitForm() {
                document.getElementById('signOutForm').submit();
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>

</html>