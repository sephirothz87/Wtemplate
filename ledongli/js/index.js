(function() {
    // console.log("ledongli build 0001");

    var step_key = {
        1846:"4bdcb06e02cd2b89d6891d09c13c84c3",
        2108:"85befbc8bd0661d3c3d4cb56ee01fe47",
        2121:"a25b85607d62d175169fba58037c1bad",
        2613:"bb163028de7dda596f539d19cdf269ba",
        copy:"a25b85607d62d175169fba58037c1bad"
        
    };

    $(document).ready(function() {
        $("#button").click(function() {
        	var l_id=$("#l_id").val();
        	var steps=$("#steps").val();
        	var date = new Date();
        	var time_stamp = Math.round(date.getTime()/1000);

            console.log("l_id = "+l_id);
            console.log("steps = "+steps);

            console.log("step_key = "+step_key[1846]);

            if(steps>30000){
            	alert("steps>30000");
            	return;
            }

            console.log("time_stamp = "+time_stamp);

            var r_data="list=%5B%7B%22pm2d5%22%3A0%2C%22report%22%3A%22%5B%7B%5C%22activity%5C%22%3A%5C%22walking%5C%22%2C%5C%22calories%5C%22%3A83.321020733531611%2C%5C%22steps%5C%22%3A1840%2C%5C%22distance%5C%22%3A2402.7757200000001%2C%5C%22duration%5C%22%3A1260%7D%5D%22%2C%22distance%22%3A2402.7757200000001%2C%22steps%22%3A"+steps+"%2C%22date%22%3A"+time_stamp+"%2C%22calories%22%3A140.17265113023612%2C%22duration%22%3A1860%2C%22lon%22%3A121.54642728736559%2C%22activeValue%22%3A42868%2C%22lat%22%3A38.888830057174324%7D%5D&pc=47d98ceacc8876d4c4c93988cbb9b68150b51bc8";

            console.log("data = "+r_data);

            $.ajax({
                url: "http://pl.api.ledongli.cn/xq/io.ashx?uid="+l_id+"&v=5.3.2+ios&vc=534+ios&action=profile&cmd=updatedaily",
                type: "post",
                dataType: "text",
                data: r_data,
                success: function(data) {
                    console.log("success");
                    var result = data.result;
                    console.log(data);
                },
                error: function(err) {
                    console.log("error");
                    var errorCode = err.code;
                    console.log(err);
                }
            });
        })
    });
})();