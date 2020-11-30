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
            background-color: #3CAEA3;
            display: table;
            margin: auto;
            text-align: center;
            width: 30%;
            height: 40%;
        }

        .registrationphpContent{
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
            margin-bottom: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="registrationphpContent">
<?php

try {
    extract ($_POST);
    if (!$firstName ||!$lastName || !$email || !$birthday ||!$password)
    {
        die ("<h3>Missing fields.</h3><a href='registration.html' class='button inner'>Retry</a>");
    }

    include_once ("dbconn.php");

    $dbh = new PDO($dsn, $usr, $pwd);
    $sql = "INSERT INTO `accounts` ( `email`, `fname`, `lname`, `birthday`, `password`) VALUES (?,?,?,?,?) ";

    $stmt = $dbh->prepare($sql);

    if(!checkDateFormat($birthday))
    {
        die ("<h3>Invalid date format.</h3><a href='registration.html' class='button inner'>Retry</a>");
    }
//echo "Date: $birthday";
    $stmt-> bindParam(1, $email, PDO::PARAM_STR);
    $stmt-> bindParam(2, $firstName, PDO::PARAM_STR);
    $stmt-> bindParam(3, $lastName, PDO::PARAM_STR);
    $stmt-> bindParam(4, $birthday, PDO::PARAM_STR);
    $stmt-> bindParam(5, $password, PDO::PARAM_STR);
    $stmt->execute();

    echo "<h3>Account added.</h3><br><a href='project1index.php' class='button inner'>Login</a>";
} catch (Exception $e) {
    echo $e;
}
function checkDateFormat($date)
{
    // match the format of the date
    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
    {

        // check whether the date is valid or not
        if (checkdate($parts[2],$parts[3],$parts[1])) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}
?>
</div>
</body>
</html>
