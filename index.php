<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <link rel="stylesheet" href="pure.min.css">
    <style>
        #landing a{
            margin:20px;
        }
    </style>
</head>
<body style="text-align:center;">
<h1>Social Network</h1>
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

            echo "Welcome , $current_name!<br>Role : $current_type";
            echo "<form method='POST' action='index.php'>
                <input type='hidden' name='userLogoutRequest' value='true'/>
                <button class='pure-button' type='submit'>Logout</button> 
            </form>";
            echo " <fieldset>
            <legend><h1>Send a Message</h1></legend>
            <form class='pure-form' method='POST' action='index.php'>
            <input type='hidden' name='sendMessageRequest' value='true'/>
            <br><input type='text' name='sender' placeholder='Enter Recievers Email'/>
            <br><textarea name='message' placeholder='Enter message content' style='text-align:left'></textarea>
            <br><button class='pure-button' type='submit'>Dispatch the Message</button>
        </form></fieldset> <hr>";
        
        // [],
            echo "<table border='3px ridge black' style='display:inline-block;margin:20px;'>";
            echo "<caption>Inbox</caption>
            <tr><td>Message</td><td>Sent By</td><td>TimeStamp</td></tr>";
        $stmt_message_query = "SELECT * FROM messages where dest = '$hashed_username';";
        $result = mysqli_query($conn,$stmt_message_query);
        
        if(mysqli_num_rows($result)>0){
         while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>".$row['content']."</td><td>".$row['source']."</td><td>".$row['time_st']."</td></tr>";
         }   
        }else{
            echo "<tr><td>Messages</td><td>Yet</td></tr>";
        }
            echo "</table>";

            echo "<table border='3px ridge black' style='display:inline-block;margin:20px;'>";
            echo "<caption>Outbox</caption>
            <tr><td>Message</td><td>Sent to</td><td>TimeStamp</td></tr>";
        $stmt_message_query = "SELECT * FROM messages where source = '$hashed_username';";
        $result = mysqli_query($conn,$stmt_message_query);
        
        if(mysqli_num_rows($result)>0){
         while($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>".$row['content']."</td><td>".$row['dest']."</td><td>".$row['time_st']."</td></tr>";
         }   
        }else{
            echo "<tr><td>No</td><td>Messages</td><td>Yet</td></tr>";
        }
            echo "</table>";

          }else{
            echo "<div id='landing'>
    <a class='pure-button' href='login.php'>Login to the network</a>
    <a class='pure-button' href='register.php'>Register on the network</a> 
    <br><a class='pure-button' href='forgot.php'>Forgot password!</a> 
    <hr>";
          }
        }

    }else{
        echo "<div id='landing'>
    <a class='pure-button' href='login.php'>Login to the network</a>
    <a class='pure-button' href='register.php'>Register on the network</a> 
    <br><a class='pure-button' href='forgot.php'>Forgot password!</a> 
    <hr>";
    }

?>
    
</div>
</body>
</html>