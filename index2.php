<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <link rel="stylesheet" href="pure.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <style>
       
        #landing a{
            margin:20px;
        }
        #msgform textarea{
            width:30%;
            height:200px;

        }
        #msgform input[type=text]{
            width:30%;
        }
        #msgform form button{
            width:30%;
        }
        #msgform form input[type=file]{
            width:30%;
        }
    </style>
</head>
<body style="text-align:center;background:#6CB4EE;">
<h1 ><span class="fa fa-message"></span>&nbsp;Messages</h1>

<?php
    if(isset($_COOKIE['usertoken'])){
        $hashed_username = $_COOKIE['usertoken'];

        $host = "localhost:3306";
        $username = "root";
        $password = "";
        $databaseName = "users";

        $conn = mysqli_connect($host,$username,$password,$databaseName);


        if(isset($_POST['userLogoutRequest'])){
            setcookie("usertoken","");
            header("Location: index.php");
            exit;
        }else if(isset($_POST['sendMessageRequest'])){
            /* search for reciepents adress.
                if(found){
                    add the message to the table `messages`
                }else{
                    show an error message[i.e. reciepent not found!]
                }
            */

            $sql = "SELECT * FROM credentials where name = '".$_POST['sender']."';";
            $result = mysqli_query($conn,$sql);
            
            if(mysqli_num_rows($result)>0){
              $senders = $_POST['sender'];
              $content = $_POST['message'];
              $stamp = date("Y-m-d,h:m:s",time());

              $row = mysqli_fetch_assoc($result);
              $add_msg_stmt = "INSERT INTO messages(dest,source,content,time_st)VALUES('$senders','$hashed_username','$content','$stamp');";
              $res = mysqli_query($conn,$add_msg_stmt);

             
            header("Location: index.php");
                exit;
            }else{
                header("Location: index.php?recipentNotFound=true");
                exit;
                
            }
            

        }else{
        
          // database connection details
          
          if($conn->connect_errno){
              echo "Failed to connnect ".$conn->connect_error;
          }else{
              echo "<pre style='background:green'>Connnected to database successfully</pre>";
          }
          if(isset($_GET['recipentNotFound'])){
            echo "<pre style='background:red' onclick='this.style.display =\"none\";'>Reciepent Not Found! x </pre>";
          }

          $sql = "SELECT * FROM credentials where name = '$hashed_username';";
          $result = mysqli_query($conn,$sql);
          
          if(mysqli_num_rows($result)>0){
            
            $row = mysqli_fetch_assoc($result);
            $current_name = $row['name'];
            $current_type = $row['type'];

            echo "[$current_name]";
            echo "<div class='pure-button-group' role='group' aria-label='...'>
            <button class='pure-button' onclick='window.location=\"index.php\"'>Home</button>
                    <button class='pure-button' onclick='window.location=\"inbox.php\"'>Inbox</button>
                  <button class='pure-button' onclick='window.location=\"outbox.php\"'>Outbox</button>
                  <form method='POST' action='index.php' style='display:inline-block'>
                <input type='hidden' name='userLogoutRequest' value='true'/>
                <button class='pure-button' type='submit'>Logout</button> 
            </form>
                  </div>";

            echo " <fieldset>
            <legend><h1>Send a Message</h1></legend>
            <form class='pure-form' method='POST' action='index.php' id='msgform'>
            <input type='hidden' name='sendMessageRequest' value='true'/>
            <br>To Email : <input type='text' name='sender' placeholder='Enter Recievers Email'/>
            <br>Message : <textarea name='message' placeholder='Enter message content' style='text-align:left'></textarea>
            <br><button class='pure-button' type='submit'>Dispatch the Message</button>
        </form></fieldset>";
        
        // [],
       
          }else{
            echo "<div id='landing'>
    <a class='pure-button' href='login.php'>Login to the network</a>
    <a class='pure-button' href='register.php'>Register on the network</a> 
    <br><a class='pure-button' href='forgot.php'>Forgot password!</a> 
    ";
          }
        }

    }else{
        echo "<div id='landing'>
    <a class='pure-button' href='login.php'>Login to the network</a>
    <a class='pure-button' href='register.php'>Register on the network</a> 
    <br><a class='pure-button' href='forgot.php'>Forgot password!</a> 
    ";
    }

?>
    
</div>
</body>
</html>