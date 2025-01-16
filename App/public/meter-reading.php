<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilmoita vesimittarin lukema - Vuoto Oy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <h1>Ilmoita vesimittarin lukema</h1>
        </div>
    </header>
    <main class="container my-5">
        <form id="meterForm" action="submit-meter-reading.php" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="customerId" class="form-label">Asiakastunnus</label>
                <div class="input-group">
                    <span class="input-group-text" id="prefix">KLV-</span>
                    <input type="text" class="form-control" id="customerId" name="customerId" pattern="\\d{1,6}" maxlength="6" aria-describedby="prefix" required oninput="validateNumeric(this)">
                </div>
                <div class="form-text">Täytä asiakastunnuksen numerot (enintään 6).</div>
            </div>
            <div class="mb-3">
                <label for="meterReading" class="form-label">Vesimittarin lukema</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="meterReading" name="meterReading" min="0" max="100000" step="1" required>
                    <span class="input-group-text">m³</span>
                </div>
                <div class="form-text">Syötä vesimittarin lukema kokonaislukuina (max. 100000 m³).</div>
            </div>
            <button type="submit" class="btn btn-primary">Lähetä</button>
        </form>
        <!-- Palaa etusivulle -painike -->
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
