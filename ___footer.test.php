<?php
require_once '../config.inc.php';
?>


</div>

<style>
#footer {
    color: #333;
    background: #111;
    padding: 20px 0;
    border-top: 2px #fff solid;
    font-size: 14px;
    background-color: #fafafa
}

#footer .media {
    padding-top: 5px;
    padding-bottom: 5px
}

#footer .footer-pics {
    padding-top: 5px;
    padding-bottom: 5px
}

#footer>div>div>div:nth-child(1)>div>div>div.footer-pics>img {
    min-width: 35px;
    max-width: none
}

#footer>div>div>div:nth-child(2)>div>div>div.footer-pics>img {
    max-width: 55px;
    min-width: 55px
}

#footer>div>div>div:nth-child(3)>div>div>div.footer-pics>a>img {
    min-width: 35px;
    max-width: none
}

#footer .footer-text {
    font-family: 'Hind', sans-serif;
    line-height: 1.4em;
    text-align: center;
    color: #333;
    text-transform: none;
    letter-spacing: 0.05em;
    font-size: 13px
}

#footer .footer-text .bigtext {
    font-size: 1.5em;
    font-weight: 700
}

.caption {
    color: #000;
    letter-spacing: 0.1em;
    text-transform: uppercase
}

#footer .footer-text .midtext {
    font-size: 1.2em;
    font-weight: 300;
    letter-spacing: 0.2em
}

#footer .footer-text .smalltext {
    font-size: 0.9em;
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: normal
}

#footer .footer-text .smallsmalltext {
    color: #aaa;
    font-size: 0.75em;
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: normal
}

#footer .footer-text .smallsmalltext a {
    color: #aaa;
    font-size: inherit;
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: normal
}

#footer .footer-text .smallsmalltext a:hover {
    color: #999;
    text-decoration: underline
}

#service-version>div span.smallsmalltext {
    color: #aaa;
    font-size: 0.75em;
    font-weight: 200;
    text-transform: uppercase;
    letter-spacing: normal
}
</style>

<div id="service-version" class="container-fluid">
    <div class="text-right"><span class="smallsmalltext">Сервис Договор&nbsp;<span style="color:#666">Версия 201912-05
                build 2007</span></span></div>
</div>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="media">
                    <div class="media-body text-center">
                        <div class="footer-pics">
                            <img src="../../_assets/images/phone_icon.png" class="img"
                                style="max-width:none; width:2.5em"><img src="../../_assets/images/w_icon.png"
                                class="img" style="max-width:none; width:2.5em"><img
                                src="../../_assets/images/v_icon.png" class="img"
                                style="max-width:none; width:2.5em"><img src="../../_assets/images/t_icon.png"
                                class="img" style="max-width:none; width:2.5em">
                        </div>
                        <div class="footer-text">
                            <div class="bigtext caption">926 1124469</div>
                            <div class="smalltext">Прямая поддержка</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="media">
                    <div class="media-body text-center">
                        <div class="footer-pics">
                            <img src="../../_assets/images/me_icon.png" class="img-circle"
                                style="max-width:none; width:1.0em">
                        </div>
                        <div class="footer-text">
                            <span class="smalltext">Ярослав&nbsp;Чугунов</span>
                            <br>
                            <span class="smallsmalltext"><a href="#" title="Yaroslav Chugunov Corporate Web Services"
                                    target="_blank">YСCWS</a>&nbsp;&copy;&nbsp;2017-<?php echo date("Y"); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="media">
                    <div class="media-body text-center">
                        <div class="footer-pics">
                            <a href="https://chat.whatsapp.com/EcqoZZ3cfwy5VgheL62EIq" target="_blank"><img
                                    src="../../_assets/images/whatsapp_icon.png" class="img-circle"
                                    style="max-width:none; width:2.5em"></a>
                            <a href="https://t.me/joinchat/AAAAAEO6mbs1OaXr2e-GEA" target="_blank"><img
                                    src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/_assets/images/t_icon.png"
                                    class="img-circle" style="max-width:none; width:2.5em"></a>
                        </div>
                        <div class="footer-text">
                            <div class="bigtext caption">WA.Чат / ТГ.Канал</div>
                            <div class="smalltext">Групповая&nbsp;терапия</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>

</div>

<script>
$(window).load(function() {
    $('#before-load').find('i').fadeOut().end().delay(400).fadeOut('slow');
});
document.getElementById("serviceName").innerHTML = "Договор";
document.getElementById("title").innerHTML = "Договор";


$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
</script>

<script>
window.replainSettings = {
    id: '43836551-cfbe-4ba4-8c17-ae762671d6d5'
};
(function(u) {
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = u;
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
})('https://widget.replain.cc/dist/client.js');
</script>

</body>

</html>