if(document.all && !window.opera && !window.XMLHttpRequest)
{
    $(document).ready(function() 
    {
        $('#content-start').append('<span class="ie-hidden">.</span>');
        ca_warn_ie6();
    });
}

// Update browser message to IE6 users
function ca_warn_ie6()
{
    if(ca_cookie_get('noie6') == 1)
    {
        return;
    }
    $('#content-start').append('<div class="rules" id="ie6"><div class="block-border block-block"><div class="block-header"><span></span><div></div></div><div class="block-content"><div class="block-inner"><div class="block-inner2">					<strong>Did you know that your browser is out of date?</strong><br /><br />			To get the best possible experience using our website we recommend that you upgrade your browser to a newer version. The current version is <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">Internet Explorer 8</a>. The upgrade is free. If you\'re using a PC at work you should contact your IT administrator.<br /><br />If you want to you may also try some other popular secure modern Internet browsers like <a href="http://getfirefox.com/">Firefox</a>, <a href="http://www.opera.com/">Opera</a>, <a href="http://www.apple.com/safari/download/">Safari</a> or <a href="http://www.google.com/chrome">Google Chrome</a>. These browsers are very secure, have better support for latest technologies and are much faster than Internet Explorer.<br /><br />There is no excuse to use a 8 years old outdated web browser.<br /><br /><a href="javascript:void(0);" onclick="document.getElementById(\'ie6\').style.display = \'none\'; ca_cookie_set(\'noie6\', \'1\'); return false;">Hide this warning</a>				<div class="block-clear"></div></div></div></div><div class="block-footer"><span></span><div></div></div></div>	</div>');
}
