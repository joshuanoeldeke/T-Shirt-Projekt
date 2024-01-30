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

// SQL-Abfrage, um den neuesten Eintrag aus der Tabelle 'cart' zu holen
$sql = "SELECT * FROM cart ORDER BY cart_id DESC LIMIT 1";
$result = $conn->query($sql);

$product_id = "";
$product_name = "";
$product_price = "";
$product_quantity = "";

if ($result->num_rows > 0) {
    // Daten für das neueste Produkt in der Tabelle 'cart' ausgeben
    $row = $result->fetch_assoc();
    $product_id = $row["id"];
    $product_name = $row["name"];
    $product_price = $row["price"];
    $product_quantity = $row["quantity"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $postalcode = $_POST["postalcode"];

    // SQL-Abfrage, um die Daten in die Tabelle 'adress' einzufügen
    $sql = "INSERT INTO adress (email, firstname, lastname, street, city, postalcode)
    VALUES ('$email', '$firstname', '$lastname', '$street', '$city', '$postalcode')";

    if ($conn->query($sql) === TRUE) {
        $adress_id = $conn->insert_id;
        $date = date('Y-m-d H:i:s');

        // SQL-Abfrage, um die Daten in die Tabelle 'order_table' einzufügen
        $sql = "INSERT INTO order_table (adress_id, date)
        VALUES ('$adress_id', '$date')";

        if ($conn->query($sql) === TRUE) {
            $order_id = $conn->insert_id;

            // SQL-Abfrage, um die Daten in die Tabelle 'order_products' einzufügen
            $sql = "INSERT INTO order_products (order_id, product_id, amount)
            VALUES ('$order_id', '$product_id', '$product_quantity')";

            if ($conn->query($sql) === TRUE) {
                echo "Neuer Eintrag erfolgreich erstellt";
            } else {
                echo "Fehler: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Fehler: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Fehler: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            text-align: center;
            background-color: #f2f2f2;
            padding: 10px;
        }
        section {
            margin-top: 20px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<header>
    <h1>Willkommen beim Checkout. Bitte Tragen sie Ihre Daten ein!</h1>
</header>

<section>
    <h2>Produktinformation</h2>
    <p>Name: <?php echo $product_name; ?></p>
    <p>Preis: <?php echo $product_price; ?></p>
    <p>Anzahl: <?php echo $product_quantity; ?></p>
</section>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h2>Ihre Daten :)</h2>
    <ul>
        <li>
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>
        </li>
        <li>
            <label for="firstname">Vorname:</label>
            <input type="text" id="firstname" name="firstname" required>
        </li>
        <li>
            <label for="lastname">Nachname:</label>
            <input type="text" id="lastname" name="lastname" required>
        </li>
        <li>
            <label for="street">Straße:</label>
            <input type="text" id="street" name="street" required>
        </li>
        <li>
            <label for="city">Stadt:</label>
            <input type="text" id="city" name="city" required>
        </li>
        <li>
            <label for="postalcode">Postleitzahl:</label>
            <input type="text" id="postalcode" name="postalcode" required>
        </li>
    </ul>
    <input type="submit" value="Absenden">
</form>

<footer>
    <p>© 2024 Checkout. Alle Rechte vorbehalten.</p>
</footer>

</body>
</html>
