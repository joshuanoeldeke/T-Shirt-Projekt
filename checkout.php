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
    $firstname = $_POST["Vorname"];
    $lastname = $_POST["Nachname"];
    $email = $_POST["email"];
    $street = $_POST["Straße"];
    $city = $_POST["Ort"];
    $postalcode = $_POST["PLZ"];
    // Hier können Sie weitere Felder hinzufügen

    $sql = "INSERT INTO Orders (Name, Email)
    VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Neuer Eintrag erfolgreich erstellt";
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
    <p>Produkt: Beispielprodukt</p>
    <p>Preis: $19.99</p>
</section>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h2>Ihre Daten :)</h2>
    <ul>
        <li>              <form action="checkout_process.php" method="post">
                <label for="firstname">Vorname:</label>
                <input type="text" id="firstname" name="firstname" required></li>

        <li>              <form action="checkout_process.php" method="post">
                <label for="lastname">Nachname:</label>
                <input type="text" id="lastname" name="lastname" required></li>

        <li>    <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required></li>
        <li>              <label for="street">Straße mit Hausnummer:</label>
            <input id="street" name="street" required></input></li>
        <li>              <label for="city">Ort:</label>
            <input id="city" name="city" required></input></li>
        <li>              <label for="postalcode">PLZ:</label>
            <input id="postalcode" name="postalcode" required></input></li>
    </ul>
    <input type="submit">
</form>

<footer>
    <p>&copy; 2024 Checkout. Alle Rechte vorbehalten.</p>
</footer>

</body>
</html>