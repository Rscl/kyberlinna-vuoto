<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuoto Oy - Kyberlinnan Vesilaitos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/styles.css">
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
                    <li class="nav-item"><a class="nav-link" href="#">Ota yhteyttä</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Tervetuloa Vuoto Oy:n kotisivuille</h2>
                <p>Vuoto Oy vastaa Kyberlinnan vesihuollosta ja tarjoaa puhdasta vettä sekä luotettavia palveluita koko alueen asukkaille ja yrityksille.</p>
                <p>Palvelumme kattavat veden jakelun, jäteveden käsittelyn sekä asiakaslähtöiset ratkaisut vesihuollon tarpeisiin.</p>
            </div>
            <div class="col-md-4">
                <div id="consumption-widget" class="p-3 bg-light border">
                    <h4>Vedenkulutus</h4>
                    <canvas id="meter" style="width: 100%; height: 200px;"></canvas>
                    <div>Kyberlinnan tämän hetkinen vedenkulutus: <span id="consumption-value">Ladataan...</span></div>
                    <div>Vedenpaine pumppaamolla: <span id="pressure-value">Ladataan...</span></div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container">
            <p>&copy; 2025 Vuoto Oy. Kaikki oikeudet pidätetään.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchConsumptionData() {
            $.ajax({
                // 4 rekisteriä: AAEABA%3D%3D
                // 1 rekisteri: AAEAAQ%3D%3D
                url: '/intra/modbus-api.php?Connection=Zmxvd21ldGVyOjUwMg%3D%3D&Function=4&Data=AAEABA%3D%3D',
                method: 'GET',
                success: function(data) {
                    const response = data; //JSON.parse(data);
                    const consumption = response.values[0]; // Assuming the first value is the consumption
                    $('#consumption-value').text(consumption + ' l/s');
                    $('#pressure-value').text(response.values[1]/10 + ' bar');
                    // Update meter
                    const ctx = document.getElementById('meter').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Kulutus', 'Kapasiteetti'],
                            datasets: [{
                                data: [consumption, 500 - consumption], // Assuming 1000 is the max value
                                backgroundColor: ['#007bff', '#e9ecef']
                            }]
                        },
                        options: {
                            circumference: Math.PI,
                            rotation: Math.PI,
                            cutoutPercentage: 80,
                            tooltips: { enabled: false },
                            hover: { mode: null },
                            animation: { duration: 0 }
                        }
                    });
                },
                error: function() {
                    $('#consumption-value').text('Virhe ladattaessa tietoja');
                }
            });
        }

        fetchConsumptionData();
        setInterval(fetchConsumptionData, 5000); // Refresh every minute
    });
</script>
</body>
</html>
