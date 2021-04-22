<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>

<body>
<div class="contact">
    <div class="contact-form">
        <form class = "form" action ="/" method = "post" >
            <textarea name="email" id="email" class="email"  placeholder="Nhập mỗi email 1 dòng"></textarea>
            <button type="submit" id="submit" class="form-btn">Send Email</button> 
        </form>
    </div>
</div>
</body>
<?php
$configs = include('config.php');


$host = $configs['host'];;
$user = $configs['username'];;
$password = $configs['password'];;
$db = $configs['dbname'];;

$conn = new mysqli($host,$user,$password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email']) && $_POST['email'] !== '') {
    $emails = $_POST['email'];
    $arrEmail = explode("\n", $emails);
    updateEmail($conn, $arrEmail);
    $arr = getEmail($conn);
    sendAllEmail($arr);
}

function updateEmail($conn, $arrayEmail)
{
    foreach ($arrayEmail as $i)
    {
        if(validateEmail($i) == true)
        {
            $sql = "INSERT INTO email (email) SELECT * FROM (SELECT '$i') AS e WHERE NOT EXISTS ( SELECT email FROM email WHERE email = '$i' ) LIMIT 1;";
            $result = $conn->query($sql);
        }
        
    }
}

function getEmail($conn) 
{
    $arr = array();
    $sql = "SELECT email FROM email";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($arr, $row['email']);
        }
    }
    return $arr;

}

function sendAllEmail($arr)
{

    $message = "Dear, \n Toi ten la Phuc \n Toi la mot developer \n Theo doi toi tai https://phucmit.com \n Tran trong.";
    $headers = "From: shlomo@zend.com";

    foreach ($arr as $e)
    {
        mail($e, 'Email from phucle.24hdev@gmail.com', $message, $headers);
    }

    alert("Gui email thanh cong!");
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$conn->close();

?>

</html>