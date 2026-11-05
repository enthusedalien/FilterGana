<!-- file for adding word form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilterGana - Add Word Form</title>
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
                <div class="form-wrapper">
                <!-- ADD PHP HERE @BRANDON -->
                    <form action="add-word.php" id="addform" method="post">
                        <h2>New Word Entry:</h2>
                        <div class="form-content">
                            <label class="form-input" for="kanjichar">Kanji character(s)<span class="required-format">*</span>: 
                                <input type="text" id="kanjichar" name="kanji" required>
                            </label>  
                            <label class="form-input" for="okurichar">Okurigana: 
                                <input type="text" id="okurichar" name="okurigana">
                            </label>
                            <label class="form-input" for="furichar">Furigana<span class="required-format">*</span>: 
                                <input type="text" id="furichar" name="furigana" required>
                            </label>
                            <label class="form-input" for="worddef">Meaning: 
                                <input type="text" id="worddef" name="meaning">
                            </label>
                        </div>
                        <input id="submit-word" class="hidden" type="submit" form="addform">

                    </form>
                    <a class="form-button" href="wordlist.html">Cancel</a>
                    <label class="form-button" for="submit-word">Add to List</label>
                    <p class="required-footer">*required</p>
                </div>
            </main>
        <footer>
            <p>Team BWAA | Brandon Le, Waylon Fairbanks, Afnan Siddique, Adrian Siers | 2026</p>
        </footer>
    </body>
</div>
</html>