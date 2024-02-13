<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
    <script type="text/javascript">

function showCurrentMessage(obj){
    const message =  obj.children[0].innerText;
    const reciever = obj.children[1].innerText;
    const time_stamp = obj.children[2].innerText;

    document.getElementById("msgTitle").innerHTML = "Sent to : "+reciever+"<br>Sent on : "+time_stamp;

    document.getElementById("msgText").innerHTML = message;
    
    document.getElementById("messageBox").style.display = 'block';

};
</script>
    <style>
         table{
            background:white;
        }
        table tr:hover{
            background:black;
            color:white;
            cursor:pointer;
        }
        #messageBox{
            display:none;
            position:absolute;
            top:20%;
            left:25%;
            height:200px;
            width:50%;
            border-radius:15px;
            border:5px ridge black;
            padding:20px;
            background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(253,187,45,1) 100%);
        }

        #messageBox #head{
            margin:0px;
            border-bottom:2px ridge black;

        }
        #messageBox #head #msgTitle{
            margin:10px;
        }

        #messageBox #content{
            margin:0px;
            border-bottom:2px ridge black;
        }
        #messageBox #content #msgText{
            margin:10px;
        }
    </style>
    <link rel="stylesheet" href="pure.min.css">
</head>
<body style="text-align:center;background:#6CB4EE;">
<div id="messageBox">
<button onclick="this.parentElement.style.display = 'none';">x</button>
<div id="head">
<div id="msgTitle">
    
    </div>
    
</div>
<div id="content">
<div id="msgText">
    
    </div>
    
</div>
</div>
<span class='pure-button' style="float:left;margin:20px" onclick="window.location='index.php'">< Back to Home</span>
<h1 style="display:inline-block;margin-left:-10%;"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;Outbox</h1>
<hr>
    <?php

if(isset($_COOKIE['usertoken'])){
    $hashed_username = $_COOKIE['usertoken'];
    
        $host = "localhost:3306";
        $username = "root";
        $password = "";
        $databaseName = "users";

        $conn = mysqli_connect($host,$username,$password,$databaseName);

        echo "[$hashed_username]";
        echo "<div class='pure-button-group' role='group' aria-label='...'>
        <button class='pure-button' onclick='window.location=\"index.php\"'>Home</button>
                <button class='pure-button' onclick='window.location=\"inbox.php\"'>Inbox</button>
              <button class='pure-button' onclick='window.location=\"outbox.php\"'>Outbox</button>
              <form method='POST' action='index.php' style='display:inline-block'>
            <input type='hidden' name='userLogoutRequest' value='true'/>
            <button class='pure-button' type='submit'>Logout</button> 
        </form>
              </div>";

        echo "<table class='pure-table' border='3px ridge black' style='display:inline-block;margin:20px;'>";
        echo "<tr><td>Message</td><td>Sent to</td><td>TimeStamp</td></tr>";
    $stmt_message_query = "SELECT * FROM messages where source = '$hashed_username';";
    $result = mysqli_query($conn,$stmt_message_query);
    
    if(mysqli_num_rows($result)>0){
     while($row = mysqli_fetch_assoc($result)){
        echo "<tr onclick='showCurrentMessage(this)'><td>".$row['content']."</td><td>".$row['dest']."</td><td>".$row['time_st']."</td></tr>";
     }   
    }else{
        echo "<tr><td>No</td><td>Messages</td><td>Yet</td></tr>";
    }
        echo "</table>";


}else{
    header("Location: index.php");
    exit;
}

    ?>
</body>
</html>