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

    $stmt = $pdo->prepare("SELECT * FROM series WHERE id= :id"); 
    $stmt->bindParam(':id', $id);
    $stmt->execute(); 
    while ($row = $stmt->fetch()) : ?>
        <h1><?= $row['title']?> - <?= $row['rating'] ?></h1>
        <form action="series.php?id=<?= $id?>" method="post">
            <div style="display: flex; align-items:center; height: 20px;"><h2>Titel-</h2><input type="text" value="<?= $row['title']?>" name="title" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Rating-</h2><input type="text" value="<?= $row['rating']?>" name="rating" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Awards-</h2><input type="text" value="<?= $row['has_won_awards']?>" name="has_won_awards" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Seizoen-</h2><input type="text" value="<?= $row['seasons']?>" name="seasons" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Country-</h2><input type="text" value="<?= $row['country']?>" name="country" id=""></div><br>
            <div style="display: flex; align-items:center; height: 20px;"><h2>Language-</h2><input type="text" value="<?= $row['language']?>" name="language" id=""></div><br>
            <div style="display: flex; align-items:center; height: 50px;"><h2>Omschrijving-</h2><textarea rows="4" cols="50" type="text" name="description" id=""><?= $row['description']?></textarea></div><br>
            <button type="submit" name="submit">Wijzig</button>
        </form>
    <?php endwhile; ?>
<?php endif; ?>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $has_won_awards = $_POST['has_won_awards'];
    $seasons = $_POST['seasons'];
    $country = $_POST['country'];
    $language = $_POST['language'];
    $description = $_POST['description'];

    $sql = "UPDATE series SET title = ?, rating = ?, has_won_awards = ?, seasons = ?, description = ?, language = ?, country = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$title, $rating, $has_won_awards, $seasons, $description, $language, $country, $id]);
}
?>