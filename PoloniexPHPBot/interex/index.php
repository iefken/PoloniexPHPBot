<?php
    $version = 0.001;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../standard.css">

	<meta charset="UTF-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INTEREX Trading FaBot v<?php echo $version;?></title>
</head>

<body onload="startTime()">

<!--TOTAL HEADER STARTS HERE-->

<div class="ownheader">

        <div class="dropbtn">

            <a href="../blsh/">Buy low Sell high</a>

        </div>
	
        <div class="dropbtn">

            <a href="../bmxspx/">Buy - x Sell + y</a>

        </div>
    
        <div id="activeTab" class="dropbtn">

            <a href="../interex/">Interexchange trades</a>

        </div>

        <div id="clock">XX:XX:XX</div>
	   
</div>
    
<div id="btc-quote"></div>
    
    
<!--BODY STARTS HERE-->
<fieldset>
    <legend><h1>Inter Exchanges FaBots</h1></legend>
        <remark><h5>THIS SECTION DOESN'T WORK YET</h5></remark>
        <h3>1. Poloniex</h3>
        
</fieldset>
    
<script type="text/javascript" src="../scripts.js"></script>
<script type="text/javascript" src="https://www.weusecoins.com/embed.js"></script>
    
</body>
    
</html>