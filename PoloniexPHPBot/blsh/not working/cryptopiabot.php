<?php

    require_once ('../phpwrappers/cryptopiaapiwrapper.php');
    
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
    
    function satRounder($sats, $percent=1){
        
            $rSats = floor($sats*$percent*BTCINSAT) / BTCINSAT;
        
            return ($rSats);
    }

    
    $cryptopiaBot = new Cryptopia($apiSecret,$apiKey);
    $btcBalance = $cryptopiaBot->GetCurrencyBalance( "BTC" );
      //echo "BTC Balance: " . $my_btc . PHP_EOL;
    $thisPair = substr($thisPair,0,$thisPairLetters);
    $xxxBalance = $cryptopiaBot->GetCurrencyBalance($thisPair);
    $cryptopiaBot->updatePrices();
    $ticker = $cryptopiaBot->getPrices();

    echo "btc: $btcBalance, xxx: $xxxBalance, thispair: $thispair, " . $ticker['ATMS']['last'] ;

?>