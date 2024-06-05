<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css?<?php echo filemtime('css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="fonts/uicons-bold-straight/css/uicons-bold-straight.css" />    
    <title>Корзина</title>
</head>
<body class="text-center">
    <?php
    require ('template/header.php');

    require ('template/log_reg_block.php');

    require 'inc/config.inc.php';

    function setArrayInCookie($nameCookies, $array){
        $value = serialize($array);
        setcookie($nameCookies, $value, time()+3600*24*365);
        return true;
    }
    function getArrayInCookie($nameCookies){
        if(isset($_COOKIE[$nameCookies])){
            $result = unserialize($_COOKIE[$nameCookies]);
        }else{
            $result = false;
        }
        return $result;
    }

    if(!isset($_COOKIE["shop_php"])){
        echo 'Вы не выбрали ни одного товара';   
    }else{
        $arr = getArrayInCookie('shop_php');
        ?><div class="title_str"><h1>Корзина</h1></div>
        <div class="line-grad-h"></div>
        <div class="content-line main">
            <div class="content-area">
                <div class="cart_prods">
                    <?php 
                    $itg = 0;
                    foreach ($arr as $key => $value) {
                        /*echo('<br>---');
                        print_r($value['tek_prod_id']);
                        echo('---<br>');*/                        
                        $id_prod = $value['tek_prod_id'];
                        $kolvo = $value['kolvo'];
                        $query_prod = "SELECT * FROM `products` WHERE id=$id_prod";
                        $result_prod = mysqli_query($db, $query_prod);
                        while($row_prods = $result_prod->fetch_assoc()){
                            $pod_itg = $kolvo*$row_prods['price']
                            ?>
                            <div class="cart_prod">
                                <div class="title_block">
                                    <h2><?php echo $row_prods['name']; ?></h2>
                                </div>
                                <div class="img_prod_cart">
                                    <img src="product_imgs/<?php echo $row_prods['file']; ?>">
                                </div>
                                <div class="cart_info">
                                    <div class="price">Цена: <?php echo $row_prods['price'] . ' ₽'; $itg = $itg + $pod_itg; ?></div>
                                    <div class="quantity">Количество: <?php echo $kolvo; ?></div>
                                    <div class="quantity">Подитог: <?php echo $kolvo*$row_prods['price']; ?> ₽</div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                    <div class="itog_block">
                        <div>Итог: <?php echo $itg; ?> ₽</div>
                    </div>
                </div> 
            </div> 
        </div> 
        <?php
    }
    ?>
    <?php

/*
    $query_prod = "SELECT id FROM products";
    $result_prod = mysqli_query($db, $query_prod);
*/

    require ('template/footer.php');
    ?>
    <script src="js/jQuery-v3.5.1.js"></script>
    <script src="js/products.js?<?php echo filemtime('js/products.js') ?>"></script>
    <script src="js/jquery.cookies.js"></script>
</body>

</html>