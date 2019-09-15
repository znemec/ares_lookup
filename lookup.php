<?php
mb_internal_encoding("UTF-8");
require __DIR__ . '/vendor/autoload.php';

// Using Medoo namespace
use Medoo\Medoo;

$msg = '';
// inicializace pro ARES
$ares_ico = "";
$ares_dic = "";
$ares_name = "";
$ares_address  = "";
$ares_n1  = "";
$ares_n2  = "";
$ares_city  = "";
$ares_zip  = "";
$ares_status = "";

if (isset($_GET['lookup'])) {
  $msg = 'Subjekt byl v ARES db nalezen a uložen.';
}

// vzor pro ICO
$pattern = '/^\d{8}$/';

if (isset($_POST["ico"])) {
  $ico = $_POST["ico"];
  if (preg_match($pattern, $ico)) {
    $file = @file_get_contents("http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=" . $ico);

    if ($file) {
      $xml = @simplexml_load_string($file);
    }

    if ($xml) {
      $ns = $xml->getDocNamespaces();
      $data = $xml->children($ns['are']);
      $el = $data->children($ns['D'])->VBAS;

      if (strval($el->ICO) == $ico) {
        $ares_ico = strval($el->ICO);
        $ares_dic = strval($el->DIC);
        $ares_name = strval($el->OF);
        $ares_address  = strval($el->AA->NU);
        $ares_n1  = strval($el->AA->CD);
        $ares_n2  = strval($el->AA->CO);
        if ($ares_n2 != "") {
          $ares_n = $ares_n1 . "/" . $ares_n2;
        } else {
          $ares_n = $ares_n1;
        }
        $ares_city  = strval($el->AA->N);
        $ares_zip  = strval($el->AA->PSC);
        $ares_status = 1;
        // DB connection
        $database = new Medoo([
          'database_type' => 'mysql',
          'database_name' => 'test',
          'server' => '127.0.0.1',
          'username' => 'root',
          'password' => '',
          "charset" => "utf8"
        ]);
        // insert row
        $database->insert("ares", [
          "ico" => $ares_ico,
          "name" => $ares_name,
          "address" => $ares_address . " " . $ares_n,
          "city" => $ares_city,
          "zip" => $ares_zip,
          "dic" => $ares_dic,
          "date" => date('d. m. Y. H:i')
        ]);
        // redirection
        header('Location: index.php?lookup=yes');
        exit;
      } else {
        $ares_status = 'IČO firmy nebylo nalezeno.';
      }
    } else {
      $ares_status = 'Databáze ARES není dostupná.';
    }
  } else {
    $ares_status = 'Zadané IČO nemá správný formát. (8 čísel)';
  }
}

?>

<div class="jumbotron">
  <div class="container">
    <h1>Vyhledávání podle IČO</h1>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="ico-box">
        <h2>Zadejte IČO pro vyhledání:</h2>
        <hr>
        <form method="POST">
          <fieldset>
            <div class="form-group">
              <label for="InputIco">IČO*</label>
              <input name="ico" type="number" class="form-control" id="InputIco" placeholder="Zadejte IČO pro vyhledání">
            </div>
            <button type="submit" class="btn btn-outline-secondary">ODESLAT</button>
          </fieldset>
        </form>
      </div>

      <?php
      // exceptions
      if ($ares_status) {
        echo ('<div class="alert alert-warning" role="alert">' . htmlspecialchars($ares_status) . '</div>');
        echo ('</div></div></div><footer class="footer">
        <div class="footer-copyright text-center py-3">© ' . date("Y") . ' Copyright:
            <a href="mailto:zdenek@nemec.pro"> Zdeněk Němec</a>
        </div>
        </footer>');
        exit;
      }
      // success
      if ($msg) {
        echo ('<p class="text-center">' . htmlspecialchars($msg) . '</p>');
        // DB connection
        $database = new Medoo([
          'database_type' => 'mysql',
          'database_name' => 'test',
          'server' => '127.0.0.1',
          'username' => 'root',
          'password' => '',
          "charset" => "utf8"
        ]);
        $result = $database->query("SELECT * FROM <ares> ORDER BY <id> DESC LIMIT 1")->fetchAll();

        echo ('<h3><p class="text-center">Výsledek vyhledávání</p></h3><div class="table-responsive"><table class="table table-hover table-fixed">');
        foreach ($result as $r) {
          echo ('<thead><tr>
          <th scope="col">IČO</th>
          <th scope="col">Název</th>
          <th scope="col">Ulice</th>
          <th scope="col">Město</th>
          <th scope="col">PSČ</th>
          <th scope="col">DIČ</th>
          <th scope="col">Datum vyhledání</th></thead>');
          echo ('<tr><td>' . htmlspecialchars($r['ico']));
          echo ('</td><td>' . htmlspecialchars($r['name']));
          echo ('</td><td>' . htmlspecialchars($r['address']));
          echo ('</td><td>' . htmlspecialchars($r['city']));
          echo ('</td><td>' . htmlspecialchars($r['zip']));
          echo ('</td><td>' . htmlspecialchars($r['dic']));
          echo ('</td><td>' . htmlspecialchars($r['date']));
        }
        echo ('</table></div>');
      }
      ?>

    </div>
  </div>
</div>