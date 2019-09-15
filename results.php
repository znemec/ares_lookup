<div class="jumbotron">
    <div class="container">
        <h1>Výsledky vyhledávání</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            mb_internal_encoding("UTF-8");
            require __DIR__ . '/vendor/autoload.php';
            // Using Medoo namespace
            use Medoo\Medoo;

            $database = new Medoo([
                'database_type' => 'mysql',
                'database_name' => 'test',
                'server' => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                "charset" => "utf8"
            ]);

            if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                $page_no = $_GET['page_no'];
            } else {
                $page_no = 1;
            }
            $total_records_per_page = 3;
            $offset = ($page_no - 1) * $total_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $adjacents = "2";
            $total_records = $database->count("ares");
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1;


            $orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "id";
            $order = !empty($_GET["order"]) ? $_GET["order"] : "desc";

            $nameOrder = "asc";
            $dateOrder = "asc";

            if ($orderBy == "name" && $order == "asc") {
                $nameOrder = "desc";
            }
            if ($orderBy == "date" && $order == "asc") {
                $dateOrder = "desc";
            }
            $result = $database->query("SELECT * FROM <ares> ORDER BY $orderBy $order LIMIT $total_records_per_page OFFSET $offset")->fetchAll();

            ?>

            <h2>
                <p class="text-center">Výsledek vyhledávání</p>
            </h2>
            <div class="table-responsive">
                <table class="table table-hover table-fixed">
                    <thead>
                        <tr>
                            <th scope="col">IČO</th>
                            <th scope="col"><a href="?page=results&orderby=name&order=<?php echo $nameOrder; ?>">Název</a></th>
                            <th scope="col">Ulice</th>
                            <th scope="col">Město</th>
                            <th scope="col">PSČ</th>
                            <th scope="col">DIČ</th>
                            <th scope="col"><a href="?page=results&orderby=date&order=<?php echo $dateOrder; ?>">Datum vyhledání</a></th>
                    </thead>

                    <?php
                    foreach ($result as $r) {
                        echo ('<tr><td>' . htmlspecialchars($r['ico']));
                        echo ('</td><td>' . htmlspecialchars($r['name']));
                        echo ('</td><td>' . htmlspecialchars($r['address']));
                        echo ('</td><td>' . htmlspecialchars($r['city']));
                        echo ('</td><td>' . htmlspecialchars($r['zip']));
                        echo ('</td><td>' . htmlspecialchars($r['dic']));
                        echo ('</td><td>' . htmlspecialchars($r['date']));
                    }
                    ?>

                </table>
            </div>

            <ul class="pagination">

                <?php if ($page_no > 1) {
                    echo "<li><a class='page-link' href='?page=results&&page_no=1'>První</a></li>";
                } ?>

                <li <?php if ($page_no <= 1) {
                        echo "class='disabled'";
                    } ?>>
                    <a class="page-link" <?php if ($page_no > 1) {
                                                echo "href='?page=results&&page_no=$previous_page'";
                                            } ?>>Předchozí</a>
                </li>

                <li <?php if ($page_no >= $total_no_of_pages) {
                        echo "class='disabled'";
                    } ?>>
                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                                                echo "href='?page=results&&page_no=$next_page'";
                                            } ?>>Další</a>
                </li>

                <?php if ($page_no < $total_no_of_pages) {
                    echo "<li><a class='page-link' href='?page=results&&page_no=$total_no_of_pages'>Poslední</a></li>";
                } ?>
            </ul>

            <div style='padding: 10px 10px 20px 10px;'>
                <strong>Stránka <?php echo $page_no . " z " . $total_no_of_pages; ?></strong>
            </div>
        </div>
    </div>
</div>