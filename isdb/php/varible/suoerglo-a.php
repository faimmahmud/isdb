<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>$_REQUEST,$get,$post</h1>
    <?php
$store = $_REQUEST['fa'];
echo "name:" . $store;
?>  
  <form action="" method="post " +>

  <input type="text" name="fa">
  <input type="submit"value="submit">
  
</form>
</body>
</html>