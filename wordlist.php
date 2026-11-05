<!-- Word List page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilterGana - Word list</title>
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
            <section id="list-main" class="uneven-split-main">
                <div class="list">
                    <?php
                            $conn = mysqli_connect("localhost", "root", "", "filtergana");
                            if(!$conn){
                                die("Connection failed:" . mysqli_connect_error());
                            }
                            $sql = "SELECT kanji, okurigana, furigana, meaning FROM filtered_words";

                            $result = mysqli_query($conn, $sql);
                        ?>
                    <h2>Word List</h2>
                        <table border = "1">
                            <tbody>
                                <tr><th>Word</th><th>Furigana</th><th>Meaning</th></tr>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row["kanji"] . $row["okurigana"];?></td>
                                        <td><?php echo $row["furigana"];?></td>
                                        <td><?php echo $row["meaning"];?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table><?php mysqli_close($conn);?>
                </div>
                <a class="add-button" href="form.php">Add word</a> 
            </section>    
        </main>
        <footer>
            <p>Team BWAA | Brandon Le, Waylon Fairbanks, Afnan Siddique, Adrian Siers | 2026</p>
        </footer>
    </body>
</div>
</html>
