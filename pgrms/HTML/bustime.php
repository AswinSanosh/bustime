<html>
    <body>
        <?php
            if(isset($_POST["subm"]))
            {
                $id=$_POST["sessid"];
                $arr=explode(") ",$id);
                print_r($arr);

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "mysql";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) 
                {
                    die("Connection failed: " . $conn->connect_error);
                }
            }
        ?>
    </body>
</html>