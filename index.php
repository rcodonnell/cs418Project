<?php
session_start();
include('config.php');

if($_SESSION['status'] !='authorized') {
  header("location: login.php");
  die();
}

$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)  or
  die('There was a problem connecting to the database');

$query = mysqli_query($link, "
  SELECT id, title, score
  FROM question
  ORDER BY score DESC
  LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
      <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>

</head>

<body>
  <nav class="lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper"><a id="logo-container" href="#" class="brand-logo">Welcome "<?php echo $_SESSION['user_id'];?>!"</a>
        <ul class="right">
          <li><a href="login.php?status=loggedout">Log Out</a></li>
        </ul>
        <ul class="right">
          <li><a href="askQuestion.php">Ask a question</a></li>
        </ul>
        <ul class="right">
          <li><a href="index.php">Home</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
          <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2>List of Questions</h2>
    <?php while($row = mysqli_fetch_array($query)): ?>
      <div class="question">
        <p><?php
        $url = 'displayQuestion.php?question_id=' . $row['id'];
        $site_title = $row['title'];
        echo "<a href=$url><em>Rating: </em>".$row['score']." <em>Title: </em>$site_title</a>" ?></p>
      </div>
    <?php endwhile?>
    <?php mysqli_close($link); ?>
  </div>
</body>
</html>
