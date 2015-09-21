(function() {

    var pauseDate = new Date("Sat, 09 May 2015 12:54:10 GMT+0800");

	setTimeText = function(){
    	var div=new Date()-pauseDate;
    	// console.log(div);

    	var second=Math.round(div/1000);

    	var min_f=second/60;

    	var hour_f=min_f/60;

    	var day_f=hour_f/24;

    	var month_f=day_f/30;

    	var year_f=day_f/365;

    	$(".main").empty();

    	// console.log("second = "+second);
    	// console.log("min_f = "+min_f);
    	// console.log("hour_f = "+hour_f);
    	// console.log("day_f = "+day_f);
    	// console.log("month_f = "+month_f);
    	// console.log("year_f = "+year_f);
        
    	var text="自"+pauseDate+"起<br>钟稚聪已经等了吴韫欢：<br>"
    	text+=year_f.toFixed(2)+"年<br>";
    	text+=month_f.toFixed(2)+"月<br>";
    	text+=day_f.toFixed(2)+"日<br>";
    	text+=hour_f.toFixed(2)+"时<br>";
    	text+=min_f.toFixed(2)+"分<br>";
    	text+=second+"秒<br>";

    	$(".main").append(text);

		setTimeout('setTimeText()',200);
	}

    $(document).ready(function() {
    	setTimeText();
    });
})();
