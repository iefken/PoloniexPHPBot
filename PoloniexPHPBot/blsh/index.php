<?php
    $version="0.04A1";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../standard.css">

	<meta charset="UTF-8">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BLSH Trading FaBot v<?php echo $version;?></title>
</head>

<body onload="startTime()">

<!--TOTAL HEADER STARTS HERE-->
    
<div class="ownheader">

        <div id="activeTab" class="dropbtn">

            <a href="../blsh/">Buy Low Sell High</a>

        </div>
	
        <div class="dropbtn">

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
    <legend><h1>Buy Low Sell High FaBots</h1></legend>
    
        <h3>1. Poloniex</h3>
        
        <form id="polobot1Form" target="_blank" method="post" action="polobot.php">
        <ol>
            <li>
                <p>Choose your <b>trading pair</b>:<br/>
                    <input type="text" id="currencyPairText" name="currencyPair" value="BTC_XXX" required />
                    
                </p>
            </li>
            <li>
                <p>Choose the <b>difference</b> between buys and sells:<br/>
                    <input type="text" name="tradeDiff" value="+0.02" required/><br/>
                    <i> &lt;||1|| : in percent<br/>
                        &gt;||1|| : in satoshi's (0.00000001 BTC)<br/>
                        &lt;0 : sell at lowAsk and buy at MIN(highBid,lowAsk-difference)<br/>
                        &gt;0 : buy at highBid and sell at MAX(lowAsk,highBid+difference)
                    </i>
                    <br/>
                </p>
            </li>
            <li>
                <p>Choose the <b>amount of coins to buy</b>:<br/>
                    <input type="text" name="buyAmount" value="0" required/>
                </p>
                <i>
                    Amount (in BTC) has to be &gt;0.00010000BTC
                </i>
                <br/>
            </li>
            <li>
                <p>Choose the <b>amount of coins to sell</b>:<br/>
                    <input type="text" name="sellAmount" value="0" required/>
                </p>
                <i>
                    Amount (in BTC) has to be &gt;0.00010000BTC
                </i>
                <br/>
            </li>
            <li>
                <p>Set your <b>API-key</b>:<br />
                    
                    <input id="poloak" type="text" name="apiKey" required/>
                    <span id="apikc"></span>
                </p>
            </li>
            <li>
                <p>Set your <b>API-secret</b>:<br />
                    <input id="poloas" type="text" name="apiSecret" required/>
                    <span id="apisc"></span>
                </p>
            </li>
            
            <li>
                <p>Choose the <b>waittime</b> between buys (in milliseconds): (bot adds +-3seconds for completing the script)<br/>
                    <input type="text" id="waitTime" name="waitTime" value="30" required/>
                </p>
            </li>
            <li>
                <p>Set a <b>max number of trades</b> (loops; buys AND sells) to run the bot (0=unlimited):<br />
                    <input type="text" name="maxLoop" value="0"/>
                </p>
            </li>
        </ol>
            
            <input type="hidden" name="firstLoop" value="True"/>
            <input type="submit" value="Start the FaBot!"/>
            
            
        </form> 
        <!--<h3>2. Cryptopia</h3>
        
        <form id="cryptopia1Form" target="_blank" method="post" action="cryptopiabot.php">
        <ol>
            <li>
                <p>Choose your <b>trading pair</b>:<br/>
                    <input type="text" name="currencyPair" value="xxx_btc" required/>
                </p>
            </li>
            <li>
                <p>Choose the <b>difference</b> between buys and sells:<br/>
                    <input type="text" name="tradeDiff" value="+0.02" required/><br/>
                    <i> &lt;||1|| : in percent<br/>
                        &gt;||1|| : in satoshi's (0.00000001 BTC)<br/>
                        &lt;0 : sell at lowAsk and buy at MIN(highBid,lowAsk-difference)<br/>
                        &gt;0 : buy at highBid and sell at MAX(lowAsk,highBid+difference)
                    </i>
                    <br/>
                </p>
            </li>
            <li>
                <p>Choose the <b>amount of coins to buy</b>:<br/>
                    <input type="text" name="buyAmount" value="0" required/>
                </p>
                <i>
                    Amount (in BTC) has to be &gt;0.00010000BTC
                </i>
                <br/>
            </li>
            <li>
                <p>Choose the <b>amount of coins to sell</b>:<br/>
                    <input type="text" name="sellAmount" value="0" required/>
                </p>
                <i>
                    Amount (in BTC) has to be &gt;0.00010000BTC
                </i>
                <br/>
            </li>
            <li>
                <p>Set your <b>API-key</b>:<br />
                    <textarea name="apiKey" required></textarea>
                </p>
            </li>
            <li>
                <p>Set your <b>API-secret</b>:<br />
                    <textarea name="apiSecret" required></textarea>
                </p>
            </li>
            
            <li>
                <p>Choose the <b>waittime</b> between buys (in milliseconds): (bot adds +-3seconds for completing the script)<br/>
                    <input type="text" id="waitTime" name="waitTime" value="30" required/>
                </p>
            </li>
            <li>
                <p>Set a <b>max number of trades</b> (loops; buys AND sells) to run the bot (0=unlimited):<br />
                    <input type="text" name="maxLoop" value="0"/>
                </p>
            </li>
        </ol>
            
            <input type="hidden" name="firstLoop" value="True"/>
            <input type="submit" value="Start the FaBot!"/>
            
            
        </form> -->
</fieldset>

    
<script type="text/javascript" src="../scripts.js"></script>
    
</body>
    
</html>
<!--<fieldset>
    <legend>How does it work?</legend>
    <p>The 'bot' will constantly check the lowest ask and highest bid of your chosen coin at Poloniex and buy/sell that coin according to your given 'difference'.</p>
</fieldset>-->