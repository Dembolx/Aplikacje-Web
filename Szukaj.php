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
		die($conn->connect_error);
	}

    // Zapytanie SQL, aby uzyskać uprawnienia użytkownika
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
        $canUpdate = false;
        $canDelete = false;
        $canSelect = false;
        foreach ($privileges as $privilege) {
            if (strpos($privilege, "UPDATE") !== false) {
                $canUpdate = true;
            }
            if (strpos($privilege, "DELETE") !== false) {
                $canDelete = true;
            }
            if (strpos($privilege, "SELECT") !== false) {
                $canSelect = true;
            }
        }
    }

    # Select

    $sqlSelect = "SELECT * FROM `absolwenci` where 1";

    # Filtrowanie

    if(isset($_POST['submit'])) {
    
        // Sprawdź każde pole formularza i dodaj warunek do zapytania SQL
        
        if(!empty($_POST['imie'])) {
            $imie = $_POST['imie'];
            $sqlSelect .= " AND absolwenci.imie = '$imie'";
        } 
        if(!empty($_POST['nazwisko'])) {
            $nazwisko = $_POST['nazwisko'];
            $sqlSelect .= " AND absolwenci.nazwisko = '$nazwisko'";
        }
        if(!empty($_POST['ojciec'])) {
            $ojciec = $_POST['ojciec'];
            $sqlSelect .= " AND absolwenci.ojciec = '$ojciec'";
        }
        if(!empty($_POST['data_ur'])) {
            $data_ur = $_POST['data_ur'];
            $sqlSelect .= " AND absolwenci.data_uro = '$data_ur'";
        }
        if(!empty($_POST['gdzie'])) {
            $gdzie = $_POST['gdzie'];
            $sqlSelect .= " AND absolwenci.gdzie = '$gdzie'";
        }
        if(!empty($_POST['pesel'])) {
            $pesel = $_POST['pesel'];
            $sqlSelect .= " AND absolwenci.pesel = '$pesel'";
        }
        if(!empty($_POST['adres'])) {
            $adres = $_POST['adres'];
            $sqlSelect .= " AND absolwenci.adres = '$adres'";
        }
        if(!empty($_POST['numer_k'])) {
            $numer_k = $_POST['numer_k'];
            $sqlSelect .= " AND absolwenci.numer_k = '$numer_k'";
        }
        if(!empty($_POST['kurs'])) {
            $kurs = $_POST['kurs'];
            $sqlSelect .= " AND absolwenci.kurs = '$kurs'";
        }
        if(!empty($_POST['rozszerzenie'])) {
            $rozszerzenie = $_POST['rozszerzenie'];
            $sqlSelect .= " AND absolwenci.rozszerzenie = '$rozszerzenie'";
        }
        if(!empty($_POST['rok'])) {
            $rok = $_POST['rok'];
            $sqlSelect .= " AND absolwenci.rok = '$rok'";
        }
        if(!empty($_POST['oddzial'])) {
            $oddzial = $_POST['oddzial'];
            $sqlSelect .= " AND absolwenci.oddział = '$oddzial'";
        }
        if(!empty($_POST['rozpoczecie'])) {
            $rozpoczecie = $_POST['rozpoczecie'];
            $sqlSelect .= " AND absolwenci.rozpoczęcie = '$rozpoczecie'";
        }
        if(!empty($_POST['zakonczenie'])) {
            $zakonczenie = $_POST['zakonczenie'];
            $sqlSelect .= " AND absolwenci.zakończenie = '$zakonczenie'";
        }
        if(!empty($_POST['egzamin'])) {
            $egzamin = $_POST['egzamin'];
            $sqlSelect .= " AND absolwenci.egzamin = '$egzamin'";
        }
        if(!empty($_POST['protokol'])) {
            $protokol = $_POST['protokol'];
            $sqlSelect .= " AND absolwenci.protokół = '$protokol'";
        }
        if(!empty($_POST['numer_zas'])) {
            $numer_zas = $_POST['numer_zas'];
            $sqlSelect .= " AND absolwenci.numer_zaś = '$numer_zas'";
        }
        if(!empty($_POST['e_mail'])) {
            $e_mail = $_POST['e_mail'];
            $sqlSelect .= " AND absolwenci.e_mail = '$e_mail'";
        }
        if(!empty($_POST['index_'])) {
            $index_ = $_POST['index_'];
            $sqlSelect .= " AND absolwenci.index_ = '$index_'";
        }
        if(!empty($_POST['telefon'])) {
            $telefon = $_POST['telefon'];
            $sqlSelect .= " AND absolwenci.telefon = '$telefon'";
        }
        if(!empty($_POST['skierowanie'])) {
            $skierowanie = $_POST['skierowanie'];
            $sqlSelect .= " AND absolwenci.skierowanie = '$skierowanie'";
        }
        if(!empty($_POST['powiat'])) {
            $powiat = $_POST['powiat'];
            $sqlSelect .= " AND absolwenci.powiat = '$powiat'";
        }
        if(!empty($_POST['index_kursu'])) {
            $index_kursu = $_POST['index_kursu'];
            $sqlSelect .= " AND absolwenci.index_kursu = '$index_kursu'";
        }
        if(!empty($_POST['uwagi'])) {
            $uwagi = $_POST['uwagi'];
            $sqlSelect .= " AND absolwenci.uwagi = '$uwagi'";
        }
        if(!empty($_POST['nr_usera'])) {
            $nr_usera = $_POST['nr_usera'];
            $sqlSelect .= " AND absolwenci.nr_usera = '$nr_usera'";
        }
    }

    $sqlSelect .=  " ;";

    $wynik2 = $conn->query($sqlSelect);

    # Usuwanie danych wierszy

    if(isset($_POST['usun']) && isset($_POST['id'])) {

        $id_do_usuniecia = $_POST['id'];
        
        // Przygotuj zapytanie SQL do usunięcia wiersza
        $sqlUsun = "DELETE FROM `absolwenci` WHERE absolwenci.id = $id_do_usuniecia";
        
        try {
            // Próba wykonania operacji usuwania
            $wynik_usun = $conn->query($sqlUsun);
    
            // Sprawdź, czy operacja zakończyła się sukcesem
            if ($wynik_usun) {
                header("Location: http://localhost/aplikacja%20web/Szukaj.php");
                exit();
            } else {
                echo "<script>alert('Wystąpił problem podczas usuwania rekordu.');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            // Wyjątek zostanie złapany, jeśli użytkownik nie ma uprawnień do wykonania operacji
            echo "<script>alert('Nie możesz wykonać tego działania.');</script>";
        }

    }

    $id = "";
    $stanoisko = "";
    $nazwisko ="";
    $sqlUser = "SELECT id, nazwa_uzytkownika, stanowisko, nazwisko FROM uzytkownicy WHERE nazwa_uzytkownika='$username' AND haslo='$password';";
    $resultsql = $conn->query($sqlUser);

    // Sprawdzenie czy wynik zapytania jest niepusty
    if ($resultsql->num_rows > 0) {
        // Pobranie danych i zapisanie ich do zmiennej
        $row = $resultsql->fetch_assoc();
        $stanowisko = $row['stanowisko'];
        $nazwisko = $row['nazwisko'];
    }

    if($stanowisko == "pracownik"){
        $pierwszy_znak = substr($username, 0, 1) . substr($nazwisko, 0, 1);
        $id = $pierwszy_znak;
    }
    # Zamknięcie 

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
        <div>
        </div>
        <div class="header-item">
            <h1> Szukaj Absolwenta</h1>
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
            <?php 
                // Sprawdzenie czy użytkownik jest administratorem
                if(strtolower($stanowisko) == "administrator") {
                    echo '<a href="Wpisz.php" class="link">Wpisz</a>';
                } else {
                    echo '<span class="inactive-link">-</span>';
                }
            ?>
        </section>
    </nav>

    
        <!-- Wprowadzanie Absolwentów -->
    <main>
        
        <h1> Szukaj Absolwenta </h1>
        
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

    

            <input type="submit" name="submit" value="Szukaj" id="submit">
            <input type="button" value="Wyczyść" onclick="clearForm()" id="button">
        </form>
    </section>

    <!-- Wyświetlanie absolwentów-->

    <section id="absolwenci_wys">
        <h1> Nasi Absolwenci </h1>

        <table>

            <tr id="naglowki" class="data-row">
                <td>Imie</td>
                <td>Nazwisko</td>
                <td>Ojciec</td>
                <td>Data urodzenia</td>
                <td>Gdzie</td>
                <td>Pesel</td>
                <td>Adres</td>
                <td>Numer K.</td>
                <td>Kurs</td>
                <td>Rozszerzenie</td>
                <td>Rok</td>
                <td>Oddział</td>
                <td>Rozpoczęcie</td>
                <td>Zakończenie</td>
                <td>Egzamin</td>
                <td>Protokół</td>
                <td>Numer zaś</td>
                <td>E-mail</td>
                <td>Index</td>
                <td>Telefon</td>
                <td>Skierowanie</td>
                <td>Powiat</td>
                <td>Index Kursu</td>
                <td>Uwagi</td>
                <td>ID Usera</td>
                <td></td>
                <td></td>
            </tr>
            <?php 
            while($row = $wynik2->fetch_assoc())
            {
                ?> 
                <tr class="data-row">
                    <td><?= $row['imie'] ?></td>
                    <td><?= $row['nazwisko'] ?></td>
                    <td><?= $row['ojciec'] ?></td>
                    <td><?= $row['data_uro'] ?></td>
                    <td><?= $row['gdzie'] ?></td>
                    <td><?= $row['pesel'] ?></td>
                    <td><?= $row['adres'] ?></td>
                    <td><?= $row['numer_k'] ?></td>
                    <td><?= $row['kurs'] ?></td>
                    <td><?= $row['rozszerzenie'] ?></td>
                    <td><?= $row['rok'] ?></td>
                    <td><?= $row['oddział'] ?></td>
                    <td><?= $row['rozpoczęcie'] ?></td>
                    <td><?= $row['zakończenie'] ?></td>
                    <td><?= $row['egzamin'] ?></td>
                    <td><?= $row['protokół'] ?></td>
                    <td><?= $row['numer_zaś'] ?></td>
                    <td><?= $row['e_mail'] ?></td>
                    <td><?= $row['index_'] ?></td>
                    <td><?= $row['telefon'] ?></td>
                    <td><?= $row['skierowanie'] ?></td>
                    <td><?= $row['powiat'] ?></td>
                    <td><?= $row['index_kursu'] ?></td>
                    <td><?= $row['uwagi'] ?></td>
                    <td><?= $row['id_usera'] ?></td>
                    <td>
                        <form action="Szukaj.php" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć tego absolwenta?');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="usun" class="delete-button" id="deleteButton">Usuń</button>
                        </form>
                    </td>
                    <td>
                        <form action="Edytuj.php" method="post">
                            <input type="hidden" title="Nie masz uprawnień" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="edytuj" class="edit-button" id="editButton">Edytuj</button>
                        </form>
                    </td>

                </tr>
            <?php
            } 
            ?>
        </table>
    </main>
        
    <script>
        let canUpdate = <?php echo json_encode($canUpdate); ?>;
        let canDelete = <?php echo json_encode($canDelete); ?>;
        let canSelect = <?php echo json_encode($canSelect); ?>;

        // Jeśli użytkownik nie ma uprawnień do aktualizacji, usuń przycisk edycji
        if (!canUpdate) {
            // Pobierz wszystkie przyciski o danym ID
            const buttons = document.querySelectorAll('#editButton');

            // Iteruj przez każdy przycisk i zmień jego styl
            buttons.forEach(button => {
                button.style.color = 'white'; // Zmień kolor na czerwony (przykładowy styl)
                button.style.backgroundColor = 'red'; // Zmień kolor tła na żółty (przykładowy styl)
                button.textContent = "Nie masz uprawnień";
                button.disabled = true;
            });
        }

        if (!canDelete) {
            // Pobierz wszystkie przyciski o danym ID
            const buttons = document.querySelectorAll('#deleteButton');

            // Iteruj przez każdy przycisk i zmień jego styl
            buttons.forEach(button => {
                button.style.color = 'white'; // Zmień kolor na czerwony (przykładowy styl)
                button.style.backgroundColor = 'red'; // Zmień kolor tła na żółty (przykładowy styl)
                button.textContent = "Nie masz uprawnień";
                button.disabled = true;
            });
        }

        if (!canSelect) {
            // Pobierz wszystkie przyciski o danym ID
            const buttons = document.querySelectorAll('#submit');

            // Iteruj przez każdy przycisk i zmień jego styl
            buttons.forEach(button => {
                button.style.color = 'white'; // Zmień kolor na czerwony (przykładowy styl)
                button.style.backgroundColor = 'red'; // Zmień kolor tła na żółty (przykładowy styl)
                button.disabled = true;
            });
        }

        

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
    </script>
    
        
    </body>
    </html>

