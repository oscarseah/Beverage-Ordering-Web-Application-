<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/healthtea/homestyle.css">
        <!-- logo beside the title -->
        <link rel="tab logo icon" href="/healthtea/images/1.png" type="image/x-icon">
        <!-- for house and people icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- for slide arrow icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>HealthTea | Home</title>
    </head>
    <body>
        <?php include('include/header.php'); ?>
        <div class="home">
            <div class="main_page">
                <div class="header_title">
                    <h1 style="color: rgb(90, 42, 0); font-size:70px;" class="title_home">Take a sip. <span>HealthTea</span></h1>
                    <p>Tranditional meet renovation. Every sip tells a story.</p>
                    <a href="/healthtea/listing_product_page">
                    <button class="red_button">Order Now <i class="fa-solid fa-arrow-right-long"></i></button>
                    </a>                
                </div>
            </div>
            <div class="slide_container">
            <i class="fa fa-arrow-right" aria-hidden="true" id="next_button"></i>
            <i class="fa fa-arrow-left" aria-hidden="true" id="previous_button"></i>
                <div class="slide">
                <img src="/healthtea/images/SS1.png" id="lastClone" alt="">
                <img src="/healthtea/images/SS2.png" alt="">
                <img src="/healthtea/images/SS3.png" alt="">
                <img src="/healthtea/images/SS4.png" alt="">
                <img src="/healthtea/images/SS1.png" id="firstClone" alt="">
                </div>
            </div>
            
            <div class="product_box">
                <div class="item">
                    <div>
                        <img src="/healthtea/images/Jasmine Peach Tea.jpg" alt="drink1">
                    </div>
                    <h3>Jasmine Peach Tea</h3>
                    <p></p>
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=8">
                    <button class="white_button">More details</button>
                    </a>
                </div>
                <div class="item">
                    <div>
                        <img src="/healthtea/images/Tie Guan Yin Coconut Tea.jpg" alt="drink2">
                    </div>
                    <h3>Tie Guan Yin Coconut Tea</h3>
                    <p></p>
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=4">
                    <button class="white_button">More details</button>
                    </a>
                </div>
                <div class="item">
                    <div>
                        <img src="/healthtea/images/Tie Guan Yin Coconut Frappe.jpg" alt="drink3">
                    </div>
                    <h3>Tie Guan Yin Coconut Frappe</h3>
                    <p></p>
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=7">
                    <button class="white_button">More details</button>
                    </a>
                </div>
            </div>
            <div class="new_product_page">
                <div class="leaf">
                    <img src="/healthtea/images/leaf.jpg" alt="">
                </div>
                <div class="new_product_title">
                <div>
                    <h2>New Products</h2>
                </div>
                <div>
                    <div class="new_product_list">
                        <a href="/healthtea/listing_product_page/itemdetailpage.php?id=2">
                        <div>
                            <img src="/healthtea/images/newproduct1.png" alt="">
                        
                        </div>
                        </a>
                        <div>
                            <h4>Melon Oolong Tea</h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="new_product_list">
                        <a href="/healthtea/listing_product_page/itemdetailpage.php?id=3">
                        <div>
                            <img src="/healthtea/images/newproduct2.png" alt="">
                        </div>
                        </a>
                        <div>
                            <h4>Melon Oolong Macchiato</h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="new_product_list">
                        <a href="/healthtea/listing_product_page/itemdetailpage.php?id=1">
                        <div>
                            <img src="/healthtea/images/newproduct3.png" alt="">
                        </div>
                        </a>
                        <div>
                            <h4>Royale Fruit Oolong Tea</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="hot_product_page">
                <div class="hot_product_title">
                    <h3>Best Sellers</h3>
                </div>
                <div class="hot_product_menu">
                    <div class="item">
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=5">
                        <div>
                            <img src="/healthtea/images/Fresh Watermelon Tea.jpg" alt="">
                        </div>
                        <h3>Fresh Watermelon Tea</h3>
                        <p></p>
                        <p class="hot_product_price">RM13.50</p>
                    </a>
                    </div>
                    <div class="item">
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=6">
                        <div>
                            <img src="/healthtea/images/Fresh Lemon Green Tea.jpg" alt="">
                        </div>
                        <h3>Fresh Lemon Green Tea</h3>
                        <p></p>
                        <p class="hot_product_price">RM12.50</p>
                    </a>
                    </div>
                    <div class="item">
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=9">
                        <div>
                            <img src="/healthtea/images/Fresh Kiwi Oolong Tea.jpg" alt="">
                        </div>
                        <h3>Fresh Kiwi Oolong Tea</h3>
                        <p></p>
                        <p class="hot_product_price">RM12.50</p>
                    </a>
                    </div>
                    <div class="item">
                    <a href="/healthtea/listing_product_page/itemdetailpage.php?id=10">
                        <div>
                            <img src="/healthtea/images/Fresh Grapefruit Jasmine Tea.jpg" alt="">
                        </div>
                        <h3>Fresh Grapefruit Jasmine Tea</h3>
                        <p></p>
                        <p class="hot_product_price">RM12.50</p>
                    </a>
                    </div>
                </div>
                <div class="dsgn"></div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
        <script src="app.js"></script>
    </body>
</html>