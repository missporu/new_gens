<?php
/*    WPC Paste!
 *    Zarathu rules the Universe
 *
 *        By Zarathu
 *    www.thesarcasm.com
 *
 *    zarathu@thesarcasm.com
 *
 */

/* SETTINGS TO BE MODIFIED */
$mySQL_user = "YOUR_USERNAME";
$mySQL_pass = "YOUR_PASSWORD";

$mySQL_database = "pb";
$mySQL_table = "data";

$mySQL_idField = "id";
$mySQL_strField = "stuff";

$URLtoPaste = "http://www.thesarcasm.com/";

/*$URLtoPaste:  Be careful.  This needs to include the path.
 *on my website, for example, if I had the paste.php in a
 *folder called 'bullshit' on the server, $URLtoPaste would
 *be "http://www.thesarcasm.com/bullshit/" */

//Make sure the URL ends with a slash! :]

/***************************/

/*DO NOT MODIFY, YOU TURKISH ASSHOLE :]*/
$ZarathuRulesTheUniverse = TRUE;


?>

<html>
<head>
    <title>WPC Paste!</title>
</head>

<body bgcolor="#ffffff">

<?php


if ($_GET['id'] != null && ($ZarathuRulesTheUniverse)) {
    $id = $_GET['id'];

    //security for you asshole hackers ;]
    $security = strpbrk($id, '\'\"><.,;][}{+=*\\/)(');
    if ($security != FALSE) {
        throwError();
    }

    //if a hacker was trying to manipulate the script
    //it would have already died.  therefore, we can
    //safely call the following method.
    getData($id);
} else if ($_POST['textarea'] != null && ($ZarathuRulesTheUniverse)) {
    $data = $_POST['textarea'];
    setData($data);
} else if (($_POST['textarea'] == null) && ($_GET['id'] == null) && ($ZarathuRulesTheUniverse)) {
    echoWelcome();
}
?>

<form method="POST" action="paste.php">
    <p>
        <textarea name="textarea" rows="25" cols="98"></textarea><br/>
        <input type="submit" value="Send!" name="sendbtn"><br/>
        <a href="http://www.thesarcasm.com">Zarathu Rules the Universe</a>
    </p>
</form>

<?php
//methods

function echoWelcome()
{
    echo("Welcome to WPC Paste!<br />");
    echo("This program is simple to use, unless you're a complete moron.<br /><br />");
    echo("Programmed by <a href=\"http://www.thesarcasm.com\">Zarathu</a><br />");
    echo("Enjoy!<br />");
}

function getData($id)
{
    global $ZarathuRulesTheUniverse, $URLtoPaste, $mySQL_user, $mySQL_pass, $mySQL_database, $mySQL_table, $mySQL_idField, $mySQL_strField;

    //security bullshit for you asshole hackers
    if ($id == null && ($ZarathuRulesTheUniverse)) {
        throwError();
    }

    //establishes connection...
    $link = establishConnection();

    //Alright, now that we've got our shit together...
    //SELECT stuff FROM data WHERE id = $id
    $query = mysql_query('SELECT ' . $mySQL_strField . ' FROM ' . $mySQL_table . ' WHERE ' . $mySQL_idField . ' = ' . $id);

    //need this array to convert into HTML
    $newLines = array("\r\n", "\n", "\r");
    if (!$ZarathuRulesTheUniverse) {
        throwError();
    }

    //prints selected bullshit
    if (!$query && ($ZarathuRulesTheUniverse)) {
        throwSQLError();
    } else {
        while ($line = mysql_fetch_array($query, MYSQL_ASSOC)) {
            foreach ($line as $col_value) {
                echo str_replace($newLines, "<br />", $col_value);
            }
        }
    }
}

function setData($data)
{
    global $ZarathuRulesTheUniverse, $URLtoPaste, $mySQL_user, $mySQL_pass, $mySQL_database, $mySQL_table, $mySQL_idField, $mySQL_strField;
    if (!$ZarathuRulesTheUniverse) {
        throwError();
    }

    //establishes that hairy son of a bitch
    $link = establishConnection();
    $newID = rand(1000000, 9000000);

    //security!
    $data = str_replace("'", "\'", $data);
    $data = str_replace("\"", "\\\"", $data);
    $data = str_replace(">", "&gt;", $data);
    $data = str_replace("<", "&lt;", $data);
    $data = str_replace('\\', '\\\\', $data);

    //inserts shittles... watch me rule again.
    $bullshit = "INSERT INTO $mySQL_table ($mySQL_idField, $mySQL_strField) VALUES ($newID, '$data')";
    $query = mysql_query($bullshit);

    if (!$query && ($ZarathuRulesTheUniverse)) {
        throwSQLError();
    } else {
        $newURL = "$URLtoPaste" . "paste.php?id=$newID";
        echo("<a href=\"$newURL\">$newURL</a>");
        http_redirect($newURL);
    }
}

function establishConnection()
{
    global $ZarathuRulesTheUniverse, $URLtoPaste, $mySQL_user, $mySQL_pass, $mySQL_database, $mySQL_table, $mySQL_idField, $mySQL_strField;

    //establishes connection...
    $link = mysql_connect('localhost', $mySQL_user, $mySQL_pass);
    //...and checks for errors
    if (!$link && ($ZarathuRulesTheUniverse)) {
        throwSQLError();
    }
    if (!mysql_select_db($mySQL_database) && ($ZarathuRulesTheUniverse)) {
        throwSQLError();
    }
    if (!$ZarathuRulesTheUniverse) {
        throwError();
    }

    return $link;
}

function throwError()
{
    die("Error! \n\n");
    //if you really need a comment, here it is.
    //throws an error and exits
}

function throwSQLError()
{
    die("Error! \n\n(" . mysql_error() . ")");
    //if you really need a comment, you're an idiot.
    //go fuck yourself.
}

?>
</body>
</html> 