<?php

    define("BTCINSAT", 100000000);

    require_once('../phpwrappers/poloniexapiwrapper.php');

    $apiKey = $_POST["apiKey"];
    $apiSecret = $_POST["apiSecret"];
    $thisPair = $_POST["currencyPair"];
    $thisPairLetters = strlen($thisPair)-4;
    $loopTime = $_POST["waitTime"];
    $amount = $_POST["coinAmount"];
    $startRate = $_POST["startRate"];
    $minDifference = $_POST["tradeDiff"];
    $nrOfWalls = $_POST["wallAmount"];
    $orderArray[]=$_POST["wallOrder"];

    var_dump($orderArray);

    function satRounder($sats, $percent=1){
        
            $rSats = floor($sats*$percent*BTCINSAT) / BTCINSAT;
        
            return ($rSats);
    }
?>
<head>
    <title>Poloniex BMXSPY bot for <?php echo substr($thisPair,4,$thisPairLetters);?></title>
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

<fieldset id="bot">
    <legend><h1>Poloniex <?php echo $thisPair;?> BMXSPY Bot</h1></legend>
   
    
        <table>
            
            <tr id="openOrders">
                <th>Order#</th>
                <th>B#</th>
                <th>B@</th>
                <th>Order#</th>
                <th>S#</th>
                <th>S@</th>
            </tr>
                        
    <?php
           /* $buyOrder="F";
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
            
            echo "<tr><td>" . $buyOrder . "</td><td>" . $buyAmount . "</td><td>" . $highBid . "</td><td>" . $sellOrder . "</td><td>" . $sellAmount . "</td><td>" . $lowAsk . "</td><td>" . $profit . "</td></tr>";*/
            
            ?>
        </table>
                
</fieldset>

</body> 