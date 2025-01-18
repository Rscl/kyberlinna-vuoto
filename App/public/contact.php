<?php require_once "db.php";
$sql = "SELECT * FROM contacts WHERE public = 1";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ota yhteyttä - Vuoto Oy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <h1>Vuoto Oy</h1>
            <p>Kyberlinnan Vesilaitos - Luotettavaa palvelua vuodesta 1950</p>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Vuoto Oy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Etusivu</a></li>
                    <li class="nav-item"><a class="nav-link" href="meter-reading.php">Ilmoita vesimittarin lukema</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Ota yhteyttä</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kyberlinnan Vesilaitos Vuoto Oy</h5>
                            <p class="card-text">Käyntiosoite: Kyberlinna, 00100 Kyberlinna</p>
                            <p class="card-text">Postiosoite: PL 123, 00100 Kyberlinna</p>
                            <p class="card-text">Puhelin: 010 123 4567</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h4>Henkilöstö</h4>
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
    <footer class="bg-dark text-white py-3">
        <div class="container">
            <p>&copy; 2025 Vuoto Oy. Kaikki oikeudet pidätetään.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript-validointi vesimittarin lukemalle
        document.getElementById('meterForm').addEventListener('submit', function (event) {
            const meterReading = document.getElementById('meterReading');
            const value = parseInt(meterReading.value, 10);

            if (isNaN(value) || value < 0 || value > 100000) {
                event.preventDefault();
                event.stopPropagation();
                alert('Vesimittarin lukeman on oltava kokonaisluku välillä 0–100000.');
            }
        });

        // JavaScript-validointi: sallii vain numeroiden syöttämisen asiakastunnuskenttään
        function validateNumeric(input) {
            input.value = input.value.replace(/[^0-9]/g, ''); // Poistaa muut kuin numerot
        }
    </script>
</body>
</html>
