<?php

require_once('Tinkerforge/IPConnection.php');
require_once('Tinkerforge/BrickIMUV2.php');

use Tinkerforge\IPConnection;
use Tinkerforge\BrickIMUV2;

const HOST = 'localhost';
const PORT = 4223;
const UID = 'XXYYZZ'; // Change XXYYZZ to the UID of your IMU Brick 2.0

// Callback function for quaternion callback
function cb_quaternion($w, $x, $y, $z)
{
    echo "Quaternion [W]: " . $w/16383.0 . "\n";
    echo "Quaternion [X]: " . $x/16383.0 . "\n";
    echo "Quaternion [Y]: " . $y/16383.0 . "\n";
    echo "Quaternion [Z]: " . $z/16383.0 . "\n";
    echo "\n";
}

$ipcon = new IPConnection(); // Create IP connection
$imu = new BrickIMUV2(UID, $ipcon); // Create device object

$ipcon->connect(HOST, PORT); // Connect to brickd
// Don't use device before ipcon is connected

// Register quaternion callback to function cb_quaternion
$imu->registerCallback(BrickIMUV2::CALLBACK_QUATERNION, 'cb_quaternion');

// Set period for quaternion callback to 0.1s (100ms)
$imu->setQuaternionPeriod(100);

echo "Press ctrl+c to exit\n";
$ipcon->dispatchCallbacks(-1); // Dispatch callbacks forever

?>
