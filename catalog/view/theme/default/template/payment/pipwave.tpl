<div id="pwscript" class="text-center">
    <span style="font-size: 20px; vertical-align: text-top; margin-right: 10px;"><?php echo $text_pay_via; ?></span>
    <img src="admin/view/image/payment/pipwave.png">
    <hr />
</div>
<div id="pwloading" class="text-center">
    <i class="fa fa-spinner fa-spin fa-fw margin-bottom" style="font-size: 3em; color: #7a7a7a;"></i>
    <span class="sr-only">Loading...</span>
</div>
<script type="text/javascript">
    var pwconfig = < ?php echo $api_data; ? > ;
            (function (_, p, w, s, d, k) {
                _.require ={baseUrl:s};
                var pwscript = _.createElement("script");
                pwscript.setAttribute('data-main', w + s);
                pwscript.setAttribute('src', w + d);
                setTimeout(function () {
                    var reqPwInit = (typeof reqPw != 'undefined');
                    _.getElementById(k).parentNode.replaceChild(pwscript, _.getElementById('pwloading'));
                    if (reqPwInit) {
                        reqPw(['pw'], function (pw) {
                            pw.setOpt(pwconfig);
                            pw.startLoad();
                        });
                    }
                }, 800);
            })(document, 'script', "//staging-checkout.pipwave.com/sdk/", "pw.sdk.js", "lib/require.js", "pwscript");
</script>