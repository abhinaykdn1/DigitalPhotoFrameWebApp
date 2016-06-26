<?php
$ip = "172.20.181.98";
$login = "http://" . $ip ."/uploading/plogin.php";
if (isset($_POST['username']) && isset($_POST['password'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = $login . "?username={$username}&password={$password}";
  $json = file_get_contents($query);

  $filename = "frame_id.json";
  $file_content = $json;
  //$filepath = "/var/www/html/dpf/".$filename;
  echo $file_content;
  $fh = fopen($filename,'w')  or die("can't open file");
  fwrite($fh,$file_content);
  fclose($fh);
  header("location:index.php");

}
?>
<html>
<body>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="text" placeholder="username" id="user" name="username">
    <input type="password" placeholder="password" id="pass" name="password">
    <button type="submit">Login</button>
  </form>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script type="text/javascript">
  // $(document).ready(function(){
  //   $("form").submit(function(event){
  //     event.preventDefault();
  //     $form = $(this);
  //     var user = $("#user").val();
  //     var pass = $("#pass").val();
  //     //alert(user+pass);
  //     //data = {username:user,password:pass};
  //     //alert(data);
  //     var test = "test.php"
  //     $.get("http://172.20.181.98/uploading/plogin.php",function(data){
  //       alert(data);
  //     });
  //     // var posting = $.post("",function(data){
  //     //   alert(data);
  //     // });
  //   });
  // });
  </script>
</body>
</html>
