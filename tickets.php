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
    <script src="https://kit.fontawesome.com/e3ff8bb9fb.js" crossorigin="anonymous"></script>
    <title>Tickets</title>
</head>

<body>
    <?php
    if (isset($_POST['tickets'])) {
        if (isset($_POST['invoiceId'])) {
            if (isset($_SESSION['versionId'])) {

                $versionId = $_SESSION['versionId'];

                $invoiceId = $_POST['invoiceId'];
                $Tickets_on_invoice = Tickets_on_invoice($invoiceId, $DB);
                $Version_event = Version_event($versionId, $DB);

                foreach ($Tickets_on_invoice as $Ticket) {
                    if ($Ticket['typeBillet'] == 'normal') {
                        $tarif = $Version_event['tarifnormal'];
                    }
                    if ($Ticket['typeBillet'] == 'réduit') {
                        $tarif = $Version_event['tarifReduit'];
                    }
                    echo ' <div class="cardWrap">
            <div class="cards cardLeft">
                <h1>Farha Association <br> <span style="font-size: small;">Cultural Center Farha, Tangier</span></h1>
                <div class="title">
                    <h2>' . $Version_event['titre'] . '</h2>
                    <span>' . $Version_event['categorie'] . '</span>
                </div>
                <div class="tarif">
                    <div>
                        <h2> MAD ' . $tarif . '</h2>
                        <span>tarif</span>
                    </div>
                    <div>
                        <h2>' . $Ticket['typeBillet'] . '</h2>
                        <span>type</span>
                    </div>
    
                </div>
    
                <div class="seat">
                    <h2>' . $Version_event['numSalle'] . '</h2>
                    <span>salle</span>
                </div>
                <div class="date">
                    <h2>' . $Version_event['DATE(dateEvenement)'] . '</h2>
                    <span>date</span>
                </div>
                <div class="time">
                    <h2>' . $Version_event['TIME(dateEvenement)'] . '</h2>
                    <span>time</span>
                </div>
    
            </div>
            <div class="cards cardRight">
                <div style="text-align: center;">
                    <h1>#' . $Ticket['codeBillet'] . '</h1>
                </div>
                <div class="number">
                    <h3>' . $Ticket['numPlace'] . '</h3>
                    <span>seat</span>
                </div>
                <div class="barcode"></div>
            </div>
    
        </div>';
                }
            }
        }
    }

    ?>

    <a href="#" onclick="window.print()"><i class="fa fa-print"></i></a>

</body>

</html>