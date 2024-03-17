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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sprawdzenie, czy formularz został wysłany
if(isset($_POST['zapisz']) && isset($_POST['id'])) {
    // Pobranie danych z formularza
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $ojciec = $_POST['ojciec'];
    $data_ur = $_POST['data_ur'];
    $gdzie = $_POST['gdzie'];
    $pesel = $_POST['pesel'];
    $adres = $_POST['adres'];
    $numer_k = $_POST['numer_k'];
    $kurs = $_POST['kurs'];
    $rozszerzenie = $_POST['rozszerzenie'];
    $rok = $_POST['rok'];
    $oddzial = $_POST['oddzial'];
    $rozpoczecie = $_POST['rozpoczecie'];
    $zakonczenie = $_POST['zakonczenie'];
    $egzamin = $_POST['egzamin'];
    $protokol = $_POST['protokol'];
    $numer_zas = $_POST['numer_zas'];
    $e_mail = $_POST['e_mail'];
    $index_ = $_POST['index_'];
    $telefon = $_POST['telefon'];
    $skierowanie = $_POST['skierowanie'];
    $powiat = $_POST['powiat'];
    $index_kursu = $_POST['index_kursu'];
    $uwagi = $_POST['uwagi'];
    $nr_usera = $_POST['nr_usera'];

    // Pobranie pozostałych danych z formularza i aktualizacja ich wartości w bazie danych
    // Pamiętaj o odpowiednich nazwach pól w formularzu i kolumnach w bazie danych
    $sql = "UPDATE `absolwenci` SET imie='$imie', 
            nazwisko='$nazwisko', ojciec='$ojciec', 
            data_uro='$data_ur', gdzie='$gdzie', 
            pesel='$pesel', adres='$adres', numer_k='$numer_k',
            kurs='$kurs', rozszerzenie='$rozszerzenie', 
            rok='$rok', oddział='$oddzial', 
            rozpoczęcie='$rozpoczecie', 
            zakończenie='$zakonczenie', egzamin='$egzamin', 
            protokół='$protokol', numer_zaś='$numer_zas', 
            e_mail='$e_mail', index_='$index_', 
            telefon='$telefon', skierowanie='$skierowanie', 
            powiat='$powiat', index_kursu='$index_kursu', 
            uwagi='$uwagi', id_usera='$nr_usera' WHERE id=$id";


    if ($conn->query($sql) === TRUE) {
        echo "Dane zostały zaktualizowane pomyślnie.";
        header("Location: http://localhost/aplikacja%20web/Szukaj.php");
        exit();
    } else {
        echo "Błąd podczas aktualizacji danych: " . $conn->error;
    }
}

// Zamknięcie połączenia
$conn->close();

