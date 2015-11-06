var USER_NAME_INFO = "3-15个字符，英文开头";
var PASSWORD_INFO = "";
var PASSWORD_CONFIRM_INFO = "";

var REG_USERNAME = /^[a-z]\w{2,14}$/;
var REG_PASSWORD = /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/;

(function() {
    console.log("regist 0001");

    $(document).ready(function() {
        $("#username").text("123");

        $("#button").click(function() {
            var un = $("#username").val();
            var un_match = un.match(REG_USERNAME);
            console.log(un_match);

            if (!un_match) {
                $("#info").text("用户名不合法");
                return;
            }

            var pwd = $("#password").val();

            var pwd_match = pwd.match(REG_PASSWORD);
            console.log(pwd_match);

            if (!pwd_match) {
                $("#info").text("密码不合法");
                return;
            }

            var pwdc = $("#passwordConfirm").val();

            if (pwd != pwdc) {
                $("#info").text("两次输入不一致");
                return;
            }

            console.log("提交");
            // $("#formRegist").submit();

            var data = $("#formRegist").serializeArray();
            console.log(data);

            $.ajax({
                url: "php/regist.php",
                type: "post",
                data: data,
                success: function(res) {
                    console.log("success");
                    console.log(res);
                    // if (res.status == "success") {

                    // } else {

                    // }
                },
                error: function() {
                    console.log("error");
                    console.log(res);
                }
            });
        });

    });
})();
