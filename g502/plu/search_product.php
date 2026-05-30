<?php
require_once '../config/db.php';

if (isset($_GET['query'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['query']);
    
    // We search by 'codigo' (your PLU) or 'nombre' (the name)
    $sql = "SELECT codigo, nombre FROM panaderia 
            WHERE codigo LIKE '%$searchTerm%' OR nombre LIKE '%$searchTerm%' 
            LIMIT 6";
    
    $result = $conn->query($sql);
    $suggestions = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'plu' => $row['codigo'],
                'name' => $row['nombre']
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($suggestions);
}