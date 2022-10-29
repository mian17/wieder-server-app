<head>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('/verify-email-successfully.css')}}"/>
{{--    <meta http-equiv="refresh" content="5;URL='http://localhost:3000'">--}}
    <title>Xác nhận Email</title>
</head>
<body>
<div>
    <header class="site-header" id="header">
        <h1 class="site-header__title" data-lead-id="site-header-title">XÁC NHẬN EMAIL THÀNH CÔNG!</h1>
    </header>

    <div class="main-content">
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
        <p class="main-content__body" data-lead-id="main-content-body">
            Cảm ơn bạn rất nhiều vì đã đăng ký tài khoản tại Wieder_ Markt.
            Trang sẽ được chuyển hướng đến trang chính sau <span class="duration">5</span> giây.
            Nếu không chuyển trang được, bạn vui lòng nhấn đường dẫn <a href="http://localhost:3000">tại đây</a>
        </p>
    </div>

    <footer class="site-footer" id="footer">
        <p class="site-footer__fineprint" id="fineprint">Copyright ©2022 Wieder_ Markt | All Rights Reserved</p>
    </footer>
</div>
</body>
<script>
    let duration = 5;
    window.onload = function () {
        setInterval(function () {
            if (duration > 0) {
                duration--;
            }
            document.querySelector(".duration").innerHTML =  duration.toString();
            if (duration <= 0) {
                window.location.href = "http://localhost:3000/signin";
                document.querySelector(".duration").innerHTML =  duration.toString();
            }
        }, 1000);
    }
</script>
