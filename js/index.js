(function() {
    console.log("build 0001");

    $(document).ready(function() {
        $("#button").click(function() {
            console.log("button be clicked");
            var pw = $("#password").val();
            $("#password").val(md5(pw));
            $("#form").submit();
        })
    });
})();