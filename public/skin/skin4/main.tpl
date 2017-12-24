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
        <script type="text/javascript">
			jQuery.noConflict();
        </script>
    	
	    <script tal:content="structure js_code" type="text/javascript"></script>

    	<script tal:repeat="js jsIncludes" type="text/javascript" tal:attributes="src js"></script>

	    <script tal:condition="user/admin" type="text/javascript" src="public/module/js/admin.js"></script>
	    <script type="text/javascript" src="public/module/js/info_box.js"></script>
    </head>
    <body id="body">
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="https://www.ecamps.ch/">
                            eCamp v2
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            <li><a href="index.php?app=faq">FAQ</a></li>
                            <li><a href="index.php?app=impressum">Impressum</a></li>
                            <li><a href="logout.php"><button class="btn btn-danger">Abmelden</button></a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

    	<!-- div_includes -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Menü</b></div>
                        <div class="panel-body">
                            <p class="center-image"><img id="logo" src="./public/skin/skin4/img/ecamp.gif" /></p>
                            <span metal:use-macro="${tpl_dir}/module/menu/menu.tpl/menu" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <span metal:use-macro="${main_macro}" />

                    <tal:block condition="show_info_box">
                        <span metal:use-macro="${info_box}" />
                        <!-- info_display -->
                    </tal:block>
                </div>
            </div>
        </div>
    </body>
</html>