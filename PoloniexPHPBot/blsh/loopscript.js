document.getElementById("botStatus").textContent = "Bot in loopscript.js ... "; 
            
var lTime = document.getElementById("waitTime").value;
        
//alert("" + lTime );    
//timestamp last trade
var lastTrade;
var today = new Date();
var h = today.getHours();
var m = today.getMinutes();
var s = today.getSeconds();
h = checkTime(h);
m = checkTime(m);
s = checkTime(s);
var today2 = h + ":" + m + ":" + s;
lastTrade = "Last trade submitted at: " + today2 + ".";
//bot timer
today = today.getTime();
var secondeTeller=lTime;
lTime=secondeTeller*1000;
        
//alert("In script! LT:" + lTime);
function submitFunction()
{
    //alert("" + lTime );
    document.forms["polobotAutoForm"].submit();
    document.getElementById("botStatus").textContent = "Bot submitting tradeform ...";
}
function updateBotStatus(){
    
    //initialise new date and compare to timestamp last trade
    var d = new Date();
    d = d.getTime();
    
    //alert("d:" + d + " today:" + today + " secondeTeller:" + secondeTeller);
    
    var differ = (today - d + lTime)/1000;
    
    if(differ>=0)
    {
        var thisString = lastTrade + "\<br /\> Next submission in: \<span id='statusSec'\>" + Math.floor(checkTime(differ)) + "\</span\> seconds.";
        document.getElementById("botStatus").innerHTML = thisString;
        var t = setTimeout(updateBotStatus,1000);
    }
}
            
updateBotStatus();
            
        
setTimeout(submitFunction, lTime);
      
//alert("Bot ENDED after " + i + " loops!");
