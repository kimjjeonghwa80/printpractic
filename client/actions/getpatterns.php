<?php
    include("../library/config.php");
?>
<div class="col-md-12">
    <div class="col-md-6" style=" color: #555; font-size: 20px; margin-top: 10px;">Select Foil </div>
        <?php
            $res = mysql_query("SELECT * FROM pattern");
            if (mysql_num_rows($res))
            {
                echo "<select name='textpatternmenu' id='textpatternmenu'>";
                while ($category = mysql_fetch_assoc($res))
                {
                    $remove1 = str_replace("uploads/","", $category["pattern_path"]);
                    $name = preg_replace('/\.[^.]+$/','',$remove1);
                    echo "<option title='../admin/".$category["pattern_path"]."' value='".$category["id"]."'' id='../admin/".$category["pattern_path"]."'></option>";
                }
                echo "</select>";
            }
        ?>
</div>