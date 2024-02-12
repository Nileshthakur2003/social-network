<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="pure.min.css">
    <style>
        form input{
            margin:10px;
        }
        form button{
            margin:20px;
        }
    </style>
</head>
<body style="text-align:center">
    <?php
        if(!isset($_POST['loginSubmit'])){
            echo "<form class='pure-form' method='POST' action='register.php'>
            <fieldset>
                <legend><h1>Register to the network</h1></legend>
                <input type='hidden' name='loginSubmit' value='true' required/>
                <input type='email' placeholder='Email' name='mail' required/>
                <br><input type='password' placeholder='Password' name='pass'/>
                <br><label for='default-remember'>
                    <input type='checkbox' id='default-remember' name='admin_choice'/> admin
                </label>
                <br><button type='submit' class='pure-button pure-button-primary'>Register me</button>
            </fieldset>
        </form>
        <button type='button' onclick='window.location=\"index.php\"' class='pure-button pure-button-primary'>Back to index page</button>";
        }else{


            // database connection details
            $host = "localhost:3306";
            $username = "root";
            $password = "";
            $databaseName = "users";

            $conn = mysqli_connect($host,$username,$password,$databaseName);

            if($conn->connect_errno){
                echo "Failed to connnect ".$conn->connect_error;
            }else{
                echo "<pre style='background:green'>Connnected to database successfully</pre>";
            }
            
            $username = $_POST['mail'];
            $pass = $_POST['pass'];
            $type = "user";
            if(isset($_POST['admin_choice'])){
                $type = "admin";
            }

            $sql = "INSERT INTO credentials(name,pass,type)VALUES('$username','$pass','$type');";
            $result = mysqli_query($conn,$sql);
            echo "<h1>Signup Successful</h1><h3>Hi , $username </h3>";
            echo "<hr>
                <p>
                    <h3>Name : $username;
                    <br>Password : $pass;
                </p>
                <button type='button' onclick='window.location=\"index.php\"' class='pure-button pure-button-primary'>Back to index page</button>";

        }

    ?>
</body>
</html>