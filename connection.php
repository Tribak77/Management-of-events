<?php
$dsn = 'mysql:host=localhost;dbname=Farha';
$user = 'root';
$pass = '';

try {
    $DB = new PDO($dsn, $user, $pass);
    $DB->exec('USE Farha');
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}

if (isset($_POST['sign_out'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

function capacity_room($versionId, $DB)
{
    $version = "SELECT * FROM salle INNER JOIN version 
    on version.numSalle = salle.numSalle 
    WHERE numVersion = :versionId AND  dateEvenement > current_date() ";
    $statement_v = $DB->prepare($version);
    $statement_v->bindParam(':versionId', $versionId);
    $statement_v->execute();
    $row_v = $statement_v->fetch(PDO::FETCH_ASSOC);
    return $row_v['capacite'];
}

function count_ticket($versionId, $DB)
{

    $count_b = "SELECT count(*) as count FROM billet INNER JOIN facture 
    on billet.idFacture = facture.idFacture 
    where numVersion = :versionId ";
    $statement_b = $DB->prepare($count_b);
    $statement_b->bindParam(':versionId', $versionId);
    $statement_b->execute();
    $row_b = $statement_b->fetch(PDO::FETCH_ASSOC);
    return $row_b['count'];
}

function generateUniqueCode()
{
    $uniqueId = uniqid();
    $randomNumber = mt_rand(1000, 9999);

    $uniqueCode = md5($uniqueId . $randomNumber);

    $uniqueCode = substr($uniqueCode, 0, 5);

    return $uniqueCode;
}



function Create_invoice($versionId, $DB, $invoiceId, $userId)
{

    $invoice = "INSERT INTO facture 
    VALUES ( :invoiceId , CURRENT_TIMESTAMP , :userId , :versionId ) ";
    $statement_i = $DB->prepare($invoice);
    $statement_i->bindParam(':invoiceId', $invoiceId);
    $statement_i->bindParam(':userId', $userId);
    $statement_i->bindParam(':versionId', $versionId);
    $statement_i->execute();

}

function Place_number($count_ticket, $versionId, $DB)
{
    $Place_number = $count_ticket + 1;
    return $Place_number;
}

function Create_ticket($ticket_id, $ticket_type, $Place_number, $invoiceId, $DB)
{
    $ticket = "INSERT INTO billet 
    VALUES ( :ticket_id , :ticket_type , :Place_number , :invoiceId ) ";
    $statement_t = $DB->prepare($ticket);
    $statement_t->bindParam(':ticket_id', $ticket_id);
    $statement_t->bindParam(':ticket_type', $ticket_type);
    $statement_t->bindParam(':Place_number', $Place_number);
    $statement_t->bindParam(':invoiceId', $invoiceId);
    $statement_t->execute();
}

function Purchases_invoices($userId, $DB)
{
    $Purchases = "SELECT * FROM utilisateur INNER JOIN facture 
    on utilisateur.idUtilisateur = facture.id_utilisateur 
    where idUtilisateur = :userId ";
    $statement_p = $DB->prepare($Purchases);
    $statement_p->bindParam(':userId', $userId);
    $statement_p->execute();
    $row_p = $statement_p->fetchAll(PDO::FETCH_ASSOC);
    return $row_p;
}

function Invoices_info($userId,$versionId, $DB)
{
    $Purchases = "SELECT * FROM utilisateur INNER JOIN facture 
    on utilisateur.idUtilisateur = facture.id_utilisateur 
    where idUtilisateur = :userId AND numVersion = :versionId";
    $statement_p = $DB->prepare($Purchases);
    $statement_p->bindParam(':userId', $userId);
    $statement_p->bindParam(':versionId', $versionId);
    $statement_p->execute();
    $row_p = $statement_p->fetch(PDO::FETCH_ASSOC);
    return $row_p;
}

// function Purchases_tickets($versionId,$userId, $DB)
// {
//     $Tickets = "SELECT * FROM billet INNER JOIN facture 
//     on billet.idFacture = facture.idFacture 
//     where numVersion = :versionId AND id_utilisateur = :userId";
//     $statement_t = $DB->prepare($Tickets);
//     $statement_t->bindParam(':versionId', $versionId);
//     $statement_t->bindParam(':userId', $userId);
//     $statement_t->execute();
//     $row_t = $statement_t->fetchAll(PDO::FETCH_ASSOC);
//     return $row_t;
// }

function Tickets_on_invoice($invoiceId, $DB){
    $Tickets = "SELECT * FROM billet INNER JOIN facture 
    on billet.idFacture = facture.idFacture 
    where facture.idFacture = :invoiceId ";
    $statement_t = $DB->prepare($Tickets);
    $statement_t->bindParam(':invoiceId', $invoiceId);
    $statement_t->execute();
    $row_t = $statement_t->fetchAll(PDO::FETCH_ASSOC);
    return $row_t;
}

function User_info($user_id , $DB){

    $user = "SELECT * FROM utilisateur WHERE idUtilisateur = :user_id";
    $statement = $DB->prepare($user);
    $statement->bindParam(':user_id', $user_id);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function Version_event($versionId, $DB){
    $sql = "SELECT *, TIME(dateEvenement) , DATE(dateEvenement) FROM evenement INNER JOIN version 
    on version.idEvenement = evenement.idEvenement 
    WHERE numVersion = :versionId AND  dateEvenement > current_date() ";
$statement = $DB->prepare($sql);
$statement->bindParam(':versionId', $versionId);
$statement->execute();

$row = $statement->fetch(PDO::FETCH_ASSOC);
return $row;
}