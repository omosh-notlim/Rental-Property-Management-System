<?php

    session_start();

    error_reporting(0);
    include 'db_connection.php';
    include 'status.php';
?>

<?php
    $landlord = $_SESSION['mail'];

    $line_query = "SELECT * FROM landlords_report where landlordEmail='$landlord'";
    $line_query_run = mysqli_query($db, $line_query);

    $line_row = mysqli_fetch_assoc($line_query_run);

    $test = array( 
        array("y" => $line_row['January'], "label" => "January" ),
        array("y" => $line_row['February'], "label" => "February" ),
        array("y" => $line_row['March'], "label" => "March" ),
        array("y" => $line_row['April'], "label" => "April" ),
        array("y" => $line_row['May'], "label" => "May" ),
        array("y" => $line_row['June'], "label" => "June" ),
        array("y" => $line_row['July'], "label" => "July" ),
        array("y" => $line_row['August'], "label" => "August" ),
        array("y" => $line_row['September'], "label" => "September" ),
        array("y" => $line_row['October'], "label" => "October" ),
        array("y" => $line_row['November'], "label" => "November" ),
        array("y" => $line_row['December'], "label" => "December" ),
    );

    $bar_query = "SELECT * FROM landlords_report where landlordEmail='$landlord'";
    $bar_query_run = mysqli_query($db, $bar_query);

    $bar_row = mysqli_fetch_assoc($bar_query_run);

    $test2 = array( 
        array("y" => $bar_row['Y2021'], "label" => "2021" ),
        array("y" => $bar_row['Y2022'], "label" => "2022" ),
        array("y" => $bar_row['Y2023'], "label" => "2023" ),
        array("y" => $bar_row['Y2024'], "label" => "2024" ),
        array("y" => $bar_row['Y2025'], "label" => "2025" ),
        array("y" => $bar_row['Y2026'], "label" => "2026" ),
        array("y" => $bar_row['Y2027'], "label" => "2027" ),
        array("y" => $bar_row['Y2028'], "label" => "2028" ),
        array("y" => $bar_row['Y2029'], "label" => "2029" ),
        array("y" => $bar_row['Y2030'], "label" => "2030" ),
    );              
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="adminPanel.css">
    <link rel="stylesheet" href="fontboot/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js" integrity="sha512-t2JWqzirxOmR9MZKu+BMz0TNHe55G5BZ/tfTmXMlxpUY8tsTo3QMD27QGoYKZKFAraIPDhFv56HLdN11ctmiTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script>
        window.onload = function () {
         
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Income Generated (Last 12 Months)"
                },
                axisY: {
                    title: "Amount(KSH)"
                },
                data: [{
                    type: "line",
                    dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                theme: "light1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Income Generated Per Year"
                },
                axisY: {
                    title: "Amount(KSH)"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($test2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart2.render();


            // -------Charts download function
            $("#exportButton").click(function(){
                var pdf = new jsPDF('landscape');
                var chartTheme = chart.get("theme");
                chart.set("theme", "light2");
                var canvas = $("#chartContainer .canvasjs-chart-canvas").get(0);
                var dataURL = canvas.toDataURL();
                chart.set("theme", chartTheme);
                pdf.addImage(dataURL, 'JPEG',15, 15);
                pdf.save("monthly income.pdf");
            });

            $("#exportButton2").click(function(){
                var pdf2 = new jsPDF('landscape');
                var chartTheme2 = chart2.get("theme");
                chart2.set("theme", "light1");
                var canvas2 = $("#chartContainer2 .canvasjs-chart-canvas").get(0);
                var dataURL2 = canvas2.toDataURL();
                chart2.set("theme", chartTheme2);
                pdf2.addImage(dataURL2, 'JPEG',15, 15);
                pdf2.save("yearly income.pdf");
            });
        }
    </script>


    <title>Dashboard</title>
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
        <ul><li>
                <a href="#" class="serv-btn house-mng"><i class="bi bi-windows"></i> 
                    Dashboard <i class="bi bi-caret-down-fill"></i>
                </a>
                <ul class="serv-show">
                    <li><a href="#rentsearch">Rent search</a></li>
                    <li><a href="#myhouses">My houses</a></li>
                </ul>
            </li>
            <li><a href="home"><i class="bi bi-house-fill"></i> Houses</a></li>
            <li><a href="about#contact-us-now"><i class="bi bi-body-text"></i> Raise ticket</a></li>
            <li><a class="dropdown-item" href="profile"><i class="bi bi-person-lines-fill"></i>   Profile</a></li>
            <li><a href="logout"><i class="bi bi-toggles2"></i>   Switch account</a></li>
            <br>
            <br>
            <li><a href="logout">Logout <i class="bi bi-power"></i></a></li>
        </ul>
    </nav>

    <div class="content-area">
        <div class="wrapper">
            <div class="container-info">
                    <div class="info">
                        <h5>Total Houses</h5><br>
                        <?php
                            $landlord = $_SESSION['mail'];
                            $query = "SELECT COUNT(*) AS total FROM houseinfo WHERE landlordEmail='$landlord'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['total'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>Vaccant Houses</h5><br>
                        <?php
                            $landlord = $_SESSION['mail'];
                            $query = "SELECT COUNT(*) AS vaccant FROM houseinfo WHERE landlordEmail='$landlord' AND houseStatus='Vaccant'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['vaccant'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>Occupied Houses</h5><br>
                        <?php
                            $landlord = $_SESSION['mail'];
                            $query = "SELECT COUNT(*) AS occupied FROM houseinfo WHERE landlordEmail='$landlord' AND houseStatus='Occupied'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['occupied'].'</h4>';
                        ?>
                    </div>
                    <div class="info">
                        <h5>Sold Houses</h5><br>
                        <?php
                            $landlord = $_SESSION['mail'];
                            $query = "SELECT COUNT(*) AS sold FROM houseinfo WHERE landlordEmail='$landlord' AND houseStatus='Sold'";
                            $query_run = mysqli_query($db, $query);

                            $row = mysqli_fetch_assoc($query_run);
                            echo '<h4>'.$row['sold'].'</h4>';
                        ?>
                    </div>
                </div>
                <div class="swiper">
                    <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>

                            <div class="col-2-report">
                            <div class="col-2-report-1">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <legend>RENT CALCULATION:</legend>
                                        <div class="gen-bt">
                                            <div class="button button-2nd">
                                                <input type="button" name="summation" value="COMPUTE &#8594;" onclick="document.getElementById('id01').style.display='block'"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>

                                <form action="" method="post">
                                    <?php
                                        if (isset($_POST['sum'])) {
                                            $myrent = $_SESSION['mail'];
                                            $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                                            $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                                            $query_2 = "SELECT SUM(amount) AS value_sum FROM payments WHERE landlordEmail='$myrent' AND currentDate BETWEEN '$date_1' AND '$date_2'";
                                            $query_run_2 = mysqli_query($db, $query_2);

                                            $row_2 =mysqli_fetch_assoc($query_run_2);
                                            $sum = $row_2['value_sum'];
                                            echo '<h4>'.'KSH.'.$sum.'</h4>';
                                        }
                                     ?>  
                                <div id="id01" class="modal">
                                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                                    <div class="modal-content">
                                      <div class="container-delete">
                                        <h1>Rent computation</h1>
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

                                        <div class="clearfix">
                                            <button type="button" class="cancelbtn" onclick="cancel()">Cancel</button>
                                            <button type="submit" name="sum" class="deletebtn">Sum</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <button id="exportButton2">PDF download</button>
                    </div>
                    <div class="swiper-slide">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        <button id="exportButton">PDF download</button>
                    </div>
                    </div>
                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev"></div>
                <!-- <div class="swiper-button-next"></div> -->
                </div>


            <!-- ----------table 2 ------------ -->
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

                <div class="button button-2nd">
                    <button type="submit" name="viewall">View all</button>
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
                    $myrent = $_SESSION['mail'];
                    
                    $searchinfo = mysqli_real_escape_string($db, $_POST['searchinfo']);
                    $date_1 = mysqli_real_escape_string($db, $_POST['date-1']);
                    $date_2 = mysqli_real_escape_string($db, $_POST['date-2']);

                    if(isset($_POST['find'])){
                        $sql2 = "SELECT * from payments WHERE landlordEmail='$myrent' AND currentDate BETWEEN '$date_1' AND '$date_2' ORDER BY currentDate DESC";
                    
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
                        $sql2 = "SELECT * from payments WHERE landlordEmail='$myrent' AND (id='$searchinfo' or payment_id='$searchinfo' or amount='$searchinfo' or receiptnumber='$searchinfo' or payerphone='$searchinfo' or houseID='$searchinfo' or tenantEmail='$searchinfo' or landlordEmail='$searchinfo')";
                    
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
                    }elseif(isset($_POST['viewall'])){
                        $sql2 = "SELECT * FROM payments WHERE landlordEmail='$myrent' ORDER BY currentDate DESC";
                    
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

            <div id="myhouses" class="one">
                <h2 class="title">My Vaccant Houses</h2>
                <div class="myhouses">
                    <?php
                        $landlord = $_SESSION['mail'];
                        $res = mysqli_query($db, "SELECT * from houseinfo WHERE landlordEmail='$landlord' AND houseStatus='Vaccant'");
                        while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <div class="col-vaccant">
                            <div class="image">
                                <?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:150px; height:100px; position:center;">'; ?>
                            </div>
                            <p>Bedroom: <?php echo $row["bedroom"]; ?></p>
                            <p>Location: <?php echo $row["location"]; ?></p>
                            <p>Rent: KSH <?php echo $row["rent"]; ?></p>
                            <div class="bt-more">
                                <button> <?php
                                    if(isset($_SESSION['mail'])){
                                        echo " <a href='houseView?houseID={$row['houseID']}' target='blank' rel='noreferrer noopener'> MORE &#8594; </a>"; 
                                    }else{
                                        echo '<script type="text/javascript"> alert("You are logged out")</script>';
                                    }
                                ?></button>
                            </div>
                        </div>
                        <?php
                        }
                    ?>
                </div>
                <button class="btn-1">More</button>
            </div>

            <div class="one">
                <h2 class="title">My Occupied Houses</h2>
                <div class="myhouses">
                    <?php
                        $landlord = $_SESSION['mail'];
                        $res = mysqli_query($db, "SELECT * from houseinfo WHERE landlordEmail='$landlord' AND houseStatus='Occupied'");
                        while ($row = mysqli_fetch_array($res)) {
                        ?>
                        <div class="col-occupied">
                            <div class="image">
                                <?php echo '<img src="data:image;base64,'.base64_encode($row['houseImage1']).'" alt="" style="width:150px; height:100px; position:center;">'; ?>
                            </div>
                            <p>Bedroom: <?php echo $row["bedroom"]; ?></p>
                            <p>Location: <?php echo $row["location"]; ?></p>
                            <p>Rent: KSH <?php echo $row["rent"]; ?></p>
                            <div class="bt-more">
                                <button> <?php
                                    if(isset($_SESSION['mail'])){
                                        echo " <a href='houseView?houseID={$row['houseID']}' target='blank' rel='noreferrer noopener'> MORE &#8594; </a>"; 
                                    }else{
                                        echo '<script type="text/javascript"> alert("You are logged out")</script>';
                                    }
                                ?></button>
                            </div>
                        </div>
                        <?php
                        }
                    ?>
                </div>
                <button class="btn-2">More</button>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="scrolljQuery.js"></script>
    <script>
        $(".col-vaccant").slice(0, 5).show()
        $(".btn-1").on("click", function(){
            $(".col-vaccant:hidden").slice(0, 5).slideDown('slow')
            if ($(".col-vaccant:hidden").length == 0) {
                $(".btn-1").fadeOut('slow')
            }
        })

        $(".col-occupied").slice(0, 5).show()
        $(".btn-2").on("click", function(){
            $(".col-occupied:hidden").slice(0, 5).slideDown('slow')
            if ($(".col-occupied:hidden").length == 0) {
                $(".btn-2").fadeOut('slow')
            }
        })
    </script>
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

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }

        function cancel(){
            modal.style.display = "none";
        }
    </script>
</body>
</html>