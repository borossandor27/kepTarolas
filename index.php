<!DOCTYPE html>
<!--
php.ini
file_uploads=On
upload_tmp_dir="C:\xampp\tmp"
upload_max_filesize=2M
max_file_uploads=50

hasznos:
session.upload_progress.enabled = On
session.upload_progress.cleanup = On
-->
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <header>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "images";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM `images`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
//                echo "<img src='data:image;base64," . $row["image"]. ">";
                  echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['data'] ).'"/>';
              }
            } else {
              echo "0 results";
            }
            $conn->close();
            ?>            
        </header>
        <form method="post" enctype="multipart/form-data" action="insert_image.php">
            <input type="file" name="image" />
            <input type="submit" />
        </form>
 
    </body>
</html>
