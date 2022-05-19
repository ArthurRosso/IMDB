<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/imdb/">IMDb</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/imdb/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Notícias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Filmes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Celebs</a>
          </li>
          <?php
            // Error handling
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            require_once("config.php");

            if(isset($_COOKIE['email'])){
              $email = $_COOKIE['email'];
              $sql = "SELECT NOME FROM USUARIO WHERE email = '$email';";
              $name = pg_fetch_assoc(pg_query($link, $sql))['nome'];
              echo "<li class='nav-item'>";
              echo "  <a class='nav-link' href='/imdb/'>$name</a>";
              echo "</li>";
              echo "<li class='nav-item'>";
              echo "  <a class='nav-link' href='/imdb/logout.php'>Logout</a>";
              echo "</li>";
            } else {
              echo "<li class='nav-item'>";
              echo "  <a class='nav-link' href='/imdb/login.html'>Login</a>";
              echo "</li>";
            }
          ?>
        </ul>
      </div>
    </div>
  </nav>