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
            echo "<form class='pure-form' method='POST' action='login.php'>
            <fieldset>
                <legend><h1>Login to the network</h1></legend>
                <input type='hidden' name='loginSubmit' value='true' required/>
                <input type='email' placeholder='Email' name='mail' required/>
                <br><input type='password' placeholder='Password' name='pass'/>
                <br><label for='default-remember'>
                    <input type='checkbox' id='default-remember' /> Remember me
                </label>
                <br><button type='submit' class='pure-button pure-button-primary'>Sign in</button>
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



            $sql = "SELECT * FROM credentials WHERE name='$username' AND pass='$pass';";
            $result = mysqli_query($conn,$sql);
            
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                echo "<h1>Login Successful</h1><h3>Hi , $username </h3>";
                setcookie("usertoken",$username);
                header("Location: index.php");
                exit;
            }else{
                echo "<h1>User does not exist!</h1>
                <hr>
                <p>
                    <h3>Name : $username;
                </p>
                <button type='button' onclick='window.location=\"login.php\"' class='pure-button pure-button-primary'>Back to index page</button>";
                
            }

           
        }

    ?>
</body>
</html>