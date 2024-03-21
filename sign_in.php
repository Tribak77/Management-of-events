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
    <title>sign in</title>
</head>

<body style="background-color: #f4f4f4;">

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
                            <a class="nav-link" href="index.php#Contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <section class=' d-flex justify-content-center mt-4'>
        <form method='POST' action='' style="background-color: white;" class='row g-3 w-50 border p-2 my-3'>
            <div>
                <label class='form-label'> email :</label>
                <input type='email' class='form-control' name='email' required>
            </div>
            <div>
                <label class='form-label'> password :</label>
                <input type='password' class='form-control' name='pass' required>
            </div>
            <div>
                <input type='hidden' name='id_user' value=''>
                <button class='btn btn-dark m-1' id='signInBtn' type='submit' name='sign-IN'> sign in</button>
                <span class='opacity-50'>Don't have an </span> <a class='text-reset' href='sign_up.php' role='button'> account ? </a>
            </div>
        </form>
    </section>

    <?php
    // Storing the previous page URL in a session variable
    $_SESSION['redirect_url'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    $redirect_url = $_SESSION['redirect_url'];

    if (isset($_POST['sign-IN'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $statement = $DB->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($pass, $row['motPasse'])) {
                $id_user = $row['idUtilisateur'];
                $_SESSION['user_id'] = $id_user;

                // Redirect the user back to the previous page or a default page if no return URL is provided
                $return_url = isset($_SESSION['return_url']) ? $_SESSION['return_url'] : 'index.php';
                header('Location: ' . $return_url);
                exit;
            } else {
                echo " error : Invalid credentials. Authentication failed.";
            }
        } else {
            echo " Invalid credentials. Authentication failed.";
        }
    }




    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>