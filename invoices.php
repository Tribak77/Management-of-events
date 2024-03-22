<?php
session_start();
include 'connection.php';

if (isset($_POST['invoiceId'])) {
    $invoiceId = $_POST['invoiceId'];
    $versionId = $_POST['event_id'];
} else {
    echo 'not found';
}
// Check if the user is logged in 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $User_info = User_info($user_id, $DB);
    $invoices_info = Invoices_info($user_id, $versionId, $DB);
    $Version_event = Version_event($versionId, $DB);
    $Tickets_on_invoice = Tickets_on_invoice($invoiceId, $DB);
} else {
    header("Location: sign_in.php");
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
    <title>invoices</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title row">
                            <div class="col-4">
                            <h2 class="mb-1 ">Farha Association</h2>
                                <p class="mb-1">Cultural Center Farha, Tangier</p>
                                <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> www.Farha.com</p>
                                <p><i class="uil uil-phone me-1"></i> 012-345-6789</p>
                            </div>
                            <div class="col-4 text-center">
                            <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha logo">
                            </div>
                            <div class="col-4 text-end">
                                <h4 class=" font-size-15"><?php echo $Version_event['titre']; ?> </h4>
                                <span class="font-size-12 ms-2"><?php echo $Version_event['dateEvenement']; ?> </span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Client :</h5>
                                    <h5 class="font-size-15 mb-2"> <?php echo $User_info['prenom'] . ' ' . $User_info['nom']; ?> </h5>
                                    <p class="mb-1"><?php echo $User_info['email']; ?> </p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice Id:</h5>
                                        <p> <?php echo $invoices_info['idFacture']; ?> </p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p> <?php echo $invoices_info['dateFacture']; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Rate</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tarifnormal = $Version_event['tarifnormal'];
                                        $tarifReduit = $Version_event['tarifReduit'];

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

                                        if ($Quantity_normal > 0) {

                                            echo '<tr>
                                        <th scope="row">01</th>
                                        <td> normal </td>
                                        <td> MAD ' . $tarifnormal . '</td>
                                        <td>' . $Quantity_normal . '</td>
                                        <td class="text-end"> MAD ' . $tarifnormal * $Quantity_normal . '</td>
                                    </tr>';
                                        }

                                        if ($Quantity_reduit > 0) {

                                            echo '<tr>
                                        <th scope="row">02</th>
                                        <td> reduced </td>
                                        <td> MAD ' . $tarifReduit . '</td>
                                        <td>' . $Quantity_reduit . '</td>
                                        <td class="text-end"> MAD ' . $tarifReduit * $Quantity_reduit . '</td>
                                    </tr>';
                                        }
                                        $Total_payment = $tarifReduit * $Quantity_reduit + $tarifnormal * $Quantity_normal;
                                        ?>

                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold"> MAD <?php echo $Total_payment; ?> </h4>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="d-print-none mt-4">
                                <div class="float-end">
                                    <a href="#" onclick="window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>