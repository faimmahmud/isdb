<form method="post">
    enter marks <input type="number" name="marks">
   
    <input type="submit" name="submit" value="check grade">
</form>

<?php

if (isset($_POST['submit'])){ 
    $marks = $_POST['marks'];

    if ($marks >=  80){ 
        echo "grade: a+";
    }
    elseif ($marks >=  70){ 
        echo "grade: a";
    }
    elseif ($marks >=  60){ 
        echo "grade: a-";
    }
    elseif ($marks >=  50){ 
        echo "grade: b";
    }
    elseif ($marks >=  40){ 
        echo "grade: c";
    }
    elseif ($marks >=  34){ 
        echo "grade: d";
    }
    else
        echo "grade: fail";
}
?>


