<?php
session_start();

require 'database.php';

$conn = Connection();

$sql = "SELECT 
            k.kniha_nazev, 
            k.kniha_isbn, 
            k.kniha_rok, 
            k.kniha_vydavatel, 
            k.kniha_pocet, 
            k.kniha_popis, 
            GROUP_CONCAT(CONCAT(a.autor_jmeno, ' ', a.autor_prijmeni) SEPARATOR ', ') AS autori, 
            GROUP_CONCAT(z.zanr_nazev SEPARATOR ', ') AS zanry 
        FROM 
            kniha k 
        LEFT JOIN 
            kniha_autor ka ON k.kniha_id = ka.kniha_id 
        LEFT JOIN 
            autor a ON ka.autor_id = a.autor_id 
        LEFT JOIN 
            kniha_zanr kz ON k.kniha_id = kz.kniha_id 
        LEFT JOIN 
            zanr z ON kz.zanr_id = z.zanr_id 
        GROUP BY 
            k.kniha_id";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="cs">

<head>
    <title>Katalog knih</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <header>
        <nav>

        </nav>
        
        <div>
            <h1>Katalog knih</h1>
        </div>
    </header>
    <main>
        <?php
if ($result->num_rows > 0) {
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "Název: " . $row["kniha_nazev"] . "<br>";
        echo "ISBN: " . $row["kniha_isbn"] . "<br>";
        echo "Rok vydání: " . $row["kniha_rok"] . "<br>";
        echo "Vydavatel: " . $row["kniha_vydavatel"] . "<br>";
        echo "Počet stránek: " . $row["kniha_pocet"] . "<br>";
        echo "Popis: " . $row["kniha_popis"] . "<br>";
        echo "Autoři: " . $row["autori"] . "<br>";
        echo "Žánry: " . $row["zanry"] . "<br>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Žádné knihy nebyly nalezeny.";
}

$conn->close();
?>
    </main>

    <footer>
        <p>Školní projekt v rámci předmětu Databázové systémy II | © Ondřej Marek</p>
    </footer>
</body>

</html>