<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="pure.min.css">
</head>
<body style="text-align:center;background:#6CB4EE;">
    <?php
     echo "<h1>Password Recovery</h1><hr>";
        if(isset($_POST['fprecovery'])){
        $mail = $_POST['mail'];
        $host = "localhost:3306";
        $username = "root";
        $password = "";
        $databaseName = "users";

        $conn = mysqli_connect($host,$username,$password,$databaseName);

        $sql = "SELECT * FROM credentials where name = '$mail';";
        $result = mysqli_query($conn,$sql);
        
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            echo "<h2>Password for $mail</h2>";
            echo "<p><h3><em>".$row['pass']."</em></h3></p>";
        }else{
            echo "<pre style='background:red'>No such user found!</pre>";

        }

        }else{
           
            echo "<form class='pure-form' method='POST' action='forgot.php'>
            <input type='hidden' name='fprecovery' value='true' />
            <input type='text' name='mail' />
            <input type='submit' class='pure-button'></input>
            </form>";
        }
        echo "<a href=\"index.php\"; class='pure-button'>back to home</a>";

    ?>
</body>
</html>