<?php
$conn = mysqli_connect ("localhost", "root", "", "filtergana");
$kanji = $_POST["kanji"];
$okurigana = $_POST["okurigana"];
$furigana = $_POST["furigana"];
$meaning = $_POST["meaning"];

$sql = "INSERT INTO filtered_words (kanji, okurigana, furigana, meaning)
VALUES ('$kanji', '$okurigana', '$furigana', '$meaning')";
mysqli_query($conn, $sql);
header("Location: wordlist.php"); //Goes back to the list
?>