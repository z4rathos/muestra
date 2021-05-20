      <?php
include "config.php";
        $estado= $_POST["estado"];
        $conn = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($conn));
                mysqli_select_db($conn, $cfgServer['dbname']) or die("Could not select database");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO led (estado)
        VALUES ('$estado')";
        
        if($conn->query($sql)==TRUE){
          $query = "SELECT estado FROM led ORDER BY ledID DESC LIMIT 0,1;";
          $result=mysqli_query($conn,$query);
          $f1=mysqli_fetch_array($result,MYSQLI_NUM);
        }
        mysqli_free_result($query);
        mysqli_free_result($sql);
        $conn->close();

?>
