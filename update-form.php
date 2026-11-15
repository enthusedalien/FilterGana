<?php session_start(); # Start session to store previous word entry data for update-word.php ?>
<!-- Update Word Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilterGana - Update Word Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="flex-wrapper">
    <body>
        <div class="top-bar">
            <header>
                <h1>FilterGana</h1>
            </header>
            <nav>
                <a class="nav-button" href="index.html">Home</a>
                <a class="nav-button" href="wordlist.php">Word List</a>
            </nav>
        </div>
            <main>
                <?php 
                    $conn = mysqli_connect("localhost", "root", "", "filtergana");
                    if (!$conn) {
                        die("Connection failed:" . mysqli_connect_error());
                    }

                    # Get all original word entry data
                    $pkanji = trim($_GET["kanji"]);
                    $pokurigana = trim($_GET["okurigana"]);
                    $pfurigana = trim($_GET["furigana"]);
                    $pmeaning = trim($_GET["meaning"]);

                    # Set previous kanji and previous furigana as session variables for update-word.php
                    $_SESSION["pkanji"] = $pkanji;
                    $_SESSION["pfurigana"] = $pfurigana;
                ?>
                <div class="form-wrapper">
                    <form action="update-word.php" id="modform" method="post">
                        <h2>Modify Word Entry:</h2>
                        <div class="form-content">
                            <label class="form-input" for="kanjichar">Kanji character(s)<span class="required-format">*</span>: 
                                <input type="text" id="kanjichar" name="kanji" required value="<?php echo $pkanji;?>">
                            </label>  
                            <label class="form-input" for="okurichar">Okurigana: 
                                <input type="text" id="okurichar" name="okurigana" value="<?php if (is_null($pokurigana)) {
                                        exit;
                                    } else {
                                        echo $pokurigana; }?>">
                            </label>
                            <label class="form-input" for="furichar">Furigana<span class="required-format">*</span>: 
                                <input type="text" id="furichar" name="furigana" required value="<?php echo $pfurigana;?>">
                            </label>
                            <label class="form-input" for="worddef">Meaning: 
                                <input type="text" id="worddef" name="meaning" value="<?php if (is_null($pmeaning)) {
                                        exit;
                                    } else {
                                        echo $pmeaning; }?>">
                            </label>
                        </div>
                        <input id="submit-word" class="hidden" type="submit" form="modform">
                    </form>
                    <a class="form-button" href="wordlist.php">Cancel</a>
                    <label class="form-button" for="submit-word">Update word</label>
                    <p class="required-footer">*required</p>
                </div>
            </main>
        <footer>
            <p>Team BWAA | Brandon Le, Waylon Fairbanks, Afnan Siddique, Adrian Siers | 2026</p>
        </footer>
    </body>
</div>
</html>