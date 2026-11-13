<?php
# Delete a word from the list
    $conn = mysqli_connect("localhost", "root", "", "filtergana");
    $kanji = $_GET["kanji"];
    $sql = "DELETE FROM filtered_words WHERE kanji = '$kanji'";
    mysqli_query($conn, $sql);
    header("Location: wordlist.php");
?>