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

$customerId = isset($_GET['id']) ? $_GET['id'] : null;
// : (isset($_POST['id']) ? $_POST['id'] : null);

// Päivitä asiakastiedot
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];

    if (empty($name) || empty($address) || empty($zipcode)) {
        $error = 'Kaikki kentät ovat pakollisia.';
    } else {
        $stmt = $conn->prepare("UPDATE customers SET name = ?, address = ?, zipcode = ? WHERE customerid = ?");
        $stmt->bind_param("ssss", $name, $address, $zipcode, $customerId);

        if ($stmt->execute()) {
            $success = 'Asiakastiedot päivitetty onnistuneesti!';
        } else {
            $error = 'Virhe päivitettäessä asiakastietoja.';
        }
    }
}

// Tarkista, onko asiakas ID annettu
if ($customerId) {

    // Hae asiakastiedot tietokannasta
    $query = "SELECT * FROM customers WHERE customerid = '$customerId'";
    $result = $conn->query($query);
    
    if ($result) {
        $customer = $result->fetch_assoc();
    } else {
        $error = 'Virhe haettaessa asiakastietoja: ' . $conn->error;
    }

    if (!$customer) {
        $error = 'Asiakasta ei löytynyt.';
    }
    } else {
        $error = 'Asiakas ID puuttuu.';
    }

// Päivitä asiakastiedot
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];

    if (empty($name) || empty($address) || empty($zipcode)) {
        $error = 'Kaikki kentät ovat pakollisia.';
    } else {
        $query = "UPDATE customers SET name = '$name', address = '$address', zipcode = '$zipcode' WHERE customerid = '$customerId'";
        if ($conn->query($query) === TRUE) {
            $success = 'Asiakastiedot päivitetty onnistuneesti!';
        } else {
            $error = 'Virhe päivitettäessä asiakastietoja: ' . $conn->error;
        }
    }
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
            <h2>Muokkaa asiakastietoja</h2>
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php } elseif (!empty($success)) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php } ?>
            <?php if ($customer) { ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nimi</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Osoite</label>
                        <input type="address" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="zipcode" class="form-label">Postiosoite</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($customer['zipcode']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tallenna</button>
                </form>
            <?php } ?>
            <a href="/intra/customers.php" class="btn btn-secondary mt-3">Takaisin</a>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>