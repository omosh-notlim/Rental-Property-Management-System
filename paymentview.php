<?php
    session_start();

    // error_reporting(0);

    include 'db_connection.php';
    include 'status.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">


    <title>Rent payments</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <!--  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

</head>
<body>
    <div class="btn">
        <i class="bi bi-list"></i>
        <i class="bi bi-x"></i>
    </div>
    <nav class="sidebar">
        <div class="text"><i class="bi bi-person-circle"></i> 
            <?php

            if(isset($_SESSION['mail'])){
                echo $_SESSION['mail'];
            }

            ?>
        </div>
        <ul>
            <li><a href="dashboard"><i class="bi bi-windows"></i>  Dashboard</a></li>
            <li><a href="landlordreports"><i class="bi bi-graph-down-arrow"></i> Landlord reports</a></li>
            <li><a href="ticketreading"><i class="bi bi-ticket-perforated"></i> View tickets</a></li>
            <li>
                <a href="#" class="serv-btn house-mng"><i class="bi bi-cash-coin"></i> 
                    Payment view <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="serv-show">
                    <li><a href="#rentview">View all</a></li>
                    <li><a href="#rentsearch">Rent search</a></li>
                </ul>
            </li>
            <li><a href="adminpanel"><i class="bi bi-house-door"></i> House management</a></li>
            <li><a href="adminpaneltwo"><i class="bi bi-people-fill"></i> User management</a></li>
            <li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
            <li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
            <li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>   Profile</a></li>
            <li><a href="logout"><i class="bi bi-toggles2"></i>    Switch account</a></li>
            <br>
            <br>
            <li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
        </ul>
    </nav>

    <div class="content-area">
        <div class="wrapper">
            <div id="rentview" class="myForm">
            <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>ALL RENT PAYMENTS</legend>

            <div class="table-users" id="all-users">
                <?php

                    $sql = "SELECT * FROM payments ORDER BY currentDate DESC";
                    $res_data = mysqli_query($db,$sql);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row = mysqli_fetch_array($res_data)){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['receiptnumber']; ?></td>
                        <td><?php echo $row['payerphone']; ?></td>
                        <td><?php echo $row['houseID']; ?></td>
                        <td><?php echo $row['tenantEmail']; ?></td>
                        <td><?php echo $row['landlordEmail']; ?></td>
                        <td><?php echo $row['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </table>
            </div>
            </fieldset>
            </form>
            </div>

            <!-- table two here -->
            <div id="rentsearch" class="myForm">
            <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>RENT PAYMENTS SEARCHING</legend>

            <div class="user-details">
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> Start date:  </label></span><br>
                    <input type="datetime-local" id="date-1" name="date-1">
                </div>
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> End date:  </label></span><br>
                    <input type="datetime-local" id="date-2" name="date-2">
                </div>
            </div>
            <div class="gen-bt">
                <div class="button button-2nd">
                    <input type="submit" name="find" value="SEARCH DATE"/>
                </div>
            </div>
            <hr>


            <div class="user-details">
                <div class="input-box">
                    <span class="details"><label for="searchinfo"> Search info:  </label></span><br>
                    <input type="text" name="searchinfo" id="searchinfo" placeholder="amount/receipt number/house id..." />
                </div>
            </div>
            <div class="gen-bt">
                <div class="button button-2nd">
                    <input type="submit" name="find2" value="FIND"/>
                </div>
            </div>
            <hr>

            <div class="table-users">
                <?php

                    $searchinfo = mysqli_real_escape_string($db, $_POST['searchinfo']);
                    $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                    $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                    if(isset($_POST['find'])){
                        $sql2 = "SELECT * from payments WHERE currentDate BETWEEN '$date_1' AND '$date_2' ORDER BY currentDate DESC";
                    
                    $res_data2 = mysqli_query($db,$sql2);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row2 = mysqli_fetch_array($res_data2)){
                    ?>
                    <tr>
                        <td><?php echo $row2['id']; ?></td>
                        <td><?php echo $row2['payment_id']; ?></td>
                        <td><?php echo $row2['amount']; ?></td>
                        <td><?php echo $row2['receiptnumber']; ?></td>
                        <td><?php echo $row2['payerphone']; ?></td>
                        <td><?php echo $row2['houseID']; ?></td>
                        <td><?php echo $row2['tenantEmail']; ?></td>
                        <td><?php echo $row2['landlordEmail']; ?></td>
                        <td><?php echo $row2['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    }elseif(isset($_POST['find2'])){
                        $sql2 = "SELECT * from payments WHERE id='$searchinfo' or payment_id='$searchinfo' or amount='$searchinfo' or receiptnumber='$searchinfo' or payerphone='$searchinfo' or houseID='$searchinfo' or tenantEmail='$searchinfo' or landlordEmail='$searchinfo'";
                    
                    $res_data2 = mysqli_query($db,$sql2);
                    ?>
                    <table>
                        <tr>
                            <th>Transaction number</th>
                            <th>Payment ID</th>
                            <th>Amount (KSH)</th>
                            <th>Receipt number</th>
                            <th>Phone number</th>
                            <th>House ID</th>
                            <th>Tenant email</th>
                            <th>Landlord email</th>
                            <th>Date-Time (Y-M-D)</th>
                        </tr>
                    
                    <?php
                    while($row2 = mysqli_fetch_array($res_data2)){
                    ?>
                    <tr>
                        <td><?php echo $row2['id']; ?></td>
                        <td><?php echo $row2['payment_id']; ?></td>
                        <td><?php echo $row2['amount']; ?></td>
                        <td><?php echo $row2['receiptnumber']; ?></td>
                        <td><?php echo $row2['payerphone']; ?></td>
                        <td><?php echo $row2['houseID']; ?></td>
                        <td><?php echo $row2['tenantEmail']; ?></td>
                        <td><?php echo $row2['landlordEmail']; ?></td>
                        <td><?php echo $row2['currentDate']; ?></td>
                    </tr>
                    <?php
                    }
                    }
                    ?>
                    </table>    
                 </div>
            </fieldset>
            </form>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="scrolljQuery.js"></script>
    <script>
        $('.btn').click(function(){
            $(this).toggleClass("click");
            $('.sidebar').toggleClass("show");
        });

        $('.feat-btn').click(function(){
            $('nav ul .feat-show').toggleClass("show");
        });

        $('.serv-btn').click(function(){
            $('nav ul .serv-show').toggleClass("show1");
        });

        $('nav ul li').click(function(){
            $(this).addClass("active").siblings().removeClass("active");
        });

    </script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <!-- <script src="swiperjQuery.js"></script> -->

    <script>
        const swiper = new Swiper('.swiper', {
            // autoplay: {
            //     delay: 10000,
            //     disableOnInteraction: false,
            // },

            loop: true,

            pagination:{
                el: '.swiper-pagination',
                // clickable: true,
            },

  
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

    </script>
</body>
</html>