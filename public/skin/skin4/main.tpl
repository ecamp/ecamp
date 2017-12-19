<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>eCamp v2</title>

        <link rel="stylesheet" type="text/css" href="./public/global/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/menu.css" />        
        
        <link tal:repeat="css cssIncludes" rel="stylesheet" type="text/css" tal:attributes="href css" />

        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/layout.css" />

        <script type="text/javascript" src="./public/global/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="./public/global/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript">
			jQuery.noConflict();
        </script>
    	
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
            	<span metal:use-macro="./template/global/bottom_menu.tpl/bottom_menu" />
            </div>
            -->
        </div>
    </body>
</html>