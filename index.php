<?php
session_start();

// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "inter-wiedza");

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Sprawdzenie, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Zabezpieczenie przed atakami SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Zapytanie SQL sprawdzające istnienie użytkownika w bazie danych
    $query = "SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika='$username' AND haslo='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Zapisz dane użytkownika w sesji
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;


        header("Location: Szukaj.php"); // Przekierowanie do strony witającej
        exit();
    } else {
        // Użytkownik nie został uwierzytelniony
        echo "Błędna nazwa użytkownika lub hasło.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/logowanie.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Nazwa użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Zaloguj">
    </form>
    <a href="rejestracja.php">Zarejestruj się</a>
</body>
</html>

