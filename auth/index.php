<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>

<body>

    <?php
    include 'sql.php';

    error_reporting(E_ALL & ~E_NOTICE);

    if(session_status() == 2){
        header('Location: session.php');
    }

    $erreur = '';

    if ($_POST["submit"]) {
        $username = strip_tags($_POST["username"]);
        $password = strip_tags($_POST["password"]);

        $connection = mysqli_connect($sql_ip, $sql_login, $sql_pass, $sql_db);
        if (!$connection) {
            die("Connection impossible");
        } else {
            if ($requete = mysqli_query($connection, "SELECT * FROM users WHERE login = \"$username\" AND password = \"$password\"")) {

                if (mysqli_num_rows($requete)) {
                    session_start();
                    $_SESSION["status"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                    header('Location: session.php');
                } else {
                    $erreur = 'Identifiant ou mot de passe incorrect';
                }
            }
        }
    }
    ?>

    <div id="login">
        <div class="container"> 
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-24">
                        <img id="logo" src="logo.png" class="mx-auto d-block">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Connexion</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Identifiant:</label><br>
                                <input type="text" name="username" id="username" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Mot de passe:</label><br>
                                <input type="password" name="password" id="password" required class="form-control">
                            </div>
                            <div class="form-group">
                                <p id="error"><?php echo $erreur; ?></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Se connecter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>