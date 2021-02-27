<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/menu.css" />        
        
        <link tal:repeat="css cssIncludes" rel="stylesheet" type="text/css" tal:attributes="href css" />
        
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/layout.css" />

      <script
        tal:condition="sentry_dsn_js"
        src="https://browser.sentry-cdn.com/6.2.0/bundle.min.js"
        integrity="sha384-PWBASVWyeEeNsEw6zDTEwryGvuiH1xuxnlu/n+GOI777vnfbqyYLzqCf+najQLoi"
        crossorigin="anonymous"
      ></script>
    	
	    <script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
    	
    	
    	<script tal:repeat="js jsIncludes" type="text/javascript" language="javascript" tal:attributes="src js"></script>
		
	    
	    <script tal:condition="user/admin" type="text/javascript" language="javascript" src="public/module/js/admin.js"></script>
	    <script type="text/javascript" language="javascript" src="public/module/js/info_box.js"></script>
    </head>
    
    
        
    <body id="body" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" class="bgcolor">
	
    
    	<!-- div_includes -->
    
    	<div class="body">
            
            <div class="faq">
            	<a href="index.php?app=faq">
                  FAQ
                </a>
            </div>
            
            <div class="impressum">
            	<a href="index.php?app=impressum">
                  Impressum
                </a>
            </div>
            
            <div class="logout">
            	<a href="logout.php">
                  <span class="action-button-left" style="background:url(public/skin/skin3/img/button_1.gif);"></span>
                  <span class="action-button-text" style="background:url(public/skin/skin3/img/button_2.gif);">Abmelden</span>
                  <span class="action-button-right" style="background:url(public/skin/skin3/img/button_3.gif);"></span>
                </a>
            </div>
            
            <div class="header">
        	    <div style="font-size:13px;">
		            <b tal:content="user/display_name" style="font-size:15px;" />, willkommen bei eCamp - 
              		Lager und Kurse vorbereiten und planen
            	</div>
            </div>
            
            <div class="main_menu" align="center">
			<img id="logo" src="./public/skin/skin2/img/ecamp.gif" style="margin-bottom:10px" />
               <span metal:use-macro="${tpl_dir}/module/menu/menu.tpl/menu" />
            </div>
            
            <div class="main_content" align="center">
            	<span metal:use-macro="${main_macro}" />
            </div>
            
            <div class="main_info" align="center">
            	<tal:block condition="show_info_box">
            		<span metal:use-macro="${info_box}" />
                	<!-- info_display -->
                </tal:block>
            </div>
            
            <!--
            <div class="main_bottom_menu">
            	<span metal:use-macro="${tpl_dir}/global/bottom_menu.tpl/bottom_menu" />
            </div>
            -->
        </div>
    
    
    </body>

    <script tal:condition="sentry_dsn_js" type="text/javascript">
      Sentry.init({
        dsn: "${sentry_dsn_js}",
        environment: "${sentry_environment}"
      });
    </script>

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-38013612-1']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
</html>
