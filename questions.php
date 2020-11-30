<?php session_start(); ?>
<html>
<head>
    <title>Login Successful</title>
    <style>

        h3{
            font-size: 30px;
        }
        h4{
            font-size: 20px;
            margin-bottom: 10px;
        }
        html, body{
            background-color: #3CAEA3;
            vertical-align: middle;
        }

        body{
            font-family: sans-serif;
            font-size: 0px;
            color: ghostwhite;
            display: table;
            margin: auto;
            text-align: center;
            width: 30%;
            height: 40%;
        }

        h3{
            color:black;
            margin-top: 20px;
        }

        .questionphpContent{
            font-family: sans-serif;
            display: table-cell;
            width: 300px;
            padding: 60px 70px;
            border-radius: 25px;
            background: #f8f8ff;
            text-align: center;
            position: relative;
            top: 50%;
            vertical-align: middle;
        }

        .button{
            color: ghostwhite;
        }

        .formButtons{
            width:100%;
            text-align: center;
        }

        .inner{
            display:inline-block;
            font-size: 14px;
            text-align: center;
            width: 100px;
            border: 2px solid #FF66CC;
            border-radius: 25px;
            vertical-align: center;
            background-color: #FF66CC;
            height: auto;
            margin: 0;
            padding: 10px;
            position: relative;
            margin-top: 5px;
            margin-bottom: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="questionphpContent">
<?php

try {
    include_once ("dbconn.php");

    $email="";
    $userId=0;
    if (isset ($_SESSION['UserID']))
    {
        $email=$_SESSION['UserEmail'];
        $userId=$_SESSION['UserID'];
    }else{
        die ("<h3>User is not logged in.</h3> <a href='login.html' class='button inner'>Login</a>");
    }
    extract ($_POST);

    if (!$questionName || !$questionSkills || !$questionBody)
    {
        die ("<h3>Missing fields.</h3> <a href='questions.html' class='button inner'>Retry</a>");
    }

    $dbh = new PDO($dsn, $usr, $pwd);
    $sql = "INSERT INTO `questions` (`owneremail`, `ownerid`, `createddate`, `title`, `body`, `skills`, `score`)        
                VALUES (?,?,SYSDATE(),?,?,?,0) ";

    $stmt = $dbh->prepare($sql);

echo "$email, $userId, $questionName, $questionBody, $questionSkills, $sql";
    $stmt-> bindParam(1, $email, PDO::PARAM_STR);
    $stmt-> bindParam(2, $userId, PDO::PARAM_INT);
    $stmt-> bindParam(3, $questionName, PDO::PARAM_STR);
    $stmt-> bindParam(4, $questionBody, PDO::PARAM_STR);
    $stmt-> bindParam(5, $questionSkills, PDO::PARAM_STR);
    $stmt->execute();

    if (!$stmt) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
    }
    echo "<h3>Question added.</h3> <a href='project1index.php' class='button inner'>Home</a>";
}
catch (Exception $e) {
    echo $e;
}
?>
</div>
</body>
</html>

