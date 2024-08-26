<?php
require_once 'config.php';  

$sql = "SELECT username, AVG(score) as average_score FROM players GROUP BY username ORDER BY average_score DESC";

$result = $DB->query($sql);

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Žebříček hráčů</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Žebříček hráčů</h1>
    <table>
        <thead>
            <tr>
                <th>Uživatel</th>
                <th>Průměrné skóre</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . round($row['average_score'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Žádné výsledky</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="pexeso.php">Hrát další hru</a>
</body>
</html>
<?php
$DB->close();
?>
