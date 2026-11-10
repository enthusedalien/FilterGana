<?php
$conn = mysqli_connect("localhost", "root", "", "filtergana");
#Doing this prevents weird html characters from being inputed into our database as gibberish
#Gibberish is better than threatening html characters
#More secure against XSS and HTML injections
$kanji = strip_tags(trim($_POST["kanji"]));
$okurigana = strip_tags(trim($_POST["okurigana"]));
$furigana = strip_tags(trim($_POST["furigana"]));
$meaning = strip_tags(trim($_POST["meaning"]));

#Doesn't let inputs exceed these given lengths
if (strlen($kanji) > 10 ||
    strlen($okurigana) > 5 ||
    strlen($furigana) > 15 ||
    strlen($meaning) > 75) {
    die("Input too long.");
}

#Anti-SQL Injection Build
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO filtered_words (kanji, okurigana, furigana, meaning)
     VALUES (?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $kanji,
    $okurigana,
    $furigana,
    $meaning
);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

header("Location: wordlist.php");
exit;
?>