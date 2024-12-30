<?php
$servername = "mysql"; // Hostname sesuai dengan nama service di docker-compose
$username = "refosasa"; // Username database
$password = "refosasa"; // Password database
$dbname = "library"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses data jika method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $nim = isset($_POST['nim']) ? $conn->real_escape_string($_POST['nim']) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';

    if (!empty($name) && !empty($nim) && !empty($phone)) {
        // Menggunakan prepared statements untuk keamanan
        $stmt = $conn->prepare("INSERT INTO users (name, nim, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $nim, $phone);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Menutup koneksi
$conn->close();
?>
