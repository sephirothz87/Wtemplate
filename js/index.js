(function() {
    console.log("build 0001");

    $(document).ready(function() {

        $("#button_01_login").click(function() {
            console.log("button 01 be clicked");
            var pw = $("#password").val();
            $("#password").val(md5(pw));
            $("#formLogin").submit();
        });

        $("#button_02_regist").click(function() {
            console.log("button 02 be clicked");
            var pw = $("#password").val();
            $("#password").val(md5(pw));
            $("#formRegist").submit();
        });

    });
})();
