<?php 
# creates file "wordlist.txt"
$file = "wordlist.txt";
$fh = fopen('wordlist.txt', 'w') or die("Error in creating file.");

$conn = mysqli_connect("localhost", "root", "", "filtergana");
if(!$conn){
    die("Connection failed:" . mysqli_connect_error());
}

$sql = "SELECT kanji, okurigana, furigana, meaning FROM filtered_words";
$result = mysqli_query($conn, $sql);

# comment at beginning of wordlist.txt
fwrite($fh, "# Word list exported from FilterGana webpage, formatted for Anki; fields are separated using |.\n");

# adds each entry into wordlist.txt, formatted for anki by separating fields using |
while ($row = mysqli_fetch_assoc($result)) {
    $last = end($row);
    fwrite($fh, $row["kanji"] . $row["okurigana"] . "|" . $row["furigana"] . $row["okurigana"]);
    if (!empty($row["meaning"])) {
        fwrite($fh, ", " . $row["meaning"]);
    }
    if ($row != $last) {
        fwrite($fh, "\n");
    }
}
fclose($fh);

# download the file to user's computer
header("Content-Description: File Transfer");
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=" . basename($file));
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Content-Length: " . filesize($file));
readfile($file);
header("Refresh: 5; url=wordlist.php");
?>