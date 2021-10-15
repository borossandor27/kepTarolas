<!DOCTYPE html>
<!--
php.ini - ben beállítani, Nem lehet előttük a # karakter
    file_uploads = On
    upload_tmp_dir = "C:\xampp\tmp"

Ha feltöltésnél hibaüzenetet kapunk érdemes ellenőrizni:
    upload_max_filesize = 8M
    post_max_size = 8M
    max_file_uploads = 50

hasznos:
session.upload_progress.enabled = On
session.upload_progress.cleanup = On
-->
<html lang="hu">
    <head>
    
        <meta charset="UTF-8">
        <title>Kép tárolás adatbázisban</title>
        <style>
            img {
                max-height: 150px;
                size: auto;
            }
            .card {
                max-width: 300px;
                float: left;
                text-align: center;
                margin: .2vw;
                padding: .5vw;
                height: 300px;
                border: 1px solid darkgray;
            }
            .info {
                padding: 0px;
                margin: 0px;
            }
            header {
                text-align: left;
                padding: .8vw;
            }
            body {
                margin: 1vw;
            }
        </style>
    </head>
    <body>
        <header>
            <form method="post" enctype="multipart/form-data" action="insert_image.php">
                <input type="file" name="image" />
                <input type="submit" />
            </form>
        </header>
        <section>
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
                  echo '<div class="card">';
//                echo "<img src='data:image;base64," . $row["image"]. ">";
                  echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['data'] ).'"/>';
                  echo '<div class="info">';
                  echo '<h3>'.$row["name"].'</h3>';
                  echo '<p><i>feltöltve</i></p><p>'.$row["upload"].'</p>';
                  echo '</div>';
                  echo '</div>';
              }
            } else {
              echo "0 results";
            }
            $conn->close();
            ?>            
        </section>
        

    </body>
</html>
