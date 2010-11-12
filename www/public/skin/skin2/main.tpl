<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/menu.css" />        
        
        <link tal:repeat="css includes/css" rel="stylesheet" type="text/css" tal:attributes="href css" />
        
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin2/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin2/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin2/css/layout.css" />
    	
    	
        
    </head>
    
    
    <script tal:repeat="js includes/js" type="text/javascript" language="javascript" tal:attributes="src js"></script>
	
    <script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
    
    <script tal:condition="user/admin" type="text/javascript" language="javascript" src="public/module/js/admin.js"></script>
	
	
    <body id="body" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" class="bgcolor">
	
    
    	<!-- div_includes -->
    
    	<div class="body">
            
            <div class="logout">
            	<a href="logout.php">
                  <span class="action-button-left" style="background:url(public/skin/skin2/img/button_1.gif);"></span>
                  <span class="action-button-text" style="background:url(public/skin/skin2/img/button_2.gif);">Abmelden</span>
                  <span class="action-button-right" style="background:url(public/skin/skin2/img/button_3.gif);"></span>
                </a>
            </div>
            
            <div class="header">
              e huufe Platz für süsch ergend öppis... 
              e huufe Platz für süsch ergend öppis...
              e huufe Platz für süsch ergend öppis...
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
        </div>
    
    
    </body>
    
</html>