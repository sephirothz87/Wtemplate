$(function(){
	ALERT_TXT_INVALID = "最大值：10小时 59分 59秒";
	ALERT_TXT_NONE = "请输入时间";

	second = 0;
	startTime = 0;
	endTime = 0;
	isStart = false;

	looper = function(){
		if(isStart){
			now = new Date();
			if(now<endTime){
	    		var cound_down=Math.floor((endTime-now)/1000);

	    		// console.log(cound_down);

	    		hour = Math.floor(cound_down/3600);

	    		minute = Math.floor((cound_down-hour*3600)/60);

	    		second = cound_down%60;

	    		// console.log(hour);
	    		// console.log(minute);
	    		// console.log(second);

	    		$("#hour").val(hour);
	    		$("#minute").val(minute);
	    		$("#second").val(second);

				setTimeout('looper()',200);
			}else{
				alert("It's time!");
				startTime = 0;
				endTime = 0;
				isStart = false;

	    		$("#hour").val(null);
	    		$("#minute").val(null);
	    		$("#second").val(null);
			}
		}else{
			startTime = 0;
			endTime = 0;

    		$("#hour").val(null);
    		$("#minute").val(null);
    		$("#second").val(null);
		}
	}

	$("#btnStart").on("click",function(){
		if(!$("#hour").val()&&!$("#minute").val()&&!$("#second").val()){
			$(".div-alert").text(ALERT_TXT_NONE);
			$(".div-alert").show();
		}else if($("#hour").val()>10||$("#minute").val()>59||$("#second").val()>59){
			$(".div-alert").text(ALERT_TXT_INVALID);
			$(".div-alert").show();
		}else{
			$(".div-alert").hide();
			second = $("#hour").val()*3600 + $("#minute").val()*60 + $("#second").val()*1;

			// console.log(second);
			// endTime = new Date();
			// console.log(endTime);
			// endTime = new Date(endTime.getTime()+parseInt(second)*1000);
			// console.log(endTime);

			startTime = new Date();
			endTime = new Date(startTime.getTime()+parseInt(second)*1000);
			isStart = true;
			looper();
		}
	});


	$("#btnReset").on("click",function(){
		isStart = false;
	});
})