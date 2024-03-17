<?php
// Połączenie z bazą danych
@ $conn = new mysqli("localhost", "root", "", "inter-wiedza");
if(isset($_POST['submit'])){

    // Pobranie danych z formularza
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $haslo = $_POST['haslo'];
    $stanowisko = $_POST['stanowisko'];

    // Automatyczne ustawienie uprawnień w zależności od stanowiska
    switch ($stanowisko) {
        case 'administrator':
            $uprawnienia = array("INSERT", "DELETE", "UPDATE", "SELECT");
            break;
        case 'pracownik':
            $uprawnienia = array("DELETE", "SELECT", "UPDATE");
            break;
        case 'stażysta':
            $uprawnienia = array("SELECT", "UPDATE");
            break;
        default:
            $uprawnienia = array("SELECT"); // Domyślne uprawnienia
            break;
    }

    // Wstawienie użytkownika do tabeli 'uzytkownicy'
    $sql = "INSERT INTO uzytkownicy VALUES (NULL ,'$imie', '$haslo', '" . implode(",", $uprawnienia) . "', '$stanowisko', '$nazwisko')";
    if ($conn->query($sql) === TRUE) {

        // Utworzenie użytkownika i nadanie uprawnień
        $nazwa_uzytkownika = $imie; // Nazwa użytkownika jest ustawiona na małe litery od imienia i nazwiska 
        $sqlCreateUser = "CREATE USER '$nazwa_uzytkownika'@'localhost' IDENTIFIED BY '$haslo'";
        $conn->query($sqlCreateUser);

        foreach ($uprawnienia as $uprawnienie) {
            $sqlGrantPermission = "GRANT $uprawnienie ON `inter-wiedza`.* TO '$nazwa_uzytkownika'@'localhost'";
            $conn->query($sqlGrantPermission);
        }

        header("Location: http://localhost/aplikacja%20web/index.php");
        exit();
    } 

    
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/rejestracja.css">
    <title>Formularz Rejestracyjny</title>
  </head>
  <body>
    <h2>Formularz Rejestracyjny</h2>
    <form action="rejestracja.php" method="post">
      <label for="imie">Imię:</label>
      <input type="text" id="imie" name="imie" required /><br /><br />

      <label for="nazwisko">Nazwisko:</label>
      <input type="text" id="nazwisko" name="nazwisko" required /><br /><br />

      <label for="haslo">Hasło:</label>
      <input type="password" id="haslo" name="haslo" required /><br /><br />

      <label for="stanowisko">Stanowisko:</label>
      <select id="stanowisko" name="stanowisko">
        <option value="pracownik">Pracownik</option>
        <option value="stażysta">Stażysta</option>
        <option value="administrator">Administrator</option>
      </select>
      
      <br /><br />

      <input type="submit" name="submit" value="Zarejestruj" />
    </form>
  </body>
</html>
