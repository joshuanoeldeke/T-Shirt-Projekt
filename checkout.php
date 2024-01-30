<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "silkskull";

// Erstellen Sie eine Verbindung
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $firstname = $data['Vorname'];
    $lastname = $data['Nachname'];
    $email = $data['email'];
    $street = $data['Straße'];
    $city = $data['Ort'];
    $postalcode = $data['PLZ'];
    $cart = $data['cart'];

    // Fügen Sie die Kundendaten in Ihre Datenbank ein
    $sql = "INSERT INTO adress (firstname, lastname, street, city, postalcode)
    VALUES ('$firstname', '$lastname', '$street', '$city', '$postalcode')";

    if ($conn->query($sql) === TRUE) {
        $adress_id = $conn->insert_id;
        echo "Neuer Eintrag erfolgreich erstellt";
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }

    // Fügen Sie die Bestelldaten in Ihre Datenbank ein
    $sql = "INSERT INTO order_table (adress_id, date)
    VALUES ('$adress_id', NOW())";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;
        echo "Neuer Eintrag erfolgreich erstellt";
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }

    // Fügen Sie die Warenkorbdaten in Ihre Datenbank ein
    foreach ($cart as $item) {
        $product = $item['product'];
        $name = $item['name'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $id = $item['id'];

        // Fügen Sie die Produktdaten in Ihre Datenbank ein
        $sql = "INSERT INTO products (id, title, price, image)
        VALUES ('$id', '$name', '$price', '$product')";

        if ($conn->query($sql) === TRUE) {
            echo "Neuer Eintrag erfolgreich erstellt";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }

        $sql = "INSERT INTO order_products (order_id, product_id, amount)
        VALUES ('$order_id', '$id', '$quantity')";

        if ($conn->query($sql) === TRUE) {
            echo "Neuer Eintrag erfolgreich erstellt";
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
