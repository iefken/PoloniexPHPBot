<?php

    set_time_limit(0);
    ob_implicit_flush(1);

    ini_set('precision', 8);
    bcscale(8);

    require_once('../phpwrappers/YoBitNet-api.php');

    define("BTCINSAT", 100000000);

    // $_POST from blsh/index.php

    $apiKey = $_POST["apiKey"];
    $apiSecret = $_POST["apiSecret"];
    $thisPair = $_POST["currencyPair"];
    $thisPairLetters = strlen($thisPair)-4;
    $loopTime = $_POST["waitTime"];
    $sellAmount = $_POST["sellAmount"];
    $buyAmount = $_POST["buyAmount"];
    $minDifference = $_POST["tradeDiff"];
    $maxTrades = $_POST["maxLoop"];
    $firstLoopBool = $_POST["firstLoop"];
    
    $thisPair = substr($thisPair,0,$thisPairLetters);

    function satRounder($sats, $percent=1){
        
            $rSats = floor($sats*$percent*BTCINSAT) / BTCINSAT;
        
            return ($rSats);
    }

    $yobitBot = new YoBitNetAPI($apiKey,$apiSecret);

    $totalBalance = $yobitBot->getTotalBalance();
    
    $myFunds = $yobitBot->getFundsInfo();

    $btcBalance=$myFunds['return']['funds']['btc'];

    $xxxBalance=$myFunds['return']['funds'][$thisPair];

    $btcBalanceio=$myFunds['return']['funds_incl_orders']['btc'];

    $xxxBalanceio=$myFunds['return']['funds_incl_orders'][$thisPair];

    $thisPair = $thisPair . "_btc";

    $ticker = $yobitBot->getPairTicker($thisPair);

    $yobitBot->highBid = $ticker['ticker']['buy'];
    $yobitBot->lowAsk = $ticker['ticker']['sell'];

    if($minDifference>-1){
        if($minDifference>0){
            if($minDifference>1){                        
                //>+1
                $yobitBot->lowAsk = satRounder(max($yobitBot->lowAsk, $yobitBot->highBid + $minDifference/BTCINSAT));
            }else{
                //0>1
                        
                $yobitBot->lowAsk = satRounder(max($yobitBot->lowAsk, $yobitBot->highBid * (1 +$minDifference)));
            }
        }else{    
            //-1>0
                    
            $yobitBot->highBid = satRounder(min($yobitBot->highBid, $yobitBot->lowAsk * (1+$minDifference)));
        }

    }else{
        //<-1
                
        $yobitBot->highBid = satRounder(min($yobitBot->$highBid, $yobitBot->lowAsk + $minDifference/BTCINSAT));
    }
                        
    $buyOrder="F";
    $sellOrder="F";
            
    //sell XXX
    /*echo "You would be selling: makeOrder($sellAmount, $thisPair, 'sell', ...)";*/
    $sellAmount < $xxxBalance ? $orderNr2 = $yobitBot->makeOrder($sellAmount, $thisPair, "sell", $yobitBot->lowAsk) : $sellOrder="Not enough " . $thisPair . "!";
            
    if(isset($orderNr2['return']['order_id'])){
        global $sellOrder;
         $sellOrder=$orderNr2['return']['order_id'];
                
     }
                                                           
    //buy XXX
            
    /*echo "You would be buying: makeOrder($buyAmount, $thisPair, 'buy', ...)";*/
    ($buyAmount*$yobitBot->highBid) < $btcBalance ? $orderNr1 = $yobitBot->makeOrder($buyAmount, $thisPair, "buy", $yobitBot->highBid) : $buyOrder="Not enough BTC!";
                     
    if(isset($orderNr1['return']['order_id'])){
                global $buyOrder;
                $buyOrder=$orderNr1['return']['order_id']; 
                
    }
    $lowAsk = $yobitBot->lowAsk;
    //echo"<script>alert('lowAsk: $lowAsk');</script>";
    $highBid = $yobitBot->highBid;
    $profit = (($sellAmount*$lowAsk - $buyAmount*$highBid)*BTCINSAT)*0.996;              
    /*echo "trade executed!";*/

    //If this is the first loop then the html will be included, otherwise the window will close now since the buys and sells went through

    if($firstLoopBool)
    {
        
?>

<head>
    <title>YoBit BLSH FaBot for <?php echo substr($thisPair,0,$thisPairLetters);?></title>
    <link rel="stylesheet" href="../standard.css">
    <script type="text/javascript" src="../scripts.js"></script>
</head>
<body>
    
<fieldset id="xxxbalances">
    <legend><h1>YoBit <?php echo $thisPair;?> BLSH Bot:</h1></legend>
    <h2>Your YoBit balances:</h2>
    <p>Total balance: <?php echo $totalBalance;?> BTC <br/>
    BTC balance: <?php echo $btcBalance;?> (open orders included: <?php echo $btcBalanceio;?> )<br/>
    <?php echo substr($thisPair,0,$thisPairLetters);?> balance: <?php echo $xxxBalance;?>  (open orders included: <?php echo $xxxBalanceio;?> )</p>
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
        echo "<tr><td>" . substr($thisPair,4,$thisPairLetters) . "</td><td>" . $ticker['ticker']['last'] . "</td><td>" . $yobitBot->lowAsk . "</td><td>" . $yobitBot->highBid . "</td></tr>";
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
    <form id="yobitbotAutoForm" method="post" action="yobitbot.php">
    <ol>
            <li>
                <p>Choose your <b>trading pair</b>:<br/>
                    <input type="text" name="currencyPair" value="<?php echo $thisPair;?>" required/>
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
                    <textarea name="apiKey" required><?php echo $apiKey;?></textarea>
                </p>
            </li>
            <li>
                <p>Set your <b>API-secret</b>:<br />
                    <textarea name="apiSecret" required><?php echo $apiSecret;?></textarea>
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
    <script src="loopscript.js"></script>
</fieldset>
      

</body> 

<?php
        
    }else{
        echo "<script>window.close();</script>";
    }

?>  
         