<?php
# Delete a word from the list
    $conn = mysqli_connect("localhost", "root", "", "filtergana");
    $kanji = $_GET["kanji"];
    $furigana = $_GET["furigana"];
    $sql = "DELETE FROM filtered_words WHERE kanji = '$kanji' && furigana = '$furigana'";
    mysqli_query($conn, $sql);
    header("Location: wordlist.php");
?>