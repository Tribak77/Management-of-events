<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3ff8bb9fb.js" crossorigin="anonymous"></script>
    <title>edit your profil</title>
</head>

<body style="background-color: #f4f4f4;">

<nav id="nav_home" class="navbar  sticky-top">
        <div class="container">
        <a href="index.php"> 
                            <img src="imgs/logo-removebg2.png" style="width: 150px;height:90px" alt="Farha logo">
            </a>            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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
                            <a class="nav-link" href="index.php#Contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profail.php">My account</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?php
    // Check if the user is logged in 
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $User_info = User_info($user_id , $DB);

        if (isset($_POST['save'])) {
            $edited_Fname = $_POST['F_name'];
            $edited_Lname = $_POST['L_name'];
            $edited_pass = $_POST['pass'];


                if (preg_match('/^(?=.*\d{2})(?=.*[a-zA-Z]{4}).{6,}$/', $edited_pass)) {
                    $edit_info = "UPDATE utilisateur 
                                  SET prenom = :edited_Fname , nom = :edited_Lname ,  motPasse = :edited_pass
                                  WHERE idUtilisateur = :user_id ";

                    $statement = $DB->prepare($edit_info);
                    $statement->bindParam(':edited_Fname', $edited_Fname);
                    $statement->bindParam(':edited_Lname', $edited_Lname);
                    $statement->bindParam(':edited_pass', $edited_pass);
                    $statement->bindParam(':user_id', $user_id);

                    $statement->execute();

                    header("Location: profail.php");
                    exit();
                } else {
                    echo "Invalid password format. It should contain at least 2 digits and 4 letters.";
                }
           
        }
    } else {
        header("Location: sign_in.php");
        exit();
    }
    ?>

    <section class='d-flex justify-content-center mt-4'>
        <form method='POST' action='' style="background-color: white;" class='row g-3 w-50 border p-2 my-3'>
            <div>
                <label class='form-label'> First name :</label>
                <input type='text' class='form-control' name='F_name' required value="<?php echo $User_info['prenom']; ?>">
            </div>
            <div>
                <label class='form-label'> Last name :</label>
                <input type='text' class='form-control' name='L_name' required value="<?php echo $User_info['nom']; ?>">
            </div>
            <div>
                <label class='form-label'> password :</label>
                <input type='password' class='form-control' name='pass' required value="<?php echo $User_info['motPasse']; ?>">
            </div>
            <div>
                <button id='save_btn' type='submit' name='save'> Save </button>
            </div>
        </form>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>