<?php
// Tietokantayhteys
require_once "../db.php";

// Kirjautumisen tarkastus
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /intra/login.php');
    exit;
}
$error = '';
$success = '';

// Add customer to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerid = $_POST['customerid'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];
    // insert customer to the database
    $query = "INSERT INTO customers (customerid, name, address, zipcode) VALUES ('$customerid', '$name', '$address', '$zipcode')";

    if ($conn->query($query) === TRUE) {
        $success = 'Asiakas lisätty onnistuneesti!';
    } else {
        $error = 'Virhe lisättäessä asiakasta: ' . $conn->error;
    }
}
else
{
    $error = "Virheellinen pyyntö";
}

?>
<!DOCTYPE html>
<html lang="fi">
<?php include 'head.php'; ?>
<body>
    <?php include 'header.php'; ?>
    <?php include 'menu.php'; ?>
    <main>
        <div class="container">
            <h2>Asiakastiedot</h2>
            <?php if(!empty(($error))){
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php
            }else
            {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
                <?php
            }
            ?>
            <a href="/intra/customers.php" class="btn btn-primary">Takaisin</a>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
