<?php
session_start(); # Resume session started in update-form.php

$conn = mysqli_connect("localhost", "root", "", "filtergana");
# Doing this prevents weird html characters from being inputed into our database as gibberish
# Gibberish is better than threatening html characters
# More secure against XSS and HTML injections
$kanji = strip_tags(trim($_POST["kanji"]));
$okurigana = strip_tags(trim($_POST["okurigana"]));
$furigana = strip_tags(trim($_POST["furigana"]));
$meaning = strip_tags(trim($_POST["meaning"]));

# Retrieve previous word entry data if successfully set
if (isset($_SESSION["pkanji"]) && isset($_SESSION["pfurigana"])) {
    $pkanji = $_SESSION["pkanji"];
    $pfurigana = $_SESSION["pfurigana"];
}
else {
    echo "Error: unable to find previous word entry";
}

# Doesn't let inputs exceed these given lengths
if (mb_strlen($kanji) > 10 ||
    mb_strlen($okurigana) > 5 ||
    mb_strlen($furigana) > 15 ||
    mb_strlen($meaning) > 75) {
        echo "<script>
            alert('Input too long.');
            window.location.href='form.php';
            </script>";
        exit;
}

# Anti-SQL Injection Build
$stmt = mysqli_prepare(
    $conn,
    "UPDATE filtered_words 
    SET kanji=?, okurigana=?, furigana=?, meaning=?
    WHERE kanji='$pkanji' AND furigana='$pfurigana'"
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

session_unset(); # Unset all session variables (previous kanji and previous furigana)
session_destroy(); # Destroy session & all session variables

header("Location: wordlist.php");
exit;
?>