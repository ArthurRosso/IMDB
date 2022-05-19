<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Home - IMDb</title>
  </head>
  <body>
  <?php
  require_once("navbar.php");
  ?>
  <div class="container">
  <div class="card mt-2 mb-3">
    <div class="card-header">
      Trending Topics
    </div>
    <div class="card-body">
      <div class="row">
      <h4>Quantos programas cada usuario assistiu e qual sua media de notas </h4>
      <?php
      $sql = "SELECT
                usuario.nome AS unome,
                AVG(nota) AS avg_nota,
                COUNT(titulo_original) AS num_programas
              FROM usuario
                INNER JOIN usuario_programa_lista ON usuario.cod = usuario_programa_lista.cod_usuario
                INNER JOIN programa ON programa.cod = usuario_programa_lista.cod_programa
              GROUP BY usuario.nome;";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Nome</th>";
          echo "<th scope='col'>Média</th>";
          echo "<th scope='col'>Número de programas</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['unome'] . "</td>";
            echo "<td>" . $row['avg_nota'] . "</td>";
            echo "<td>" . $row['num_programas'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }      
      ?>
      </div>
      <?php
      echo "<form name='form' action='' method='post'>";
      echo "<input type='text' name='pais1' id='pais1'>";
      echo "<input type='submit'>";
      echo "</form>";
      if(array_key_exists('pais1', $_POST)){
        $pais1 = "'" . $_POST['pais1']."'";
      } else {
        $pais1 = "'Brasil'";
      }
      echo "<div class='row'><h4>Programas lançados no $pais1 com media de avaliacao de usuarios maior que 7</h4>";
      $sql = "SELECT
                AVG(nota) AS avg_nota,
                traducao.titulo AS ttitulo
              FROM programa
                INNER JOIN usuario_programa_lista ON programa.cod = usuario_programa_lista.cod_programa
                INNER JOIN traducao ON programa.cod = traducao.cod_programa
                INNER JOIN lugar ON lugar.cod = traducao.cod_lugar
              WHERE lugar.nome = $pais1
              GROUP BY traducao.titulo
              HAVING AVG(nota) >= 7
              ORDER BY avg_nota DESC;";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Nome</th>";
          echo "<th scope='col'>Média</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['ttitulo'] . "</td>";
            echo "<td>" . $row['avg_nota'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }         
      ?>
      </div>
      <?php
      echo "<form name='form' action='' method='post'>";
      echo "<input type='text' name='pais2' id='pais2'>";
      echo "<input type='submit'>";
      echo "</form>";
      if(array_key_exists('pais2', $_POST)){
        $pais2 = "'" . $_POST['pais2']."'";
      } else {
        $pais2 = "'Brasil'";
      }
      echo "<div class='row'><h4>Nome de usuários que assistiram programas que não lançaram no $pais2</h4>";
      $sql = "SELECT
                DISTINCT usuario.nome AS unome
              FROM usuario
                INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
              WHERE cod_programa NOT IN (
                SELECT programa.cod
                FROM programa
                  INNER JOIN traducao ON programa.cod = cod_programa
                  INNER JOIN lugar ON lugar.cod = cod_lugar
                WHERE lugar.nome = $pais2);";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Nome</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['unome'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }       
      ?>
      </div>
      <?php
      echo "<form name='form' action='' method='post'>";
      echo "<input type='text' name='pais3' id='pais3'>";
      echo "<input type='submit'>";
      echo "</form>";
      if(array_key_exists('pais3', $_POST)){
        $pais3 = "'" . $_POST['pais3']."'";
      } else {
        $pais3 = "'Brasil'";
      }
      echo "<div class='row'><h4>Diretores que não tiveram nenhum programa lançado no $pais3</h4>";
      $sql = "SELECT DISTINCT pessoa.nome AS pnome
              FROM pessoa
                INNER JOIN participa_como ON pessoa.cod = cod_pessoa
                INNER JOIN cargo ON cargo.cod = cod_cargo
              WHERE cargo.nome = 'Diretor' AND pessoa.cod NOT IN (
                SELECT cod_pessoa
                FROM programa
                  INNER JOIN traducao ON programa.cod = cod_programa
                  INNER JOIN lugar ON lugar.cod = cod_lugar
                  LEFT JOIN participa_como ON programa.cod = participa_como.cod_programa
                  INNER JOIN cargo ON cargo.cod = cod_cargo
                WHERE lugar.nome = $pais3
                  AND cargo.nome = 'Diretor');";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Nome</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['pnome'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }            
      ?>
      </div>
      <div class="row">
      <h4>Nome de filmes e seus diretores que nao possuem traducao do pais de origem no banco de dados</h4>
      <?php
      $sql = "SELECT 
                titulo_original,
                ano,
                tipo,
                pessoa.nome AS diretor
              FROM programa
                INNER JOIN participa_como ON programa.cod = cod_programa
                INNER JOIN pessoa ON pessoa.cod = cod_pessoa
                INNER JOIN cargo ON cargo.cod = cod_cargo
              WHERE NOT EXISTS (
                  SELECT titulo
                  FROM traducao
                  WHERE programa.titulo_original = traducao.titulo
                )
                AND cargo.nome = 'Diretor';";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "<th scope='col'>Data de lançamento</th>";
          echo "<th scope='col'>Tipo</th>";
          echo "<th scope='col'>Diretor</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['titulo_original'] . "</td>";
            echo "<td>" . $row['ano'] . "</td>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['diretor'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }        
      ?>
      </div>
      <div class="row">
      <h4>O nome e data de lancamento de todos filmes dirigidos por kurosawa que foram lançados nos EUA</h4>
      <?php
      $sql = "CREATE OR REPLACE VIEW lancados_EUA AS
              SELECT
                programa.cod,
                traducao.titulo,
                traducao.data_lanc
              FROM programa
                INNER JOIN traducao ON programa.cod = cod_programa
                INNER JOIN lugar ON lugar.cod = cod_lugar
              WHERE lugar.nome = 'EUA'
                AND programa.tipo = 'Filme';";
      pg_query($link, $sql);
      $sql = "SELECT
                titulo,
                data_lanc
              FROM lancados_EUA
                INNER JOIN participa_como ON lancados_EUA.cod = cod_programa
                INNER JOIN pessoa ON pessoa.cod = cod_pessoa
                INNER JOIN cargo ON cargo.cod = cod_cargo
              WHERE pessoa.nome = 'Akira Kurosawa'
                AND cargo.nome = 'Diretor';";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "<th scope='col'>Data de lançamento</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['titulo'] . "</td>";
            echo "<td>" . $row['data_lanc'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }        
      ?>
      </div>
      <div class="row">
      <h4>Filmes que lançaram nos EUA mas não foram produzidos nos EUA</h4>
      <?php
      $sql = "CREATE OR REPLACE VIEW lancados_EUA AS
              SELECT
                programa.cod,
                traducao.titulo,
                traducao.data_lanc
              FROM programa
                INNER JOIN traducao ON programa.cod = cod_programa
                INNER JOIN lugar ON lugar.cod = cod_lugar
              WHERE lugar.nome = 'EUA'
                AND programa.tipo = 'Filme';";
      pg_query($link, $sql);
      $sql = "SELECT
                titulo,
                ano,
                lugar.nome AS pais_origem
              FROM lancados_EUA
                INNER JOIN programa ON lancados_EUA.cod = programa.cod
                INNER JOIN lugar ON origem = lugar.cod
              WHERE lugar.nome != 'EUA';";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "<th scope='col'>Ano</th>";
          echo "<th scope='col'>Pais de origem</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['titulo'] . "</td>";
            echo "<td>" . $row['ano'] . "</td>";
            echo "<td>" . $row['pais_origem'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }        
      ?>
      </div>
      <div class="row">
      <h4>Programas avaliados pelo usuario 'Crítico do Oscar'</h4>
      <?php
      $sql = "SELECT
                ano,
                titulo_original,
                nota,
                texto
              FROM programa
                INNER JOIN usuario_programa_lista ON cod_programa = programa.cod
                INNER JOIN usuario ON usuario.cod = cod_usuario
              WHERE usuario.nome = 'Crítico do Oscar';";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "<th scope='col'>Nota</th>";
          echo "<th scope='col'>Texto</th>";
          echo "<th scope='col'>Ano</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['titulo_original'] . "</td>";
            echo "<td>" . $row['nota'] . "</td>";
            echo "<td>" . $row['texto'] . "</td>";
            echo "<td>" . $row['ano'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }            
      ?>
      </div>
      <div class="row">
      <h4>Usuários que assistiram apenas series e quais series ele assistiu</h4>
      <?php
      $sql = "SELECT
                nome,
                titulo_original
              FROM usuario
                INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
                INNER JOIN programa ON programa.cod = cod_programa
              WHERE usuario.cod NOT IN (
                SELECT usuario.cod
                FROM usuario
                  INNER JOIN usuario_programa_lista ON usuario.cod = cod_usuario
                  INNER JOIN programa ON programa.cod = cod_programa
                WHERE programa.tipo != 'Série');";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Nome</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['titulo_original'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }         
      ?>
      </div>
      <div class="row">
      <h4>Programas de drama que não são de ação</h4>
      <?php
      $sql = "SELECT
                tipo,
                ano,
                titulo_original
              FROM programa
                INNER JOIN programa_tag ON programa.cod = cod_programa
                INNER JOIN tag ON cod_tag = tag.cod
              WHERE tag.nome = 'Drama'
                AND programa.cod NOT IN (
                  SELECT programa.cod
                  FROM programa
                    INNER JOIN programa_tag ON programa.cod = cod_programa
                    INNER JOIN tag ON cod_tag = tag.cod
                  WHERE tag.nome = 'Ação');";
      if ($result = pg_query($link, $sql)) {
        if (pg_num_rows($result) > 0) {
          echo "<table class='table'>";
          echo "<thead>";
          echo "<tr>";
          echo "<th scope='col'>#</th>";
          echo "<th scope='col'>Tipo</th>";
          echo "<th scope='col'>Titulo</th>";
          echo "<th scope='col'>Ano</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";
          $cont = 1;
          while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
            echo "<th scope='row'>$cont</th>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['titulo_original'] . "</td>";
            echo "<td>" . $row['ano'] . "</td>";
            echo "</tr>";
            $cont += 1;
          }
          echo "</tbody>";
          echo "</table>";

          pg_free_result($result);
        } else {
          echo "<p><em>No records were found.</em></p>";
        }
      } else {
        echo "ERROR: Could not able to execute $sql. ";
      }             
      ?>
      </div>
    </div>
  </div>

    <?php
    $sql = "SELECT * FROM PROGRAMA;";
    if ($result = pg_query($link, $sql)) {
      if (pg_num_rows($result) > 0) {
        $count = 0;
        while ($row = pg_fetch_assoc($result)) {
          if($count % 3 == 0){
            echo "<div class='row'>";
          }
          echo "<div class='col-sm-4'>";
          echo "<div class='card' style='width: 22rem;'>";
          $sqli = "SELECT caminho FROM IMAGEM WHERE COD = ". $row['cod'] . ";";
          if ($res = pg_query($link, $sqli)) {
            if (pg_num_rows($res) > 0) {
              while ($linha = pg_fetch_assoc($res)) {
                echo "<img src='" . $linha['caminho'] . "' class='card-img-top' alt='Image not found'>";
                break;
              }
            }
          }
          echo "<div class='card-body'>";
          echo "<h5 class='card-title'>" . $row['titulo_original'] . "</h5>";
          echo "<p class='card-text'>" . $row['sinopse'] . "</p>";
          echo "<a href='/imdb/movie.php?cod=" . $row['cod'] . "' class='btn btn-primary'>Mais informações</a>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
          $count += 1; 
          if($count % 3 == 0){
            echo "</div>";
            $count = 0; 
          }
        }
        pg_free_result($result);
      } else {
        echo "<p class='lead'><em>No records were found.</em></p>";
      }
    } else {
      echo "ERROR: Could not able to execute $sql. ";
    }
    ?>
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