<?php
// Tietokantayhteys
require_once "../db.php";

// Kirjautumisen tarkastus
session_start();
if (isset($_SESSION['logged_in'])){
    if($_SESSION['logged_in'] === true) {
        header('Location: /intra/index.php');
        exit;
    }
}
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Haavoittuva SQL-kysely ilman suojausta
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['logged_in'] = true;
        header('Location: /intra/index.php');
        exit;
    } else {
        $error = "Virheellinen käyttäjätunnus tai salasana";
    }
}

?>
<!DOCTYPE html>
<html lang="fi">
<?php include 'head.php'; ?>
<body>
    <?php include 'header.php'; ?>
    <main>
        
        <div class="container">
        <h2>Kirjaudu sisään</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
            <form method="post">
                <label for="username">Käyttäjänimi:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Salasana:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button type="submit">Kirjaudu</button>
            </form>
        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
