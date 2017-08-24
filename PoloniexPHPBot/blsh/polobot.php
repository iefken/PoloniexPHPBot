<?php

    require_once('../phpwrappers/poloniexapiwrapper.php');

    define("BTCINSAT", 100000000);

    // $_POST from blsh/index.php

    $thisPair = $_POST["currencyPair"];
    $thisPairLetters = strlen($thisPair)-4;
    $loopTime = $_POST["waitTime"];
    $sellAmount = $_POST["sellAmount"];
    $buyAmount = $_POST["buyAmount"];
    $minDifference = $_POST["tradeDiff"];
    $maxTrades = $_POST["maxLoop"];
    $firstLoopBool = $_POST["firstLoop"];
    $apiKey = $_POST["apiKey"];
    $apiSecret = $_POST["apiSecret"];
    //echo "ak: $apiKey, as: $apiSecret";
    function satRounder($sats, $percent=1){
        
            $rSats = floor($sats*$percent*BTCINSAT) / BTCINSAT;
        
            return ($rSats);
    }

    $poloBot = new poloniex($apiKey,$apiSecret);
        
    $totalBalance = substr("" . $poloBot->get_total_btc_balance(), 0, 10);
    $btcBalance=0;
    $xxxBalance=0;

    $balances = $poloBot->get_balances();
        
    if (is_array($balances)){
            
        foreach($balances as $coin => $amount){
                
            if($amount>0){
                    
                /*if($firstLoopBool){
                    echo strtoupper($coin) . " balance: " . $amount . " " . strtoupper($coin) . "<br/>";
                }*/
                if($coin=="BTC")
                {
                    global $btcBalance;
                    $btcBalance = $amount;
                }
                if($coin==substr($thisPair,4,$thisPairLetters))
                {
                    global $xxxBalance;
                    $xxxBalance = $amount;
                }
            }
        }
    }

    $ticker = $poloBot->get_ticker($thisPair);
    $poloBot->highBid = $ticker['highestBid'];
    $poloBot->lowAsk = $ticker['lowestAsk'];

    if($minDifference>-1){
        if($minDifference>0){
            if($minDifference>1){                        
                //>+1
                $poloBot->lowAsk = max($poloBot->lowAsk, $poloBot->highBid + $minDifference/BTCINSAT);
            }else{
                //0>1
                        
                $poloBot->lowAsk = satRounder(max($poloBot->lowAsk, $poloBot->highBid * (1 +$minDifference)));
            }
        }else{    
            //-1>0
                    
            $poloBot->highBid = satRounder(min($poloBot->highBid, $poloBot->lowAsk * (1+$minDifference)));
        }

    }else{
        //<-1
                
        $poloBot->highBid = min($poloBot->$highBid, $poloBot->lowAsk + $minDifference/BTCINSAT);
    }
                        
    $buyOrder="F";
    $sellOrder="F";
            
    //sell XXX
            
    $sellAmount < $xxxBalance ? $orderNr2 = $poloBot->sell($thisPair, $poloBot->lowAsk, $sellAmount) : $sellOrder="Not enough " . substr($thisPair,4,$thisPairLetters) . "!";
            
    if(isset($orderNr2['orderNumber'])){
        global $sellOrder;
         $sellOrder=$orderNr2['orderNumber'];
                
     }
                                                           
    //buy XXX
            
    ($buyAmount*$poloBot->highBid) < $btcBalance ? $orderNr1 = $poloBot->buy($thisPair, $poloBot->highBid, $buyAmount) : $buyOrder="Not enough BTC!";
                     
    if(isset($orderNr1['orderNumber'])){
                global $buyOrder;
                $buyOrder=$orderNr1['orderNumber']; 
                
    }
    $lowAsk = $poloBot->lowAsk;
    //echo"<script>alert('lowAsk: $lowAsk');</script>";
    $highBid = $poloBot->highBid;
    $profit = ($sellAmount*$lowAsk - $buyAmount*$highBid)*BTCINSAT;              
         

    //If this is the first loop then the html will be included, otherwise the window will close now since the buys and sells went through

    if($firstLoopBool)
    {
        
?>

<head>
    <title>Poloniex BLSH FaBot for <?php echo substr($thisPair,4,$thisPairLetters);?></title>
    <link rel="stylesheet" href="../standard.css">
    <script type="text/javascript" src="../scripts.js"></script>
</head>
<body>
    
<fieldset id="xxxbalances">
    <legend><h1>Poloniex <?php echo $thisPair;?> BLSH Bot:</h1></legend>
    <h2>Your Poloniex balances:</h2>
    <p>Total (est.) balance: <?php echo $totalBalance;?> BTC<br/>
    BTC balance: <?php echo $btcBalance;?><br/>
    <?php echo substr($thisPair,4,$thisPairLetters);?> balance: <?php echo $xxxBalance;?></p>
    <h2>Bot Status:</h2>
    <p><span id="botStatus">Not in script...</span></p>
    <h2>Last trade:</h2>
    <table>
        <tr>
            <th>Currency</th>
            <th>Last Order</th>
            <th>Lowest Ask</th>
            <th>Highest Bid</th>
        </tr>
<?php
        echo "<tr><td>" . substr($thisPair,4,$thisPairLetters) . "</td><td>" . $ticker['last'] . "</td><td>" . $poloBot->lowAsk . "</td><td>" . $poloBot->highBid . "</td></tr>";
?>
    </table>
    <table>
        <tr id="xxxOrders">
            <th>Order#</th>
            <th>B#</th>
            <th>B@</th>
            <th>Order#</th>
            <th>S#</th>
            <th>S@</th>
            <th>Profit</th>
        </tr>
                        
<?php
        echo "<tr><td>" . $buyOrder . "</td><td>" . $buyAmount . "</td><td>" . $highBid . "</td><td>" . $sellOrder . "</td><td>" . $sellAmount . "</td><td>" . $lowAsk . "</td><td>" . $profit . "</td></tr>";
            
?>
    </table>
                
</fieldset>
    

<fieldset id="loopForm">
    <legend><h1>Your settings:</h1></legend>
    <form id="polobotAutoForm" method="post" action="polobot.php">
    <ol>
            <li>
                <p>Choose your <b>trading pair</b>:<br/>
                    <!--<select name="currencyPair" required>
                        <option id="sele0" value="BTC_STR" onclick="setCA('0')">STR</option>
                        <option id="sele1" value="BTC_POT" onclick="setCA('1')">POT</option>
                        <option id="sele2" value="BTC_XRP" onclick="setCA('2')">XRP</option>
                        <option id="sele3" value="BTC_ETH" onclick="setCA('3')">ETH</option>
                        <option id="sele4" value="BTC_LTC" onclick="setCA('4')">LTC</option>
                        <option id="sele5" value="BTC_GNT" onclick="setCA('5')">GNT</option>
                    </select>
                    -->
                    <input type="text" name="currencyPair" value="<?php echo $thisPair;?>" required/><br/>
                    <!--<input id="customBot" type="checkbox" name="customBot" value="false" onclick="setCA('x')">Custom Bot-->
                </p>
            </li>
            <li>
                <p>Choose the <b>difference</b> between buys and sells:<br/>
                    <input type="text" name="tradeDiff" value="<?php echo $minDifference;?>" required/><br/>
                    
                </p>
            </li>
            <li>
                <p>Choose the <b>amount of coins to buy</b>:<br/>
                    <input type="text" name="buyAmount" value="<?php echo $buyAmount;?>" required/>
                </p>
                
            </li>
            <li>
                <p>Choose the <b>amount of coins to sell</b>:<br/>
                    <input type="text" name="sellAmount" value="<?php echo $sellAmount;?>" required/>
                </p>
               
            </li>
            <li>
                <p>Set your <b>API-key</b>:<br />
                    
                    <input id="poloak" type="text" name="apiKey" value="<?php echo $apiKey;?>" required/>
                </p>
            </li>
            <li>
                <p>Set your <b>API-secret</b>:<br />
                    <input id="poloas" type="text" name="apiSecret" value="<?php echo $apiSecret;?>" required/>
                </p>
            </li>
            
            <li>
                <p>Choose the <b>waittime</b> between buys (in seconds):<br/>
                    <input type="text" id="waitTime" name="waitTime" value="<?php echo $loopTime;?>" required/>
                </p>
            </li>
        
            <li>
                <p>Set a <b>max number of trades</b> (loops, buys AND sells) to run the bot (0=unlimited):<br />
                    <input id="maxLoop" type="text" name="maxLoop" value="<?php echo $maxTrades;?>" required/>
                </p>
            </li>
        </ol>
        
            <input type="hidden" name="firstLoop" value="False"/>
            <input type="submit" value="Start the FaBot!"/>
        
    </form>
    <script type="text/javascript" src="loopscript.js"></script>
    <script type="text/javascript" src="../scripts.js"></script>
</fieldset>
      

</body> 

<?php
        
    }else{
        echo "<script>window.close();</script>";
    }

?>  
         