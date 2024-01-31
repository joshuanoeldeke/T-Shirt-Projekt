<?php
// Starten Sie die Session
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "silkskull";

// Erstellen Sie eine Verbindung
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Überprüfen Sie die Verbindung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL-Abfrage, um den Benutzernamen und das Passwort zu überprüfen
    $sql = "SELECT * FROM user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Der Benutzer ist eingeloggt
        $_SESSION['loggedin'] = true;

        // Leiten Sie den Benutzer zur gleichen Seite um, um das Formular zu aktualisieren
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        // Falsche Anmeldedaten
        echo "Falscher Benutzername oder Passwort.";
    }

    $stmt->close();
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // SQL-Abfrage, um die Daten aus dem View 'OrderOverview' abzurufen
    $sql = "SELECT * FROM OrderOverview";
    $result = $conn->query($sql);

    echo "<table border='1'>";
    echo "<tr><th>Order ID</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total Price</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Street</th><th>City</th><th>Postal Code</th></tr>";

    if ($result->num_rows > 0) {
        // Daten für jede Bestellung ausgeben
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["order_id"] . "</td>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "<td>" . $row["total_price"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["firstname"] . "</td>";
            echo "<td>" . $row["lastname"] . "</td>";
            echo "<td>" . $row["street"] . "</td>";
            echo "<td>" . $row["city"] . "</td>";
            echo "<td>" . $row["postalcode"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "Keine Ergebnisse gefunden";
    }

    echo "</table>";
} else {
    // Zeigen Sie das Login-Formular an
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<label for="username">Benutzername:</label>';
    echo '<input type="text" id="username" name="username" required>';
    echo '<label for="password">Passwort:</label>';
    echo '<input type="password" id="password" name="password" required>';
    echo '<input type="submit" value="Anmelden">';
    echo '</form>';
}

$conn->close();
?>
