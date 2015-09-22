(function() {
    console.log("build 0008");

    $(document).ready(function() {
        $("#button").click(function() {
            console.log("button be clicked");
            // $.ajax({
            //     url: "http://user.ospush.localhost/api/visit/lastVisit",
            //     type: "post",
            //     dataType: "json",
            //     data: {
            //         app_token: "00100cdc0b812fddf5a09965566d3115",
            //         uuid: "uuid0001",
            //         push_token: "c3353b4ff1367153b8492dde0fca7d8ba79745cc00ab05fbf790544bcfd2450a"
            //     },
            //     success: function(data) {
            //         var result = data.result;
            //         console.log(data);
            //     },
            //     error: function(err) {
            //         var errorCode = err.code;
            //         console.log(err);
            //     }
            // });

            // $.ajax({
            //     url: "http://user.ospush.localhost/api/visit/lastVisit",
            //     // url: "http://user.ospush.localhost/api/news/unreadNewsIds",
            //     // url: "http://user.ospush.localhost/api/push_send/sendMail",
            //     type: "post",
            //     dataType: "json",
            //     // dataType: "jsonp",
            //     // crossDomain: true,
            //     // jsonp:"jsonpcallback",
            //     data: {
            //         //API:unreadNewsIds
            //         //19号用户
            //         app_token: "38fae4e03bca72d41ad51000fafe5a44",
            //         //28号用户
            //         // app_token: "ccebe01738f357c2122e6ec19d6d52ca",
            //         uuid: "11111111-1111-1111-1111-111111111111",
            //         push_token: "57258b2935656ed35788e9e6bcf2eeaaea2c5974b9838369e26c54fd7ecb0e06"
            //         // from: "ccebe01738f357c2122e6ec19d6d52ca",
            //         // to: "11111111-1111-1111-1111-111111111111",
            //         // msg: "57258b2935656ed35788e9e6bcf2eeaaea2c5974b9838369e26c54fd7ecb0e06"
            //     },
            //     success: function(data) {
            //         console.log("success");
            //         var result = data.result;
            //         console.log(data);
            //     },
            //     error: function(err) {
            //         console.log("error");
            //         var errorCode = err.code;
            //         console.log(err);
            //     }
            // });

            //cakephp测试
            // $.ajax({
            //     // url: "http://www.sephiroth.localhost/CakePhpTemplate/api/test/getClasses",
            //     url: "http://www.sephiroth.localhost/CakePhpTemplate/api/template/crudApi",
            //     type: "post",
            //     dataType: "json",
            //     data: {

            //     },
            //     success: function(data) {
            //         console.log("success");
            //         var result = data.result;
            //         console.log(data);
            //     },
            //     error: function(err) {
            //         console.log("error");
            //         var errorCode = err.code;
            //         console.log(err);
            //     }
            // });

            //乐动力
            $.ajax({
                url: "http://pl.api.ledongli.cn/xq/io.ashx?uid=35315706&v=5.3.2+ios&vc=534+ios&action=profile&cmd=updatedaily",
                type: "post",
                dataType: "text",
                data: "list=%5B%7B%22pm2d5%22%3A0%2C%22report%22%3A%22%5B%7B%5C%22activity%5C%22%3A%5C%22walking%5C%22%2C%5C%22calories%5C%22%3A83.321020733531611%2C%5C%22steps%5C%22%3A1840%2C%5C%22distance%5C%22%3A2402.7757200000001%2C%5C%22duration%5C%22%3A1260%7D%5D%22%2C%22distance%22%3A2402.7757200000001%2C%22steps%22%3A11544%2C%22date%22%3A1442851200%2C%22calories%22%3A140.17265113023612%2C%22duration%22%3A1860%2C%22lon%22%3A121.54642728736559%2C%22activeValue%22%3A42868%2C%22lat%22%3A38.888830057174324%7D%5D&pc=47d98ceacc8876d4c4c93988cbb9b68150b51bc8",
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
