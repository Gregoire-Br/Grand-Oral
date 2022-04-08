<?php
session_start();
if (!isset($_SESSION["session"]) || $_SESSION["status"] != 2) header("Location: /form/");

error_reporting(E_ALL & ~E_NOTICE);


$erreur = '';
?>

<!DOCTYPE html>
<html lang="en">

<?php include "var/header.html" ?>
<title>Profils</title>

<body>
  <div id="alertPlaceholder" class="position-fixed bottom-0 end-0 p-3"></div>

  <?php include "var/navbar.html" ?>

  <div class="container-fluid">

    <div id="data">
      <form action="" method="post" class="needs-validation" novalidate>

        <div class="form-group mb-3 d-flex ">
          <span class="input-group-text">Nom</span>
          <input type="text" class="form-control" id="last" name="lastname" required>

          <span class="input-group-text ">Prénom</span>
          <input type="text" class="form-control" id="first" name="firstname" required>
        </div>

        <div class="rightUserData d-flex">
          <span class="input-group-text">Nom utilisateur</span>
          <input type="text" class="form-control" id="username" name="username" required>

          <span class="input-group-text">E-mail</span>
          <input type="text" class="form-control" id="email" name="email" required>
        </div>

        <div class="statsUserData d-flex">
          <select class="form-control" id="status" name="status" required>
            <option disabled selected value>Tout les utilisateurs</option>
            <option value="0">Élève</option>
            <option value="1">Enseignant</option>
            <option value="3">Secrétaire</option>
            <option value="2">Proviseur</option>
          </select>

          <button class="btn btn-primary" type="submit" name="submit">Ajouter</button>
        </div>
      </form>
      <p id="error"><?php echo $erreur ?></p>
    </div>

    <div class="table-responsive-lg">
      <table id="myTable" class="table table-light table-striped">
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Nom Utilisateur</th>
          <th>e-mail</th>
          <th>Status</th>
        </tr>

        <?php
        $sql = "SELECT username, firstname, lastname, status, email from users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["lastname"] . "</td><td>" . $row["firstname"] . "</td><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["status"] . "</td></tr>";
          }
          echo "</table>";
        } else {
          echo "0 result";
        }
        $conn->close();
        ?>
      </table>
    </div>
  </div>

  <?php include "var/js.html" ?>
</body>

</html>