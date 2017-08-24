<?php
    $version = 0.001;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../standard.css">

	<meta charset="UTF-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="../scripts.js"></script>
    <title>BMXSPY Trading FaBot v<?php echo $version;?></title>
</head>

<body onload="startTime()">

<!--TOTAL HEADER STARTS HERE-->

<div class="ownheader">

        <div class="dropbtn">

            <a href="../blsh/">Buy low Sell high</a>

        </div>
	
        <div id="activeTab" class="dropbtn">

            <a href="../bmxspx/">Buy - x Sell + y</a>

        </div>
    
        <div class="dropbtn">

            <a href="../interex/">Interexchange trades</a>

        </div>

        <div id="clock">XX:XX:XX</div>
	   
</div>
    
<div id="btc-quote"></div>
    
    
<!--BODY STARTS HERE-->
<fieldset>
    <legend><h1>Buy Min X Sell Plus Y FaBots</h1></legend>
        <remark><h5>THIS SECTION DOESN'T WORK YET</h5></remark>
        <h3>1. Poloniex</h3>
        
        <form id="polobot2Form" target="_blank" method="post" action="polobot.php">
        <ol>
            <li>
                <p>Choose your <b>trading pair</b>:<br/>
                    <input type="text" id="currencyPair" name="currencyPair" value="BTC_XXX" required/>
                </p>
            </li>
            <li>
                <p>Choose the <b>difference</b> between the different 'walls':<br/>
                    <input type="text" id="tradeDiff" name="tradeDiff" value="0.05" required/><br/>
                    <i> &lt;||1|| : in percent<br/>
                        &gt;||1|| : in satoshi's (0.00000001 BTC)
                    </i>
                </p>
            </li>
            <li>
                <p>Choose the <b>amount of coins</b> to buy and sell per 'wall':<br/>
                    <input type="text" name="coinAmount" id="coinAmount" value="0" required/>
                </p>
                <i>
                    Amount (in BTC) has to be &gt;0.00010000BTC
                </i>
                <br/>
            </li>
            <li>
                <p title="'Bug' if price of one coin is > 10 BTC / coin...">Choose the 'start'price:<br/>
                <input type="text" name="startRate" id="startRate" value="0" required/><input type="button" value="To BTC" onclick="changeStartPrice('+')"/><input type="button" value="To satoshi's" onclick="changeStartPrice('-')"/>
                
                </p>
            </li>
            <li>
                <span id="wallSpan">The 'walls' are to come here...</span><br/>
                <span id="coinsNeeded">Click on 'Build the walls' to get started!</span>
                <p>Choose the <b>amount of 'walls'</b> to start with:<br/>
                    <input type="text" id="wallAmount" name="wallAmount"  value=6 required /><input type="button" onclick="setWalls()" value="Build the walls!" />
                </p>
                
            </li>
            
            <li>
                <p>Set your <b>API-key</b>:<br />
                    <input id="poloak" type="text" name="apiKey" value="M74HEU6U-MA8ROV0A-P2R5U3LI-IIFAW6C9" required/>
                    <span id="apikc"></span>
                </p>
            </li>
            <li>
                <p>Set your <b>API-secret</b>:<br />
                    <input id="poloas" type="text" name="apiSecret" value="56d6a3eabf0b757411a416594b25a4cfeafd81d8acae688f16c06f0137819da93fc165740a28b53b5aa2437784ad26ddb1a688d75cbd51255c5bc03da36c4f98" required/>
                    <span id="apisc"></span>
                </p>
            </li>
            <li>
                <p>Choose the <b>waittime</b> between checks (in seconds):<br/>
                    <input type="text" name="waitTime" value="30" required/>
                </p>
            </li>
            
        </ol>
            <input type="submit" value="Start the Bot!"/>
            
            
        </form> 
</fieldset>
    
<script type="text/javascript" src="../scripts.js"></script>
<script type="text/javascript" src="https://www.weusecoins.com/embed.js"></script>
    
</body>
    
</html>