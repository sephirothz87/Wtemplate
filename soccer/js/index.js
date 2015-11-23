(function() {
    console.log("build 0001");

    $(document).ready(function() {
        $("#button").click(function() {
            console.log("button be clicked");

            // $.ajax({
            //     url: "http://www.okooo.com/jingcai/2015-11-22/",
            //     type: "get",
            //     // dataType:'text', 
            //     dataType:'jsonp', 
            //     // jsonp: 'jsoncallback',
            //     // jsonpCallback:'success_jsonpCallback',
            //     // data: {

            //     // },
            //     success: function(data) {
            //         console.log("success");
            //         console.log("data");
            //         console.log(data);
            //         console.log(data.name);
            //     },
            //     error: function(XMLHttpRequest, textStatus, errorThrown) {
            //         console.log("error");

            //         console.log(XMLHttpRequest.status);
            //         console.log(XMLHttpRequest.readyState);
            //         console.log(XMLHttpRequest);
            //         console.log(textStatus);
            //         console.log(errorThrown);
            //     }
            // });

            // var request = new XMLHttpRequest();
            // var timeout = false;
            // var timer = setTimeout(function() {
            //     timeout = true;
            //     request.abort();
            // }, 10000);
            // request.open("GET", "http://www.okooo.com/jingcai/2015-11-22/");
            // request.onreadystatechange = function() {
            //     if (request.readyState !== 4) return;
            //     if (timeout) return;
            //     clearTimeout(timer);
            //     if (request.status === 200) {
            //         // callback(request.responseText);
            //         console.log(request.responseText);
            //     }
            // }
            // request.send(null);

            // var url = "http://www.okooo.com/jingcai/2015-11-22/";
            // $.jsonp({
            //     "url": url,
            //     "success": function(data) {
            //         // $("#current-group").text("当前工作组:" + data.result.name);
            //         console.log("in success");
            //         console.log(data);
            //     },
            //     "error": function(d, msg) {
            //         console.log("in error");
            //         console.log(d);
            //         console.log(msg);
            //     }
            // });

            $("#test").load("http://www.okooo.com/jingcai/2015-11-22/");
            console.log($("#test").html());

        })
    });
})();
