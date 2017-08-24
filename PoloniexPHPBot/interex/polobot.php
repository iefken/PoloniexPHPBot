<?php

    define("BTCINSAT", 100000000);
    $apiKey = $_POST["apiKey"];
    $apiSecret = $_POST["apiSecret"];
    $thisPair = $_POST["currencyPair"];
    $thisPairLetters = strlen($thisPair)-4;
    $loopTime = $_POST["waitTime"];
    $sellAmount = $_POST["sellAmount"];
    $buyAmount = $_POST["buyAmount"];
    $minDifference = $_POST["tradeDiff"];
    
    require_once('../phpwrappers/poloniexapiwrapper.php');

    function satRounder($sats, $percent=1){
        
            $rSats = floor($sats*$percent*BTCINSAT) / BTCINSAT;
        
            return ($rSats);
    }
?>
<head>
    <title>Poloniex BLSH bot for <?php echo substr($thisPair,4,$thisPairLetters);?></title>
    <link rel="stylesheet" href="../standard.css">
</head>
<body>
<fieldset style="max-width: 30%;">
    <legend><h1>Your Poloniex balance(s):</h1></legend>
    <?php
        $poloBot = new poloniex($apiKey,$apiSecret);
        
        $totalBalance = substr("" . $poloBot->get_total_btc_balance(), 0, 10);
        $btcBalance;
        $xxxBalance=0;
        
        echo "<p>Total balance: " . $totalBalance . " BTC</p>";
        
        $balances = $poloBot->get_balances();
        
        if (is_array($balances)){
            
            foreach($balances as $coin => $amount){
                
                if($amount>0){
                    
                    echo strtoupper($coin) . " balance: " . $amount . " " . strtoupper($coin) . "<br/>";
                
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
        
    ?>                
</fieldset>

<fieldset id="bot" style="max-width: 30%;">
    <legend><h1>Poloniex <?php echo $thisPair;?> BLSH Bot</h1></legend>
   
        <table>
            <tr>
                <th>Currency</th>
                <th>Last Order</th>
                <th>Lowest Ask</th>
                <th>Highest Bid</th>
            </tr>
    <?php
            $ticker = $poloBot->get_ticker($thisPair);
            $poloBot->highBid = $ticker['highestBid'];
            $poloBot->lowAsk = $ticker['lowestAsk'];
            
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
                        
            //echo "<tr><td>" . $poloBot->lowAsk . "</td><td>" . $poloBot->highBid . "</td></tr>";
            $buyOrder="F";
            $sellOrder="F";
            
            //sell XRP
            
            $sellAmount < $xxxBalance ? $orderNr2 = $poloBot->sell($thisPair, $poloBot->lowAsk, $sellAmount) : $sellOrder="Not enough " . substr($thisPair,4,$thisPairLetters) . "!";
            
            if(isset($orderNr2['orderNumber'])){
                global $sellOrder;
                $sellOrder=$orderNr2['orderNumber'];
                
            }
                                                           
            //buy XRP
            
            ($buyAmount*$poloBot->highBid) < $btcBalance ? $orderNr1 = $poloBot->buy($thisPair, $poloBot->highBid, $buyAmount) : $buyOrder="Not enough BTC!";
                     
            if(isset($orderNr1['orderNumber'])){
                global $buyOrder;
                $buyOrder=$orderNr1['orderNumber']; 
                
            }          
            $lowAsk = $poloBot->lowAsk*BTCINSAT;
            $highBid = $poloBot->highBid*BTCINSAT;
            $profit = ($sellAmount*$lowAsk - $buyAmount*$highBid);              
            
            echo "<tr><td>" . $buyOrder . "</td><td>" . $buyAmount . "</td><td>" . $highBid . "</td><td>" . $sellOrder . "</td><td>" . $sellAmount . "</td><td>" . $lowAsk . "</td><td>" . $profit . "</td></tr>";
            
            ?>
        </table>
                
</fieldset>

</body> 