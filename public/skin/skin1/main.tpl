<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/menu.css" />        
        
        <link tal:repeat="css includes/css" rel="stylesheet" type="text/css" tal:attributes="href css" />
        
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin1/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin1/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin1/css/layout.css" />
    	
    	
        
    </head>
    
    <script tal:repeat="js includes/js" type="text/javascript" language="javascript" tal:attributes="src js"></script>
	
    <script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
    
    <script tal:condition="user/admin" type="text/javascript" language="javascript" src="public/module/js/admin.js"></script>
    
    
    <body id="body" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" class="bgcolor">
	
    
    	<!-- div_includes -->
    
    	<div class="body">
            
            <div class="header">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="padding-left:5px; padding-right:5px;" >
                    <tr valign="top" >
                        <td align="left" width="30%">	<b style="font-size:17px" class="textcolor_on_bg" id="logo">eCamp2.pfadiluzern.ch</b></td>
                        <td align="center" width="40%">	<b style="font-size:12px" class="textcolor_on_bg">Willkommen <span tal:content="user/display_name" tal:omit-tag=""></span></b></td>
                        <td align="right" width="30%">	<a href="logout.php" class="textcolor_on_bg">Abmelden</a></td>
                    </tr>
                </table>
            </div>
            
            <div class="main_menu" align="center">
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
            
            <div class="bottom_bar bgcolor_content">
            	
            	<input type="image" src="./public/global/img/mini_postit.png" />
            	<img src="./public/global/img/postit.png" class="hidden" />
            </div>
        </div>
    
    
    </body>
    
</html>