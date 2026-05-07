<?php

//md5
$pass = "12344";
echo md5($pass);
echo "<br>";

//sha

echo password_hash("12344",PASSWORD_DEFAULT);


$verify = "$2y$10$VbT8sLi0htty4GLLrHMYnOJuE6lpMic0Yb3DcYOtD398p4bpYlKEu";

//password check
if (password_verify($pass,$verify)){
    echo "valid";
}
else {
    echo "invalid";
     
}

//base64_decode/incode
echo "<br>";

// $store = "12adin";

// // encode
// $encoded = base64_encode($store);
// echo base64_decode($store);


?>