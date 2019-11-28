<?php include "init.php";?>
    <div class='container'>
        <h1 class='text-center'><?php echo str_replace('-',' ',$_GET['name']); ?></h1>
        <div class='row'>
        <?php
            $id = $_GET['id'];
            if(empty(getItems($id))){
                echo "<div class='alert alert-info'>There is no items in this categorie</div>";
            } else {
                foreach(getItems($id) as $item){
                    echo "<div class='col-sm-6 col-md-3'>";
                        echo "<div class='thumbnail item-box'>";
                            echo "<span class='badge bade-dark price-tag'>".$item['Price']."</span>";
                            echo "<img class='img-responsive' src='empty.jpg' alt='This Photo Doesn't Exist' width='350px' height='300px'>";
                            echo "<div class='caption'>";
                                echo "<h3>". $item['Name'] ."</h3>";
                                echo "<p>".$item['Description']."</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            }
        ?>
        </div>
    </div>
<?php include $tpl . "footer.php"; ?>