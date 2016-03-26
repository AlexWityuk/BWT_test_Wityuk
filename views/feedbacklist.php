<?php include ROOT . '/views/layouts/header.php'; ?>
<?php
foreach ($res as $row) 
{
    echo "<p> Сообщение от: " . $row['Name'] ." /". $row['Email'] ." ". $row['date'] ."</p>";
    echo "<textarea rows='3' cols='100' >". $row['Message'] ."</textarea>";
}
?>
<?php include ROOT . '/views/layouts/footer.php'; ?>

