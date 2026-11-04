<?php
        $conn = mysqli_connect("localhost", "root", "", "filtergana");
        if(!$conn){
            die("Connection failed:" . mysqli_connect_error());
        }
        $sql = "SELECT kanji, okurigana, furigana, meaning FROM filtered_words";

        $result = mysqli_query($conn, $sql);
    ?>
    <table border = "1">
        <tr><th>Word</th><th>Furigana</th><th>Meaning</th></tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["kanji"] . $row["okurigana"];?></td>
                <td><?php echo $row["furigana"];?></td>
                <td><?php echo $row["meaning"];?></td>
            </tr>
        <?php } ?>