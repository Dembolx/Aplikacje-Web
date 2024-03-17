<?php
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

    if ($conn->connect_error){
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    if(isset($_POST['submit'])){

        // Pobranie danych z formularza
        $imie = isset($_POST['imie']) ? $_POST['imie'] : '';
        $nazwisko = isset($_POST['nazwisko']) ? $_POST['nazwisko'] : '';
        $ojciec = isset($_POST['ojciec']) ? $_POST['ojciec'] : '';
        $data_ur = isset($_POST['data_ur']) ? $_POST['data_ur'] : '';
        $gdzie = isset($_POST['gdzie']) ? $_POST['gdzie'] : '';
        $pesel = isset($_POST['pesel']) ? $_POST['pesel'] : '';
        $adres = isset($_POST['adres']) ? $_POST['adres'] : '';
        $numer_k = isset($_POST['numer_k']) ? $_POST['numer_k'] : '';
        $kurs = isset($_POST['kurs']) ? $_POST['kurs'] : '';
        $rozszerzenie = isset($_POST['rozszerzenie']) ? $_POST['rozszerzenie'] : '';
        $rok = isset($_POST['rok']) ? $_POST['rok'] : '';
        $oddzial = isset($_POST['oddzial']) ? $_POST['oddzial'] : '';
        $rozpoczecie = isset($_POST['rozpoczecie']) ? $_POST['rozpoczecie'] : '';
        $zakonczenie = isset($_POST['zakonczenie']) ? $_POST['zakonczenie'] : '';
        $egzamin = isset($_POST['egzamin']) ? $_POST['egzamin'] : '';
        $protokol = isset($_POST['protokol']) ? $_POST['protokol'] : '';
        $numer_zas = isset($_POST['numer_zas']) ? $_POST['numer_zas'] : '';
        $e_mail = isset($_POST['e_mail']) ? $_POST['e_mail'] : '';
        $index_ = isset($_POST['index_']) ? $_POST['index_'] : '';
        $telefon = isset($_POST['telefon']) ? $_POST['telefon'] : '';
        $skierowanie = isset($_POST['skierowanie']) ? $_POST['skierowanie'] : '';
        $powiat = isset($_POST['powiat']) ? $_POST['powiat'] : '';
        $index_kursu = isset($_POST['index_kursu']) ? $_POST['index_kursu'] : '';
        $uwagi = isset($_POST['uwagi']) ? $_POST['uwagi'] : '';
        $nr_usera = isset($_POST['nr_usera']) ? $_POST['nr_usera'] : '';


        // Sprawdzenie czy pola wymagane są wypełnione
        $bledy = [];

        if(empty($imie)) {
            $bledy['imie'] = "Pole 'Imie' jest wymagane.";
        } 
        
        if(empty($nazwisko)) {
            $bledy['nazwisko'] = "Pole 'Nazwisko' jest wymagane.";
        }
        
        if(empty($ojciec)) {
            $bledy['ojciec'] = "Pole 'Ojciec' jest wymagane.";
        }
        
        if(empty($data_ur)) {
            $bledy['data_ur'] = "Pole 'Data urodzenia' jest wymagane.";
        }
        
        if(empty($pesel)) {
            $bledy['pesel'] = "Pole 'PESEL' jest wymagane.";
        }
        
        if(empty($numer_k)) {
            $bledy['numer_k'] = "Pole 'Numer K.' jest wymagane.";
        }
        
        if(empty($kurs)) {
            $bledy['kurs'] = "Pole 'Kurs' jest wymagane.";
        }
        
        if(empty($rozszerzenie)) {
            $bledy['rozszerzenie'] = "Pole 'Rozszerzenie' jest wymagane.";
        }
        
        if(empty($rok)) {
            $bledy['rok'] = "Pole 'Rok' jest wymagane.";
        }
        
        if(empty($oddzial)) {
            $bledy['oddzial'] = "Pole 'Oddział' jest wymagane.";
        }
        
        if(empty($egzamin)) {
            $bledy['egzamin'] = "Pole 'Egzamin' jest wymagane.";
        }
        
        if(empty($numer_zas)) {
            $bledy['numer_zas'] = "Pole 'Numer zaś.' jest wymagane.";
        }
        
        if(empty($index_kursu)) {
            $bledy['index_kursu'] = "Pole 'Index kursu' jest wymagane.";
        }
        
        if(empty($nr_usera)) {
            $bledy['nr_usera'] = "Pole 'ID Usera' jest wymagane.";
        }
        

        // Jeśli nie ma błędów, dodaj dane do bazy
        if(empty($bledy)){

            $sqlInsert = "INSERT INTO `absolwenci` VALUES (NULL,'$imie', 
                    '$nazwisko', '$ojciec', '$data_ur', '$gdzie', '$pesel', 
                    '$adres', '$numer_k', '$kurs', '$rozszerzenie', '$rok', 
                    '$oddzial', '$rozpoczecie', '$zakonczenie', '$egzamin', 
                    '$protokol', '$numer_zas', '$e_mail', '$index_', '$telefon', 
                    '$skierowanie', '$powiat', '$index_kursu', '$uwagi', 
                    '$nr_usera')";

            if ($conn->query($sqlInsert) === TRUE) {
                echo "<script>alert('Absolwent zosyał dodany');</script>";
            } else {
                echo "<script>alert('Błąd');</script>";
            }
        }
    }

    $sql = "SHOW GRANTS FOR '$username'@'localhost'";

    // Wykonaj zapytanie
    $result = $conn->query($sql);

    // Inicjalizuj pustą tablicę na uprawnienia
    $privileges = array();

    // Sprawdź czy zapytanie się udało
    if ($result) {
        // Przetwórz wyniki zapytania
        while ($row = $result->fetch_assoc()) {
            // Pobierz uprawnienia z wyników zapytania
            $grant = $row['Grants for ' . $username . '@localhost'];
            
            // Dodaj uprawnienia do tablicy
            $privileges[] = $grant;
        }

        // Sprawdź, czy użytkownik ma uprawnienie do aktualizacji (Update)
        $canInsert = false;
        foreach ($privileges as $privilege) {
            if (strpos($privilege, "INSERT") !== false) {
                $canInsert = true;
            }
        }
    }

    $stanowisko = "";
    $nazwisko ="";
    $sqlUser = "SELECT nazwa_uzytkownika, stanowisko, nazwisko FROM uzytkownicy WHERE nazwa_uzytkownika='$username' AND haslo='$password';";
    $resultsql = $conn->query($sqlUser);

    // Sprawdzenie czy wynik zapytania jest niepusty
    if ($resultsql->num_rows > 0) {
        // Pobranie danych i zapisanie ich do zmiennej
        $row = $resultsql->fetch_assoc();
        $stanowisko = $row['stanowisko'];
        $nazwisko = $row['nazwisko'];
    }

    if(strtolower($stanowisko) == "administrator"){
        $pierwszy_znak = strtoupper(substr($username, 0, 1) . substr($nazwisko, 0, 1));
    }

    $conn->close();
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="obrazy/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <title>Inter-Wiedza</title>
</head>
<body>

    <header>
        <div></div>
        <div class="header-item">
            <h1> Wpisz Absolwenta </h1>
        </div>
        <div id="profil">
            <div class="dropdown">
                <button class="dropbtn"><img src="obrazy/profil.png" alt=""></button>
                <div class="dropdown-content">
                    <a href="#"><?= $username ?></a>
                    <a href="#"><?= $stanowisko ?></a>
                    <a href="index.php">Wyloguj</a>
                </div>
            </div>
        </div>
    </header>

    <nav>
        <section id="lewy">
            <a href="Szukaj.php" class="link">Szukaj</a>
        </section>

        <section id="prawy">
            <a href="Wpisz.php" class="link">Wpisz</a>
        </section>
    </nav>

    <!-- Wprowadzanie Absolwentów -->

    <main>
        <h1> Wpisz Absolwenta </h1>
        <form action="Wpisz.php" method="post">  

            <!-- Przyciski "Wpisz" i "Wyczyść" -->
            <form action="Szukaj.php" method="post">

            <section id="dodatkowe_inf">

                <h2>Dodatkowe</h2>

                Gdzie: <input type="text" name="gdzie"> <br>

                Adres: <input type="text" name="adres"> <br>

                Rozpoczęcie: <input type="date" name="rozpoczecie"> <br>

                Zakończenie: <input type="date" name="zakonczenie"> <br>

                Protokół: <input type="text" name="protokol"> <br>

                E-mail: <input type="email" name="e_mail"> <br>

                Index: 
                <select name="index_">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select> <br>

                Telefon: <input type="tel" name="telefon"> <br>

                Skierowanie: <input type="text" name="skierowanie"> <br>

                Powiat: <input type="text" name="powiat"> <br>

                Uwagi: <input type="text" name="uwagi"> <br>

            </section>

            <section id="niezbedne_inf">

                <h2> Niezbędne Informacje </h2> 

                Imie: <input type="text" name="imie" id="imie"> <br>
                
                Nazwisko: <input type="text" name="nazwisko" id="nazwisko">  <br>
                
                Ojciec: <input type="text" name="ojciec" id="ojciec">  <br>
                
                Data urodzenia: <input type="date" name="data_ur" id="data_ur">  <br>
                
                PESEL: <input type="text" name="pesel" id="pesel">  <br>
                
                Numer K.: <input type="text" name="numer_k" id="numer_k">  <br>
                
                Kurs: <input type="text" name="kurs" id="kurs">  <br>
                
                Rozszerzenie: <input type="text" name="rozszerzenie" id="rozszerzenie">  <br>
                
                Rok: <input type="number" name="rok" id="rok">  <br>
                
                Oddział: 
                <select name="oddzial" id="oddzial">
                    <option value="Opole">Opole</option>
                    <option value="Nysa">Nysa</option>
                    <option value="Częstochowa">Częstochowa</option>
                </select><br>

                Egzamin: <input type="date" name="egzamin" id="egzamin">  <br>
                
                Numer zaś.: <input type="number" name="numer_zas" id="numer_zas">  <br>
                
                Index kursu: <input type="text" name="index_kursu" id="index_kursu">  <br>
                
                ID Usera: <input type="text" name="nr_usera">  <br>
                
            </section>

            <!-- Pole numerowe dla ilości formularzy -->

            <input type="submit" name="submit" value="Wpisz" id="Wpisz">
            <input type="button" value="Wyczyść" onclick="clearForm()" id="button">

        </form>
    </main>

    <script>
        let canInsert = <?php echo json_encode($canInsert); ?>;

        // Jeśli użytkownik nie ma uprawnień do aktualizacji, usuń przycisk edycji
        if (!canInsert) {
            // Pobierz wszystkie przyciski o danym ID
            const buttons = document.querySelectorAll('#Wpisz');

            // Iteruj przez każdy przycisk i zmień jego styl
            buttons.forEach(button => {
                button.style.color = 'white'; // Zmień kolor na czerwony (przykładowy styl)
                button.style.backgroundColor = 'red'; // Zmień kolor tła na żółty (przykładowy styl)
                button.textContent = "Nie masz uprawnień";
                button.disabled = true;
            });
        }

        function clearForm() {
        // Znajdź wszystkie pola formularza
        const formFields = document.querySelectorAll('form input, form select, form textarea');

        // Przypisz puste wartości do każdego pola
        formFields.forEach(field => {
            if (field.type === 'submit' || field.type === 'button') {
                field.checked = false; // Dla checkboxów i radio buttonów
            } else {
                field.value = ''; // Dla wszystkich innych pól
            }
        });
        } 
    </script>
       
    
</body>
</html>
