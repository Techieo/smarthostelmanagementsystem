<?php
include 'session_check.php';
include 'db_connect.php';

// Filters
$room_number = $_GET['room_number'] ?? '';
$room_type = $_GET['room_type'] ?? '';
$status_filter = $_GET['status_filter'] ?? '';

// Build query
$sql = "SELECT r.room_id, r.room_number, r.type, r.room_type, r.status, r.capacity,
               COUNT(b.booking_id) AS occupants
        FROM rooms r
        LEFT JOIN bookings b ON r.room_id = b.room_id AND b.status='active'
        WHERE 1=1";

if (!empty($room_number)) {
    $sql .= " AND r.room_number LIKE '%$room_number%'";
}
if (!empty($room_type)) {
    $sql .= " AND r.type='$room_type'";
}
if (!empty($status_filter)) {
    $sql .= " AND r.status='$status_filter'";
}

$sql .= " GROUP BY r.room_id ORDER BY r.room_number ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $occupants = $row['occupants'];
        $capacity = $row['capacity'];

        // Determine display status
        if ($status == 'maintenance') {
            $display_status = 'Maintenance';
        } elseif ($occupants == 0) {
            $display_status = 'Available';
        } elseif ($occupants < $capacity) {
            $slots = $capacity - $occupants;
            $display_status = "Available ($slots slot" . ($slots > 1 ? 's' : '') . ")";
        } else {
            $display_status = 'Occupied';
        }

        echo "<tr>
                <td>{$row['room_number']}</td>
                <td>{$row['type']}</td>
                <td>{$row['room_type']}</td>
                <td>{$display_status}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No rooms found matching your criteria.</td></tr>";
}
?>
