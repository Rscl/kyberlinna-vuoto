<?php
if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}
// Modbus API handler
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get parameters
    $connection = filter_input(INPUT_GET, 'Connection') ?? filter_input(INPUT_POST, 'Connection');
    $function = filter_input(INPUT_GET, 'Function') ?? filter_input(INPUT_POST, 'Function');
    $data = filter_input(INPUT_GET, 'Data') ?? filter_input(INPUT_POST, 'Data');

    // Validate parameters
    if (!$connection || !$function) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid or missing parameters.', 'connection' => $connection, 'function' => $function]);
        exit;
    }

    try {
        // Decode the connection parameter (Base64 -> "ip:port")
        $decodedConnection = base64_decode($connection);

        [$ip, $port] = explode(':', $decodedConnection);

        // Decode the data parameter (if provided)
        $decodedData = $data ? base64_decode($data) : null;

        // Connect to the Modbus server
        $response = handleModbusRequest($ip, (int)$port, $function, $decodedData);

        // Skip modbus header
        if (!$response) {
            throw new Exception('No valid response from Modbus server.');
        }
        $hex = bin2hex($response);
        // Check modbus transaction id
        $transactionId = unpack('n', substr($response, 0, 2))[1];
        $protocolId = unpack('n', substr($response, 2, 2))[1];
        $messageLength = unpack('n', substr($response, 4, 2))[1];
        $message = substr($response,9);
        $deviceId = unpack('C', substr($response, 6, 1))[1];
        $functionCode = unpack('C', substr($response, 7, 1))[1];
        $byteCount = unpack('C', substr($response, 8, 1))[1];

        $values = [];
        for ($i = 0; $i < $byteCount; $i += 2) {
            $values[] = unpack('n', substr($message, $i, 2))[1];
        }


        // Return response
        echo json_encode(['status' => 'success',
        'hex' => $hex,
        'transactionId' => $transactionId,
        'protocolId' => $protocolId,
        'messageLength' => $messageLength,
        'deviceId' => $deviceId,
        'functionCode' => $functionCode,
        'byteCount' => $byteCount,
        'values' => $values]);
    } catch (Exception $e) {
        // Handle errors
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(405); // Method not allowed
    echo json_encode(['error' => 'Method not allowed. Use GET or POST.']);
    exit;
}

/**
 * Handle Modbus request.
 *
 * @param string $ip
 * @param int $port
 * @param int $function
 * @param string|null $data
 * @return string
 */
function handleModbusRequest(string $ip, int $port, int $function, ?string $data): string
{
    // Implement the logic to connect to a Modbus server and send/receive data
    // You might need to use a library like PHPModbus or implement your own Modbus client.

    // Example pseudo-logic:
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (!$socket) {
        throw new Exception('Failed to create socket.');
    }

    if (!socket_connect($socket, $ip, $port)) {
        throw new Exception('Failed to connect to Modbus client: ' . $ip . ':' . $port);
    }

    // Build Modbus request packet
    $request = buildModbusPacket($function, $data);
    if (!socket_write($socket, $request, strlen($request))) {
        throw new Exception('Failed to send data to Modbus client.');
    }

    // Read response
    $response = socket_read($socket, 1024); // Adjust buffer size as needed
    if ($response === false) {
        throw new Exception('Failed to read response from Modbus server.');
    }

    socket_close($socket);

    return $response;
}

/**
 * Build Modbus packet.
 *
 * @param int $function
 * @param string|null $data
 * @return string
 */
function buildModbusPacket(int $function, ?string $data): string
{
    // Construct the Modbus request packet based on the function code and data
    // This is placeholder logic and should be replaced with actual packet construction
    $transactionId = 1;//random_int(0, 65535);
    $protocolId = 0;
    $length = 2 + ($data ? strlen($data) : 0);
    $unitId = 1; // Default unit ID
    // Build the packet header
    $header = pack('nnnCC', $transactionId, $protocolId, $length, $unitId, $function);

    // Add the function code and data
    return $header . ($data ?? '');
}
