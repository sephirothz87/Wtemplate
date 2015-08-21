(function() {
    console.log("build 0004");

    $(document).ready(function() {
        $("#button").click(function() {
            console.log("button be clicked");
            $.ajax({
                // url: "http://user.ospush.localhost/api/visit/lastVisit",
                // url: "http://user.ospush.localhost/api/news/unreadNewsIds",
                url: "http://user.ospush.localhost/api/push_send/sendMail",
                type: "post",
                dataType: "json",
                // dataType: "jsonp",
                // crossDomain: true,
                // jsonp:"jsonpcallback",
                data: {
                    //API:unreadNewsIds
                    //19号用户
                    // app_token: "38fae4e03bca72d41ad51000fafe5a44",
                    //28号用户
                    // app_token: "ccebe01738f357c2122e6ec19d6d52ca",
                    // uuid: "11111111-1111-1111-1111-111111111111",
                    // push_token: "57258b2935656ed35788e9e6bcf2eeaaea2c5974b9838369e26c54fd7ecb0e06"
                    from: "ccebe01738f357c2122e6ec19d6d52ca",
                    to: "11111111-1111-1111-1111-111111111111",
                    msg: "57258b2935656ed35788e9e6bcf2eeaaea2c5974b9838369e26c54fd7ecb0e06"
                },
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
