<?php
// Haetaan POST-parametrit
$customerId = "KLV-".$_POST['customerId'];
$meterReading = $_POST['meterReading'];
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilmoita vesimittarin lukema - Vuoto Oy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <h1>Ilmoita vesimittarin lukema</h1>
        </div>
    </header>
    <main class="container my-5">
<?php
require_once "db.php";
// Tarkistetaan yhteys
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haavoittuva SQL-kysely ilman suojausta
$sql = "INSERT INTO meter_readings (customer_id, reading) VALUES ('$customerId', '$meterReading')";
if ($conn->query($sql) === true) {
?>    <div>
            Kiitos lukemasta! Ilmoittamasi lukemasi on <?php echo $meterReading; ?> m³ käyttöpaikalle <?php echo $customerId; ?>.
        </div>
<?php
} else {
    ?><div><?php
    echo "Error: " . $sql . "<br>" . $conn->error;
    ?></div><?php
}

$conn->close();
?>
<div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Palaa etusivulle</a>
        </div>
</main>
<footer class="bg-dark text-white py-3">
        <div class="container">
            <p>&copy; 2025 Vuoto Oy. Kaikki oikeudet pidätetään.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>