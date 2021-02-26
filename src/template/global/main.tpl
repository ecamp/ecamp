<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/menu.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/color.css" />
    	
    	<link tal:repeat="css includes/css" rel="stylesheet" type="text/css" tal:attributes="href css" />
        
        
        <script tal:repeat="js includes/js" type="text/javascript" language="javascript" tal:attributes="src js"></script>
	
    	<script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
    
        
    </head>
    
    
    
    <body id="body" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" class="bgcolor_dark">
    
    	<div class="body">
            
            <div class="header bg_image">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0" style="padding-left:5px; padding-right:5px;" >
                    <tr valign="top" >
                        <td align="left" width="30%">	<b style="font-size:17px" class="textcolor_white">eCamp2.pfadiluzern.ch</b></td>
                        <td align="center" width="40%">	<b style="font-size:12px" class="textcolor_white">Willkommen <span tal:content="user/display_name" tal:omit-tag=""></span></b></td>
                        <td align="right" width="30%">	<a href="logout.php" style="color:#FFFFFF;">Abmelden</a></td>
                    </tr>
                </table>
            </div>
            
            <div class="main_menu" align="center">
                <span metal:use-macro="../module/menu/menu.tpl/menu" />
            </div>
            
            <div class="main_content" align="center"><span metal:use-macro="${main_macro}" tal:omit-tag=""/></div>
            
            <div class="main_info" align="center">
                <!-- info_display -->
            </div>
            
        </div>
    
    
    </body>
    
</html>