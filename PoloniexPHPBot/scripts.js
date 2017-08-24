apiArray = [
                ['BTC_STR',"9EK18ZT6-DB2PWE2N-IUNMDOSZ-JD5S82C7","a70b9b614a801948159f1655820538986ede288c537ecdfe89b00e47e5c29101c7322e302a8a8d5d2c123978f63c29578e2700468cb73a8dade28ad95673ce03"],
                ['BTC_POT',"523KAS9O-1YXXWR2V-VNVAXICK-XOJE8YI4","feb1078fa842ede431acdde49679fa2ccb66398d2214ed8e44956e0fbc54c5241c0debcb71282528904cafdc3d4c855ed5fed2129897803a7b25b298b7c1ae44"],
                ['BTC_XRP',"B2GSF90T-E5CPFX3H-3A8BS6D5-ER4A7B28","e521357b6b9a2dc7fc5a0e9a8c6c43eac8589a4effcaa44b1cceaf616528258e40d8c6863f0e958061d06b50ed4cc130ab502569b156f2b080655b4c9428fb57"],
                ['BTC_ETH',"5HIB5QWX-G8R322YS-NFHQ8L6W-80EIY0AT","a376f9c8cce514d47da1b06259f81dc06da5bb966bcf340742388f159954af6dbaf0e730c625898dccd22f2ef1ff1a887019b67bf1d7303d4723f8d8b34ad685"],
                ['BTC_LTC',"1PLR8Y10-Y4LGKWQ3-VSL62FU5-XHWZO2LG","cc931c4d571aa8404ab1f025928e5215c1116ea03a7836c7504a0b9d9abac4ee0e87ccc315a5f8adc8a28ab19c1c64f80581239ac832380d2f98d771d73ba2ae"],
                ['BTC_GNT',"A6N2052D-QHUUZ4O0-VH0XYK6W-YACJ28J3","fca65ff1338d58b8db7526b7b0cc5ff00542d74a448f5bb7ba9808fdde8bbdb63a8060f823cd2a22bceadb485399e551f05125ea9c1aaa05549895d36dbef1e7"]
];

//from https://www.w3schools.com/jsref/met_win_settimeout.asp
function checkTime(i){
	if (i < 10) {
        i = "0" + i;
    }  // add zero in front of numbers < 10
	return i;
}
function startTime(){
    
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	h = checkTime(h);
	m = checkTime(m);
	s = checkTime(s);
	document.getElementById("clock").textContent = h + ":" + m + ":" + s;

	var t = setTimeout(startTime, 500);
}

function setCA(i){
    
        //alert("in setCA function! met i = " + i + " test: " + apiArray[i][2]);
    if(i!="x"){
        
        document.getElementById("customBot").checked=false;
        document.getElementById("poloak").value=apiArray[i][1];
        document.getElementById("poloas").value=apiArray[i][2];
        document.getElementById("apikc").innerHTML="<b>Api key set for " + apiArray[i][0] + "</b>";
        document.getElementById("apisc").innerHTML="<b>Api secret set for " + apiArray[i][0] + "</b>";
        
        document.getElementById("poloak").hidden=true;
        document.getElementById("poloas").hidden=true;
        
       
    }else{
        if(document.getElementById("customBot").checked == true)
        {
            document.getElementById("poloak").value="";
            document.getElementById("poloas").value="";
            document.getElementById("poloak").hidden=false;
            document.getElementById("poloas").hidden=false;
            document.getElementById("currencyPairSelect").disabled=true;
            document.getElementById("currencyPairText").hidden=false;
            document.getElementById("currencyPairText").disabled=false;
            document.getElementById("apikc").innerHTML="";
            document.getElementById("apisc").innerHTML="";
        }else{
            document.getElementById("currencyPairSelect").disabled=false;
            document.getElementById("currencyPairText").hidden=true;
            document.getElementById("currencyPairText").disabled=true;
        }
        
    }
}
function satRounder(sats, percent=1){
        
            var rSats = Math.floor((sats)*percent*100000000) / 100000000;
        
            return (rSats);
}

function setWalls(){
    var i=j=btcNeeded=0;
    var nrOfWalls = document.getElementById("wallAmount").value/2;
    var amount = document.getElementById("coinAmount").value;
    var diff = document.getElementById("tradeDiff").value;
    var xxxNeeded=nrOfWalls*amount;
    var startRate = document.getElementById("startRate").value;
    var thisCurrencyPair = document.getElementById("currencyPair").value;
    var htmlString = "<table><tr><th>Direction</th><th>Amount " + thisCurrencyPair + "</th><th>Rate BTC</th></tr>";
    //alert(htmlString);
    
    if(diff<1)
    {
     
        for(i;i<nrOfWalls;i++)
        {
            htmlString+= "<tr><td>Sell</td><td>" + "<input type='text' value='" + amount + "'/></td><td>" + "<input type='text' name='wallOrder[]' value='" +satRounder(startRate,(1+diff*(nrOfWalls-i))) + "'/></td></tr>";

        }
        for(j;j<nrOfWalls;j++)
        {
            htmlString+= "<tr><td>Buy</td><td>" + "<input type='text' value='" + amount + "'/></td><td>" + "<input type='text' name='wallOrder[]' value='"+ satRounder(startRate,(1-diff*(j+1))) + "'/></td></tr>";
            btcNeeded+=amount*satRounder(startRate,(1-diff*(j+1)));
        }
    }else{
        //diff=diff;
        for(i=0;i<nrOfWalls;i++){
            htmlString+= "<tr><td>Sell</td><td>" + "<input type='text' value='" + amount + "'/></td><td>" + "<input type='text' name='wallOrder[]' value='" + satRounder(startRate+diff*(nrOfWalls-i)) + "'/></td></tr>";
        }
        for(j=0;j<nrOfWalls;j++){
            htmlString+= "<tr><td>Buy</td><td>" + "<input type='text' value='" + amount + "'/></td><td>" + "<input type='text' name='wallOrder[]' value='" +satRounder(startRate-diff*(j+1)/100000000) + "'/></td></tr>";
            btcNeeded+=satRounder(amount*(startRate-diff*(j+1)/100000000));
        }
        
    }
        
        htmlString+= "</table>";

        //alert(htmlString);
        document.getElementById("wallSpan").innerHTML=htmlString;
        htmlString = satRounder(xxxNeeded) + " " + thisCurrencyPair +" and "+ satRounder(btcNeeded) + " BTC needed to start with these walls!";

        document.getElementById("coinsNeeded").innerHTML=htmlString;
       
}
function changeStartPrice(i){
    if(i=='+')
    {
        document.getElementById("startRate").value=satRounder((document.getElementById("startRate").value)/100000000);
    }else if(i=='-'){
        document.getElementById("startRate").value=(document.getElementById("startRate").value*100000000);
    }
}
