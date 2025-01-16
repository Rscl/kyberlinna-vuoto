<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');

require_once '../db.php'; // Include your database connection file
// Autoload
require '../vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;


function getCustomerDetails($conn, $customer_id) {
    $sql = "SELECT name, address, zipcode FROM customers WHERE customerid = '" . $customer_id . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // print row content
    return $row;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process'])) {
    $bill_id = $_POST['bill_id'];

    // Hae laskun tiedot tietokannasta
    $sql = "SELECT * FROM billing WHERE id = ".$bill_id;
    $result = $conn->query($sql);
    $bill = $result->fetch_assoc();

    if ($bill) {
        // Hae asiakastiedot
        $customer_id = $bill['customer_id'];
        $customer = getCustomerDetails($conn, $customer_id);

        // Luo PDF
        
        $dompdf = new Dompdf();
        $html = "
            <h3>Lasku</h3>
            <p>Laskutuspäivä: ".date('d.m.Y')."</p>
            <p>Yritys: Vuoto Oy</p>
            <p>Y-tunnus: 1234567-8</p>
            <p>Osoite: Vuototie 1, 39250 Kyberlinna</p>
            <hr>
            <p>Asiakas: {$customer['name']}</p>
            <p>Osoite: {$customer['address']}</p>
            <p>Postinumero: {$customer['zipcode']}</p>
            <p>Laskunumero: $bill_id</p>
            <p>Asiakasnumero: $customer_id</p>
            <p>Määrä: <b>{$bill['amount']} €</b></p>
            <p>Eräpäivä: ".date('d.m.Y', strtotime('+14 days'))."</p>
            <p>Viitenumero: 1232534".$bill_id."</p>
            <hr>
        ";

        // Päivitä laskun tila
        $sql = "UPDATE billing SET processed = 1 WHERE id = '$bill_id'";
        $conn->query($sql);

        $sql = "UPDATE billing SET path = 1 WHERE id = '$filename'";
        $conn->query($sql);

        $filename = "Vuoto-Lasku-$bill_id.pdf";
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($filename);

        // Tallenna PDF
        $output = $dompdf->output();
        file_put_contents($filename, $output);
        exit;
    } else {
        echo "Laskua ei löytynyt.";
    }
} else {
    echo "Virheellinen pyyntö.";
}
?>
