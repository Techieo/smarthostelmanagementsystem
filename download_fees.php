<?php
if(isset($_POST['room_type'])) {
    $room = $_POST['room_type'];

    // Fees structure (you can customize)
    $fees = [
        'hex' => 'Hex Room Rent: KES 10,000 per month',
        'twin' => 'Twin Room Rent: KES 7,000 per month',
        'quad' => 'Quad Room Rent: KES 5,000 per month',
    ];

    if(array_key_exists($room, $fees)) {
        // Set headers to force download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="rent_details.txt"');
        echo $fees[$room];
        exit;
    } else {
        echo "Invalid room type selected.";
    }
} else {
    echo "No room type selected.";
}
