<?php
// Tietokantayhteys
require_once "../db.php";

// Kirjautumisen tarkastus
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /intra/login.php');
    exit;
}

$sql = "SELECT * FROM contacts";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="fi">
<?php include 'head.php'; ?>
<body>
    <?php include 'header.php'; ?>
    <?php include 'menu.php'; ?>
    <main>
    <div class="container">
            <div class="row mt-3">
                <div class="col-12">
                    <h4>Yhteystiedot</h4>
                </div>
            </div>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo $row['name']; ?></p>
                            <p class="card-text">Puhelin: <?php echo $row['phone']; ?></p>
                            <p class="card-text">Sähköposti: 
                                <a href="<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
