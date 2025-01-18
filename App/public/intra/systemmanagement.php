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
        <div class="container my-4">
            <div class="row">
                <h2>Järjestelmän hallinta</h2>
                <p>Tämä on sisäinen järjestelmä, jolla voit hallita käyttöpaikkoja, laskuttaa asiakkaita ja ohjata vesipumppua.</p>
            </div>
            <div class="row my-2">
                <div class="col-md-4">
                    <!-- Pumppu päällä / pois päältä -->
                     <div class="card">
                        <div class="card-header">
                            <h4>Virta</h4>
                     </div>
                     <div class="card-body">
                        <button class="btn btn-success">Päällä</button>
                        <button class="btn btn-danger" disabled>Pois</button>
                     </div>
                     <div class="card-footer">
                        <p>Pumpun kytkeminen päälle tai pois päältä. Edellyttää pumpun etäohjauksen olemista kytkettynä.</p>
                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Etäohjaus päällä / pois päältä -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Etäohjaus</h4>
                     </div>
                     <div class="card-body">
                        <button class="btn btn-success" disabled>Päällä</button>
                        <button class="btn btn-danger">Pois</button>
                     </div>
                     <div class="card-footer">
                        <p>Pumpun etäohjaus on päällä. Etäohjaus ei voi kytkeä päälle etänä mikäli se on poistettu käytöstä.</p>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                    <!-- Turvamoodi päällä / pois päältä -->
                    <div class="card">
                        <div class="card-header">
                            <h4>Turvamoodi</h4>
                     </div>
                     <div class="card-body">
                        <button class="btn btn-success" disabled>Päällä</button>
                        <button class="btn btn-danger">Pois</button>
                     </div>
                     <div class="card-footer">
                        <p>Pumpun turvaohjaus sammuttaa pumpun jos kierrosluku tai vedenkulutus on raja-arvojen yläpuolella.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="row my-2">
                <!-- Hälytykset -->
                <div class="col-md-4">
                    <div class="card">
                        <!--- Ylikuumenimen -->
                        <div class="card-header">
                            <h4>Ylikuumenimen</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Hälytys</strong>
                                </div>
                            </div>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Normaali</strong>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Hyälytys ilmaisee onko pumppu ylikuumentunut.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <!--- Vuoto -->
                        <div class="card-header">
                            <h4>Vuoto</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Hälytys</strong>
                                </div>
                            </div>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Normaali</strong>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Hyälytys ilmaisee onko veden kulutus raja-arvojen yli.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <!--- Paine -->
                        <div class="card-header">
                            <h4>Paine</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Hälytys</strong>
                                </div>
                            </div>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle fa-2x mr-3 px-2"></i>
                                <div>
                                    <strong>Normaali</strong>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Hyälytys ilmaisee onko verkoston paina raja-arvojen ulkopuolella.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row my-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kulutus</h4>
                        </div>
                        <div class="card-body">
                            <p>1000 m³</p>
                        </div>
                        <div class="card-footer">
                            <p>Veden kulutus (l/s)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Paine</h4>
                        </div>
                        <div class="card-body">
                            <p>3 bar</p>
                        </div>
                        <div class="card-footer">
                            <p>Veden paine (bar)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lämpötila</h4>
                        </div>
                        <div class="card-body">
                            <p>48 C</p>
                        </div>
                        <div class="card-footer">
                            <p>Pumpun lämpötila</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kierrosluku</h4>
                        </div>
                        <div class="card-body">
                            <p>3254 RPM</p>
                        </div>
                        <div class="card-footer">
                            <p>Pumpun kierrosluku</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
<?php include 'footer.php'; ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
