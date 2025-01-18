<?php
require_once '../db.php'; // Include your database connection file

function getUnbilledMeterReadings($conn) {
    $sql = "SELECT * FROM meter_readings WHERE billed = 0";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getUnpaidBills($conn) {
    $sql = "SELECT * FROM billing WHERE paid = 0";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getCustomerDetails($conn, $customer_id) {
    $sql = "SELECT name, address, zipcode FROM customers WHERE id = '" . $customer_id . "'";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function createBillingEntry($conn, $customer_id, $amount) {
    $sql = "INSERT INTO billing (customer_id, amount, processed, paid) VALUES ('$customer_id', '$amount', 0, 0)";
    if ($conn->query($sql) === TRUE) {
        echo "Billing entry created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


function markAsBilled($conn, $reading_id) {
    $sql = "UPDATE meter_readings SET billed = 1 WHERE id = '$reading_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Reading marked as billed.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bill'])) {
    $reading_id = $_POST['reading_id'];
    $customer_id = $_POST['customer_id'];
    $reading = $_POST['reading'];
    $amount = $reading * 0.73;
    createBillingEntry($conn, $customer_id, $amount);
    markAsBilled($conn, $reading_id);
}

$readings = getUnbilledMeterReadings($conn);
$bills = getUnpaidBills($conn);

$conn->close();
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Laskutus</title>
</head>
<body>
    
</body>
</html>

<!DOCTYPE html>
<html lang="fi">
<?php include 'head.php'; ?>
<body>
    <?php include 'header.php'; ?>
    <?php include 'menu.php'; ?>
    <main>
        <div class="container">
        <div class="row">
            <h1>Laskuttamattomat vesimittari-ilmoitukset</h1>
            <table class="table table-striped"">
                <tr>
                    <th>ID</th>
                    <th>Asiakas ID</th>
                    <th>Päivämäärä</th>
                    <th>Lukema</th>
                    <th>Toiminto</th>
                </tr>
                <?php foreach ($readings as $reading): ?>
                    <tr>
                        <td><?php echo $reading['id']; ?></td>
                        <td><?php echo $reading['customer_id']; ?></td>
                        <td><?php echo $reading['created_at']; ?></td>
                        <td><?php echo $reading['reading']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="reading_id" value="<?php echo $reading['id']; ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $reading['customer_id']; ?>">
                                <input type="hidden" name="reading" value="<?php echo $reading['reading']; ?>">
                                <button type="submit" name="bill">Laskuta</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="row">
            <h2>Avoimet laskut</h2>
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Asiakas ID</th>
                    <th>Määrä</th>
                    <th>Postitus</th>
                </tr>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?php echo $bill['id']; ?></td>
                        <td><?php echo $bill['customer_id']; ?></td>
                        <td><?php echo $bill['amount']; ?> €</td>
                        <td>
                            <?php if ($bill['processed'] == 0): ?>
                                <form method="post" action="processbill.php">
                                    <input  type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                                    <button class="btn btn-primary" type="submit" name="process">Luo PDF lasku</button>
                                </form>
                            <?php else: ?>
                                <a href="invoices/<?php echo $bill['path']; ?>" class="btn btn-success">Lataa PDF lasku</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <a href="/intra/customers.php" class="btn btn-primary">Takaisin</a>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
