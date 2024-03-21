<?php
session_start();
include 'connection.php';

// Store the current URL in the session variable
$_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
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
    <title>event details</title>
</head>

<body>
    <nav id="nav_home" class="navbar  sticky-top">
        <div class="container">
            <a href="index.php">
                <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha logo">
            </a> <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#today">Next event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#listEvents">Upcoming events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profail.php">My account</a>
                        </li>
                    </ul>
                    <?php
                    // check if the user is connected to show the sign_out's button, if the session is not empty, then the user is connected
                    if (isset($_SESSION['user_id'])) {
                        $userId = $_SESSION['user_id'];
                        echo "<form id='signOutForm' action='profail.php' method='POST'>
                        <i class='fa-solid fa-arrow-right-from-bracket d-flex' id='sign_out' onclick='submitSignOutForm()'>
                        <input type='hidden' name='sign_out'>
                         </i>
                  </form>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_SESSION['versionId'])) {
        $versionId = $_SESSION['versionId'];
        $count_ticket = count_ticket($versionId, $DB);
        $capacity_room = capacity_room($versionId, $DB);

        $path = "imgs";
        $Version_event = Version_event($versionId, $DB);

        $tarifnormal = (int)$Version_event['tarifnormal'];
        $tarifReduit = (int)$Version_event['tarifReduit'];
    }



    if (isset($_POST['buy_ticket'])) {

        if (isset($_POST['ticket_normal'])) {
            $ticket_normal = (int)$_POST['ticket_normal'];
        } else {
            $ticket_normal = 0;
        }

        if (isset($_POST['ticket_reduit'])) {
            $ticket_reduit = (int)$_POST['ticket_reduit'];
        } else {
            $ticket_reduit = 0;
        }
        // check if the user is connected; if the session is not empty, then the user is connected after clicked at the buy's button
        if (isset($_SESSION['user_id'])) {

            $Total_payment = ($tarifnormal * $ticket_normal) + ($tarifReduit *  $ticket_reduit);

            $sum_tickets = (int)$count_ticket + (int)$ticket_normal + (int)$ticket_reduit;

            if ($sum_tickets < $capacity_room) {

                echo '<div class="scren" id="scren">
                     </div>
                    <div class="pupUp" id="pupUp">
                        <div class="modal-header"> 
                            <button type="button" class="close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button> 
                        </div>
                              
                        <div class="d-flex justify-content-center">
                            <div class="m-2">
                                <span> Ticket normal : </span><br>
                                <span > ' . $ticket_normal . ' </span>                              
                            </div>
                            <div class="m-2">
                                <span> Ticket reduit : </span><br>
                                <span > ' . $ticket_reduit . ' </span>
                            </div>
                        </div>
                                 <hr>
                            <form action="" method="POST" class="confirm">
                                    <div class="d-flex justify-content-center">
                                        <label class="m-1" for="total">Total payment :</label> <br>
                                        <input type="number" name="total" class="form-control" id="total" value="' . $Total_payment . '" readonly>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                    <input type="hidden" name="ticket_normal_count" value="' . $ticket_normal . '">
                                    <input type="hidden" name="ticket_reduit_count" value="' . $ticket_reduit . '">                        
                                        <button class="btn btn-dark m-2" type="submit" name="confirm">Confirm</button>
                                    </div>
                            </form>
                    </div>';
            } else {
                // If the user selects a number of unavailable tickets, the page will show a pop-up window to notify him
                echo '<div class="scren" id="scren">
                          </div>
                           <div class="pupUp" id="pupUp">
                           <div class="modal-header"> 
                           <button type="button" class="close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button> 
                           </div>
                            <p> This number of tickets is not available </p>
                          </div>
                          ';
            }
        } else {
            // if the user not log in the page show a pop-up to inform him to sign in before reserved            
            echo '<div class="scren" id="scren">
                       
                          </div>
                           <div class="pupUp" id="pupUp">
                           <div class="modal-header"> 
                           <button type="button" class="close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button> 
                           </div>
                            <p>You must log in to purchase tickets</p><br>
                            <button class="btn btn-dark" onclick="window.location.href=\'sign_in.php\'">Sign in</button>
                          </div>
                          ';
        }
    }


    // create the invoice and the tickets in the database by click at the confirm's button
    if (isset($_POST['confirm'])) {

        $ticket_normal_count = (int)$_POST['ticket_normal_count'];
        $ticket_reduit_count = (int)$_POST['ticket_reduit_count'];

        if ($ticket_normal_count > 0 ||  $ticket_reduit_count > 0) {
            $invoiceId = generateUniqueCode();
            Create_invoice($versionId, $DB, $invoiceId, $userId);

            $initialCountTicket = count_ticket($versionId, $DB);

            for ($i = 1; $i <= $ticket_normal_count; $i++) {
                $count_ticket = count_ticket($versionId, $DB);
                $ticket_type = 'normal';
                $Place_number = Place_number($count_ticket, $versionId, $DB);
                $ticket_id = generateUniqueCode();

                Create_ticket($ticket_id, $ticket_type, $Place_number, $invoiceId, $DB);
            }

            for ($j = 1; $j <= $ticket_reduit_count; $j++) {
                $count_ticket = count_ticket($versionId, $DB);
                $ticket_type = 'réduit';
                $Place_number = Place_number($count_ticket, $versionId, $DB);
                $ticket_id = generateUniqueCode();

                Create_ticket($ticket_id, $ticket_type, $Place_number, $invoiceId, $DB);
            }

            echo  '<div class="scren" id="scren">
            </div>
             <div class="pupUp" id="pupUp">
             <div class="modal-header"> 
             <button type="button" class="close" onclick="closeModal()">&times;</button> 
             </div>
             <div class="modal-body"> 
             <span> Reservation successful </span>
             </div>
             <div class="">
             <form action="tickets.php" method="POST" target="_blank">
             <input type="hidden" value="' . $invoiceId . '" name="invoiceId">
              <button type="submit" class="btn btn-dark m-2" name="tickets" > View tickets </button>
              </form>
              <form action="invoices.php" method="POST" target="_blank">
              <input hidden value=' . $versionId . ' name="event_id" >
              <input type="hidden" value="' . $invoiceId . '" name="invoiceId">
              <button type="submit" class="btn btn-dark m-2" name="invoice" > View invoice </button>
              </form>
              </div>
            </div>
            ';
        } else{
            echo '<div class="scren" id="scren">
            </div>
            <div class="pupUp" id="pupUp">
            <div class="modal-header"> 
            <button type="button" class="close" onclick="closeModal()">&times;</button> 
            </div>
            <div class="modal-body"> 
            <span> You must at least choose one ticket </span>
            </div>
            </div>
            ';
        }
    }


    ?>

    <section>
        <div class="details d-flex justify-content-center">
            <div class="details_info">
                <div id="d_info">
                    <h1 style="color: #FCA311;"> <?php echo $Version_event['titre']; ?> </h1><br>
                    <h5 style="color: white;"> <?php echo $Version_event['DATE(dateEvenement)']; ?> </h5>
                    <h5 style="color: white;"> <?php echo $Version_event['TIME(dateEvenement)']; ?> </h5><br>
                    <h6 style="color: white;"> <span>Tarif normal :</span> <?php echo $Version_event['tarifnormal']; ?> DH</h6>
                    <h6 style="color: white;"> <span>Tarif reduit :</span> <?php echo $Version_event['tarifReduit']; ?> DH</h6><br>
                    <h6 style="color: white;">Description : </h6>
                    <span style="color: white;"> <?php echo $Version_event['description']; ?> </span>
                </div>


            </div>
            <div class="details_img" style=" background-image: url('<?php echo $path . '/' . $Version_event['image'] . '.jpg'; ?>');">
                <div class="details_categ text-center">
                    <h3> <?php echo $Version_event['categorie']; ?> </h3>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <form action="" method="POST" class="details_buy ">
                <div class="d-flex justify-content-center">
                    <div class="m-2">
                        <span style="color: white;"> Ticket normal : </span>
                        <input type="number" min="0" class="form-control" id="ticket_normal" name="ticket_normal">
                    </div>
                    <div class="m-2">
                        <span style="color: white;"> Ticket reduit : </span>
                        <input type="number" min="0" class="form-control" id="ticket_reduit" name="ticket_reduit">
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <?php
                        if ($count_ticket < $capacity_room) {
                            echo "<button class='m-2 BUY' type='submit' name='buy_ticket'> Buy </button>";
                        } else {
                            echo "<button class='mt-3 SOLD_OUT' type='submit' name='buy_ticket' disabled ><s> Sold out </s></button>";
                        }
                        ?>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <section class="list mt-5 pb-3 pt-5">
        <div class="text-center mt-5">
            <h2 style="color: white;"> Similar </h2>
            <span style="color: white; opacity:0.8;">Discover the exciting events on the horizon. Join us for memorable moments</span>
            <div class="catigorie m-3">
                <?php
                $categorie = $Version_event['categorie'];
                $sql = "SELECT * , TIME(dateEvenement) , DATE(dateEvenement) FROM evenement 
                            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
                            WHERE dateEvenement >= current_date()  AND categorie = :categorie";
                $Statement = $DB->prepare($sql);
                $Statement->bindParam(':categorie', $categorie);
                ?>

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
        function submitSignOutForm() {
            document.getElementById('signOutForm').submit();
        }

        function closeModal() {
            let scren = document.getElementById('scren');
            let pupUp = document.getElementById('pupUp');
            pupUp.style.display = 'none';
            scren.style.display = 'none';
        }
    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</html>