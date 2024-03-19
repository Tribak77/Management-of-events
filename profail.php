<?php
session_start();
include 'connection.php';

// Check if the user is logged in 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $User_info = User_info($user_id, $DB);
} else {
    header("Location: sign_in.php");
    exit();
}

// check if the user clicked at the sign out button to destroy the session and log out
if (isset($_POST['sign_out'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
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
    <title>Profile personly</title>
</head>

<body>

    <nav id="nav_home" class="navbar  sticky-top">
        <div class="container">
            <a href="index.php"> 
                            <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha logo">
            </a>
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
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <section class="top_page">
        <!-- the white part on the profil's page (just for the design) -->
    </section>

    <section class="buttom_page d-flex justify-content-center">
        <div class="row w-75" id="profil_cart">
            <div class="w-100 col-12 text-center">
                <img src="imgs/user1.jpg" style="width: 300px; height: 300px ; margin-top: -60px; border-radius:50%;" alt="user image">

                <form id="signOutForm" action="profail.php" method="POST">
                    <i class="fa-solid fa-arrow-right-from-bracket d-flex justify-content-center" id="sign_out" onclick="submitForm()">
                        <input type="hidden" name="sign_out">
                    </i>
                </form>
            </div>
            <div class="col-12 text-center">
                <h3>Your Informations :</h3>
                <p><span> Full name : </span><?php echo $User_info['prenom'] . " " . $User_info['nom']; ?></p>
                <p><span>email : </span><?php echo $User_info['email']; ?></p>
                <form action="edit_profail.php" method="POST">
                    <button id="edit_btn" type="submit" name="edit">Edit</button>
                </form>
            </div>
            <div class="col-12">
                <h3>Your purchases :</h3>
                <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Invoice reference</th>
                        <th>Date of purchase</th>
                        <th>Total paid</th>
                        <th> My tickets</th>
                        <th> My invoice</th>
                    </tr>
                    <?php
                    $Purchases_invoices = Purchases_invoices($user_id, $DB);


                    // Check if the array is not empty
                    if (!empty($Purchases_invoices)) {

                        foreach ($Purchases_invoices as $invoice) {
                            $versionId = $invoice['numVersion'];

                            $Version_event = Version_event($versionId, $DB);
                            $tarifnormal = $Version_event['tarifnormal'];
                            $tarifReduit = $Version_event['tarifReduit'];

                            $invoiceId = $invoice['idFacture'];

                            $Tickets_on_invoice = Tickets_on_invoice($invoiceId, $DB);
                            $Quantity_normal = 0;
                            $Quantity_reduit = 0;

                            foreach ($Tickets_on_invoice as $ticket) {
                                if ($ticket['typeBillet'] == 'normal') {
                                    $Quantity_normal++;
                                }

                                if ($ticket['typeBillet'] == 'réduit') {
                                    $Quantity_reduit++;
                                }
                            }
                            $Total_payment = $tarifReduit * $Quantity_reduit + $tarifnormal * $Quantity_normal;


                            echo "<tr> 
                <td>" . $invoice['idFacture'] . " </td>
                <td>" . $invoice['dateFacture'] . "</td>
                <td> MAD " . $Total_payment . "</td>
                <td>
                  <form action='tickets.php' method='POST' target='_blank'>
                    <input hidden value='{$invoice['idFacture']}' name='invoiceId' >
                    <button type='submit' name='tickets' class='btn_p' >  see  </button>
                  </form>
                </td>
                <td>
                  <form action='invoices.php' method='POST' target='_blank' >
                  <input hidden value='{$invoice['numVersion']}' name='event_id' >
                   <input hidden value='{$invoice['idFacture']}' name='invoiceId' >
                   <button type='submit' name='invoice' class='btn_p' > see  </button>
                 </form>
                </td>
                
              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No invoices found</td></tr>";
                    }
                    ?>
                </table>
                </div>
            </div>
        </div>
    </section>

    <footer id="Contact" class="mt-5">
        <div class="container ">
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