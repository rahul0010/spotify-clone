<?php
    include('./includes/includedFiles.php');
?>

<h1 class="pageHeadingBig">You might also like</h1>

<div class="gridViewContainer">
    <?php
        $albumQuery = mysqli_query($con, "select * from albums");

        while($row = mysqli_fetch_array($albumQuery))
        {
            echo "<div class='gridViewItem'>
                    <span onclick=\"openPage('album.php?id=".$row["id"]."')\" role='link' tabindex='0'>
                        <img src='" . $row["artworkPath"] . "'>
                        <div class='gridViewInfo'>
                            ". $row["title"] ."
                        </div>
                    </span>
                </div>";
        }
    ?>
</div>
