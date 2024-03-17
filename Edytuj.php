<?php
// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "inter-wiedza");

// Rozpocznij sesję

session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    // Uzyskaj dane użytkownika z sesji
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}

$conn = new mysqli("localhost", "$username", "$password", "inter-wiedza");

// Sprawdzenie, czy formularz został wysłany
if(isset($_POST['edytuj']) && isset($_POST['id'])) {
    // Pobranie danych z formularza
    $id = $_POST['id'];
    // Pobranie danych do edycji na podstawie id
    $sql = "SELECT * FROM `absolwenci` WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Edycja Absolwenta</title>
</head>
<body>
    <h1>Edycja Absolwenta</h1>

    <form action="Aktualizuj.php" method="post">
        <!-- Ukryte pole z id -->
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <section id="dodatkowe_inf">

            <h2>Dodatkowe</h2>

            Gdzie: <input type="text" name="gdzie" value="<?= $row['gdzie'] ?>"> <br>
            Adres: <input type="text" name="adres" value="<?= $row['adres'] ?>"> <br>
            Rozpoczęcie: <input type="date" name="rozpoczecie" value="<?= $row['rozpoczęcie'] ?>"> <br>
            Zakończenie: <input type="date" name="zakonczenie" value="<?= $row['zakończenie'] ?>"> <br>
            Protokół: <input type="text" name="protokol"value="<?= $row['protokół'] ?>"> <br>
            E-mail: <input type="email" name="e_mail" value="<?= $row['e_mail'] ?>"> <br>
            Index: 
            <select name="index_" value="<?= $row['index_'] ?>">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select><br>
            Telefon: <input type="tel" name="telefon" value="<?= $row['telefon'] ?>"> <br>
            Skierowanie: <input type="text" name="skierowanie" value="<?= $row['skierowanie'] ?>"> <br>
            Powiat: <input type="text" name="powiat" value="<?= $row['powiat'] ?>"> <br>
            Uwagi: <input type="text" name="uwagi" value="<?= $row['uwagi'] ?>"> <br>

        </section>

        <section id="niezbedne_inf">

            <h2> Niezbędne Informacje </h2>

            Imie: <input type="text" name="imie" id="name" value="<?= $row['imie'] ?>"> <br>
            Nazwisko: <input type="text" name="nazwisko" value="<?= $row['nazwisko'] ?>"> <br>
            Ojciec: <input type="text" name="ojciec" value="<?= $row['ojciec'] ?>"> <br>
            Data urodzenia: <input type="date" name="data_ur" value="<?= $row['data_uro'] ?>"> <br>
            
            PESEL: <input type="text" name="pesel" value="<?= $row['pesel'] ?>"> <br>
            
            Numer K.: <input type="text" name="numer_k" value="<?= $row['numer_k'] ?>"> <br>
            Kurs: <input type="text" name="kurs" value="<?= $row['kurs'] ?>"> <br>
            Rozszerzenie: <input type="text" name="rozszerzenie" value="<?= $row['rozszerzenie'] ?>"> <br>
            Rok: <input type="number" name="rok"value="<?= $row['rok'] ?>"> <br>
            Oddział: 
            <select name="oddzial" value="<?= $row['oddział'] ?>">
                <option value="Opole">Opole</option>
                <option value="Nysa">Nysa</option>
                <option value="Częstochowa">Częstochowa</option>
            </select><br>

            Egzamin: <input type="date" name="egzamin"value="<?= $row['egzamin'] ?>"> <br>
            
            Numer zaś.: <input type="number" name="numer_zas" value="<?= $row['numer_zaś'] ?>"> <br>
            
            Index kursu: <input type="text" name="index_kursu" value="<?= $row['index_kursu'] ?>"> <br>
            
            ID Usera: <input type="text" name="nr_usera" value="<?= $row['id_usera'] ?>"> <br>
        </section>

        <input type="submit" name="zapisz" value="Zapisz zmiany" id="submit">
        <input type="button" value="Wyczyść" onclick="clearForm()" id="button">
        <input type="button" name="powrot" onclick="redirectToPage()" value="Powrót" id="button">
    </form>
</body>

<script>
        function clearForm() {
        // Znajdź wszystkie pola formularza
        const formFields = document.querySelectorAll('form input, form select, form textarea');

        // Przypisz puste wartości do każdego pola
        formFields.forEach(field => {
            if (field.type === 'button' || field.type === 'submit') {
                field.checked = false; // Dla checkboxów i radio buttonów
            } else {
                field.value = ''; // Dla wszystkich innych pól
            }
        });
}
    function redirectToPage() {
        window.location.href = "http://localhost/aplikacja%20web/Szukaj.php"; // Ustawia adres URL strony
    }
    </script>
    
</html>
<?php
    } else {
        echo "Nie znaleziono rekordu do edycji.";
    }
}

// Zamknięcie połączenia
$conn->close();
?>
