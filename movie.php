<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Movie - IMDb</title>
  </head>
  <body>
  <?php
    require_once("navbar.php");
  ?>
  <div class="container">
    <div class="card">
  <?php
  // Error handling
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("config.php");

  $cod = $_GET["cod"];
  $sql1 = "SELECT * FROM PROGRAMA WHERE COD = '$cod';";
  if ($res = pg_query($link, $sql1)) {
    $lin = pg_fetch_assoc($res);
    echo "<img src='/imdb/images/" . $lin['cod'] . ".jpeg' class='card-img-top' alt='Image not found'>";
    echo "<div class='card-body'>";
    echo "<h3 class='card-title'>" . $lin['titulo_original'] . "</h3>";
    echo "<p class='card-text'>" . $lin['sinopse'] . "</p>";
  } else {
    echo"<script language='javascript' type='text/javascript'>alert('Filme não cadastrado');window.location.href='/imdb/';</script>";
  }
  ?>      
      <div class="d-grid gap-2 mb-3">
        <button class="btn btn-primary" type="button">Adicionar na sua watchlist</button>
      </div>
      <div class="mb-3 row">
        <div class="col-9">
          <select class="form-select">
            <option selected disabled>Avaliar</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary">Enviar avaliação</button>
        </div>
      </div>
      <h5 class="mb-3">TAG</h5>
      <div class="list-group mb-3">
      <?php
      $sql = "SELECT tag.nome AS tnome
              FROM programa
                INNER JOIN programa_tag ON programa.cod = cod_programa
                INNER JOIN tag ON tag.cod = cod_tag
              WHERE programa.cod = $cod;";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          $count = 0;
          while ($row = pg_fetch_assoc($result)) {
            echo "<a href='#' class='list-group-item list-group-item-action'>". $row['tnome'] . "</a>";
          }
        }
      }
      ?>
      </div>
      <h5 class="mb-3">Elenco</h5>
      <div class="list-group mb-3">
        <?php
        $sql = "SELECT pessoa.nome AS pnome
                FROM programa
                  INNER JOIN participa_como ON programa.cod = cod_programa
                  INNER JOIN pessoa ON pessoa.cod = cod_pessoa
                WHERE programa.cod = $cod;";
        if ($result = pg_query($link, $sql)) {
          if (pg_num_rows($result) > 0) {
            $count = 0;
            while ($row = pg_fetch_assoc($result)) {
              echo "<a href='#' class='list-group-item list-group-item-action'>". $row['pnome'] . "</a>";
            }
          } else {
            echo "<p>Sem elenco registrado</p>";
          }
        }
        ?>
      </div>
      <h5 class="mb-3">Comentários</h5>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Filme top</h5>
          <h6 class="card-subtitle mb-2 text-muted">Postado por User drop table</h6>
        </div>
      </div>
      <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
        <label for="floatingTextarea">Adicionar comentário</label>
      </div>
      <button type="submit" class="btn btn-primary">Enviar comentário</button>
    </div>
  </div>    

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
  </body>
</html>
