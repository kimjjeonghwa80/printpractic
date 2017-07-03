<?php
    include("../library/config.php");
?>
<div class="col-md-6" style=" color: #555; font-size: 14px; margin-right: -60px; margin-top: 10px;">Select Foil</div>
    <div  class="col-md-3">
        <?php
            $res = mysql_query("SELECT * FROM pattern");
            if (mysql_num_rows($res)){
            echo "<select name='textpatternmenu' id='textpatternmenu'>";
                while ($category = mysql_fetch_assoc($res)){
                    $remove1 = str_replace("uploads/","", $category["pattern_path"]);
                    $name = preg_replace('/\.[^.]+$/','',$remove1);
                    echo "<option title='".$category["pattern_path"]."' value='".$category["id"]."'' id='".$category["pattern_path"]."'></option>";
                }
            echo "</select>";
            }
        ?>
    </div>   