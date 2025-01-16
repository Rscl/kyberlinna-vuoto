<?php
// Tietokantayhteys
require_once "../db.php";

// Kirjautumisen tarkastus
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /intra/login.php');
    exit;
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Asiakastunnus</th>
                        <th>Nimi</th>
                        <th>Osoite</th>
                        <th>Postinumero</th>
                        <th>Luotu</th>
                        <ht>Toiminnot</ht>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM customers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['customerid'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['zipcode'] . "</td>";
                            echo "<td>" . $row['create_time'] . "</td>";
                            ?>
                            <td>
                                <a href="edit_customer.php?id=<?php echo $row['customerid']; ?>" class="btn btn-primary">Muokkaa</a>
                                <a href="delete_customer.php?id=<?php echo $row['customerid']; ?>" class="btn btn-danger">Poista</a>
                            <?php
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Ei asiakastietoja</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <h3>Asiakastietojen lisäys</h3>
            <form action="add_customer.php" method="post">
                <div class="mb-3">
                    <label for="customerid" class="form-label">Asiakastunnus</label>
                    <input type="text" class="form-control" id="customerid" name="customerid" required>
                <div class="mb-3">
                    <label for="name" class="form-label">Nimi</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Osoite</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="zipcode" class="form-label">Postinumero</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                </div>
                <button type="submit" class="btn btn-primary">Lisää asiakas</button>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
