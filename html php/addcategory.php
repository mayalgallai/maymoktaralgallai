<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit();
  }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $type = $_POST["type"];
  $cost = $_POST["cost"];
  $user_id = $_SESSION["user_id"];

  require_once "database.php";

  $conn = mysqli_connect($servername, $dbusername ,$dbpassword , $dbname );


  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

 
  $stmt = $conn->prepare("INSERT INTO categories_info (category_name, category_cost, user_id) VALUES (?, ?, ?)");
  $stmt->bind_param("sdi", $type, $cost, $user_id);


  if ($stmt->execute() === TRUE) {
   
    header("Location: categories.php");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

 
  $stmt->close();
  $conn->close();
}
?>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/home.css">
</head>
<body>
  <div class="navbar">
    <div class="navbarcon">
      <a href="home_with_user_info.php" id="navbarlogo"> EXPENSE TRUCKER </a>
      <div class="navbartoggle" id="mobilemenu"></div>
      <ul class="navbarmenu">
        <li class="navbaritm"> 
          <a href="" class="navbarlink" id="homepage">features </a>
        </li>
        <li class="navbaritm"> 
          <a href="#" class="navbarlink" id="aboutpage"> our reviews</a>
        </li>
        <li class="navbaritm"> 
          <a href="aboutus.html" class="navbarlink" id="servicespage"> about us</a>
        </li>
        <li class="navbaritm"> 
        </li>
        <li class="navbaritm"> 
          <h4 class="navbarlink" id="servicespage"> <?php echo $_SESSION["username"]; ?></h4>   
        </li>
        <li class="navbaritm"> 
          <form method="post">
            <button type="submit" name="logout"  class="button" id="servicespage">  logout</button>
          </form>
        </li>

      </ul>
    </div>
  </div> 
  <main class="main">
    <div class="image">
      <img src="../img/budget.png" alt="">
    </div>
    <form method="post">
      <h5> Fill in the blanks if you want to add a category</h5>
      <p>____________________________________</p>
      <h4>type</h4>
      <input type="text" name="type" placeholder="name" class="input">
      <h4>cost</h4>
      <input type="text" name="cost" placeholder="cost" class="input">
      <div class="btn">
        <button class="btn1" type="submit" name="submit" value="add category">add category</button>
      </div>
    </form>
  </main>
</body>
</html>