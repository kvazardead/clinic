<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<style>
    #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        /*padding:2mm;*/
        margin: 0 auto;
        width: 56mm;
        background: #FFF;
    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    h1{
      font-size: 1.5em;
      color: #222;
    }
    h2{font-size: .9em;}
    h3{
      font-size: 1.2em;
      font-weight: 300;
      line-height: 2em;
    }
    p{
      font-size: .7em;
      line-height: 1.2em;
    }

    #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #top{min-height: 100px;}
    #mid{min-height: 80px;}
    #bot{ min-height: 50px;}

    #top .logo{
        //float: left;
        height: 90px;
        width: 110px;
        background: url(../../static/assets/images/logo) no-repeat;
        background-size: 110px 90px;
    }
    .clientlogo{
        float: left;
    	height: 60px;
    	width: 60px;
    	background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    	background-size: 60px 60px;
        border-radius: 50px;
    }
    .info{
      display: block;
      //float:left;
      margin-left: 3px;
    }
    .title{
      float: right;
    }
    .title p{text-align: right;}
    table{
      width: 100%;
      border-collapse: collapse;
    }
    td{
      //padding: 5px 0 5px 15px;
      //border: 1px solid #EEE
    }
    .tabletitle{
      background: #9e9e9e;
    }
    .service{border-bottom: 1px solid #EEE;}
    .item{width: 24mm;}
    .itemtext{font-size: .5em;}

    #legalcopy{
      margin-top: 5mm;
    }

</style>

<body onload="window.print();" style="color: black; font-size: 140%;">

    <div id="invoice-POS" >

        <div id="mid">

            <div class="info">
                <span style="text-align: center;">
                    <h2><?= $_GET['id'] ?></h2>
                </span>
                <p class="h4">
                    <b>ФИО</b>: <?= get_full_name($_GET['id']) ?></br>

                    <b>ID</b>: 182</br>
                    <b>Дата</b>: <?= date('d.m.Y H:i') ?>
                </p>
            </div>

        </div>


    </div>

</body>