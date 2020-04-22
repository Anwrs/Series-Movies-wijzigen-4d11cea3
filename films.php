<?php 

$host = '127.0.0.1';
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [ 
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

<a href="index.php">Terug</a>

<?php
if (isset($_GET['id'])) :
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM movies WHERE id= :id"); 
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    while ($row = $stmt->fetch()) : ?>
        <h1><?= $row['title']?> - <?= $row['duur'] ?> minuten</h1>
        <form action="films.php?id=<?= $id?>" method="post">
            <div style="display: flex; align-items:center; height: 20px;"><h2>Titel-</h2><input type="text" value="<?= $row['title']?>" name="title" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Duur-</h2><input type="text" value="<?= $row['duur']?>" name="duur" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Datum van uitkomst-</h2><input type="text" value="<?= $row['datum_van_uitkomst']?>" name="datum_van_uitkomst" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Land van uitkomst-</h2><input type="text" value="<?= $row['land_van_uitkomst']?>" name="land_van_uitkomst" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Omschrijving-</h2><input type="text" value="<?= $row['description']?>" name="description" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Youtube Trailer id-</h2><input type="text" value="<?= $row['youtube_trailer_id']?>" name="youtube_trailer_id" id=""></div><br>
            <button type="submit" name="submit">Wijzig</button>
        </form>
    <?php endwhile; ?>
<?php endif; ?>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $duur = $_POST['duur'];
    $datum_van_uitkomst = $_POST['datum_van_uitkomst'];
    $land_van_uitkomst = $_POST['land_van_uitkomst'];
    $description = $_POST['description'];
    $youtube_trailer_id = $_POST['youtube_trailer_id'];

    $sql = "UPDATE movies SET title = ?, duur = ?, datum_van_uitkomst = ?, land_van_uitkomst = ?, description = ?, youtube_trailer_id = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$title, $duur, $datum_van_uitkomst, $land_van_uitkomst, $description, $youtube_trailer_id, $id]);
}
?>