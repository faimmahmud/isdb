
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo $_REQUEST['idn'];
    echo $_REQUEST['fa'];
    ?>
    <form action="#" method="post">
        user name <br>
        <input type="text" name="fa"><br><br>
        id:
        <br>
        <input type="number" name="idn"><br><br>
        <input type="submit" value="submit">
    </form>
    
</body>
</html>