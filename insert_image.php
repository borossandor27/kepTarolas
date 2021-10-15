<h1>ok</h1>
<div>
    <a href="index.php">Vissza a kezdőlapra</a>
</div>
<?php
var_dump($_FILES);

# getting the uploaded image and storing it
if ( isset($_FILES['image']['tmp_name']) ) {
    // open mysqli db connection
    $mysqliHost = "localhost";
    $mysqliUsername = "root";
    $mysqliPassword = "";
    $mysqliDatabase = "images";
    $mysqli = new mysqli($mysqliHost,$mysqliUsername,$mysqliPassword,$mysqliDatabase);

    // get image data
    $binary = file_get_contents($_FILES['image']['tmp_name']);

    // get mime type
    $finfo = new finfo(FILEINFO_MIME);
    $type = $finfo->file($_FILES['image']['tmp_name']);
    $mime = substr($type, 0, strpos($type, ';'));

    $query = "INSERT INTO `images` (`data`,`mime`,`name`) 
    VALUES('".$mysqli->real_escape_string($binary)."',
            '".$mysqli->real_escape_string($mime)."',
            '".$mysqli->real_escape_string($_FILES['image']['name'])."')";
    $mysqli->query($query);
}

# viewing the uploaded image
if ( isset($_GET['imageName']) ) {
    // open mysqli db connection
    $mysqli = new mysqli($mysqliHost,$mysqliUsername,$mysqliPassword,$mysqliDatabase);

    // query for the image in the db
    $query = "SELECT `data`,`mime` FROM `images` WHERE `name`='".$mysqli->real_escape_string($_GET['imageName'])."'";
    $result = $mysql->query($query);


    if ( $result->num_rows ) {
        // grab the query result from the db select
        $assoc = $result->fetch_assoc();

        // let the client browser know what type of data you're sending
        header('Content-type: '.$assoc['mime']);

        // dump the binary data to the browser
        echo $assoc['data'];
        exit;
    } else {
        header('HTTP/1.1 404 Not Found');
        exit;
    }
}
