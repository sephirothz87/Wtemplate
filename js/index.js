(function() {
    console.log("testWildDog build 0002");

    var ref = "https://test_sephiroth.wilddogio.com/";

    $(document).ready(function() {
        $("#button_01").click(function() {
            console.log("button_01 be clicked");

            //demo1:新建数据（会将节点内容完全替换）
            //       console.log("新建数据（会将节点内容完全替换）");
            //       var user_id="00002";
            // var wd = new Wilddog(ref+"user/"+user_id);
            //       wd.set({
            //               "name": "user_00002",
            //               "basic_info":{
            //               	"sex": "male",
            //               	"age": "18"
            //               }

            //       });


            //demo2:读数据
            console.log("读数据");
            var wd = new Wilddog(ref);
            wd.child("user2").on("value",
                function(datasnapshot) {
                    console.log(datasnapshot.val());
                },
                function(errorObject) {
                    console.log("The read failed: " + errorObject.code);
                });
            // wd.child("user2").off("value", originalCallback);
            // console.log("key = " + wd.child("user").child("00001").key());

            //demo3:更新数据(只更新节点中对应的key和value，不会影响节点内的其他内容)
            //       console.log("更新数据(只更新节点中对应的key和value，不会影响节点内的其他内容)");
            // var wd = new Wilddog(ref);
            // wd.child("user/00001/basic_info").update({
            // 	"age":"24"
            // });


            //demo4:push方式新增数据，会生成一个唯一的id
            // console.log("push方式新增数据，会生成一个唯一的id");

            // var wd = new Wilddog(ref);
            // var push_1 = wd.child("user2").push({
            //     "name": "user_00003",
            //     "basic_info": {
            //         "sex": "male",
            //         "age": "18"
            //     }
            // });

            // console.log("push_1 key = " + push_1.key());

            // var push_2 = wd.child("user2").push({
            //     "name": "user_00004",
            //     "basic_info": {
            //         "sex": "female",
            //         "age": "17"
            //     }
            // });

            // console.log("push_2 key = " + push_2.key());
        });

        $("#button_02").click(function() {
            console.log("button_02 be clicked");
            // var wd = new Wilddog(ref);
            var push_1 = wd.child("user2").push({
                "name": "user_00006",
                "basic_info": {
                    "sex": "male",
                    "age": "37"
                }
            });
        });

        $("#button_03").click(function() {
            console.log("button_03 be clicked");
        });
    });
})();
