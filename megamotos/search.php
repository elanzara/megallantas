<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <script src="js/jquery.equalheights.js"></script>
	<script src="search/search.js"></script>

    <!--[if lt IE 9]>
    <html class="lt-ie9">
    <div id="ie6-alert" style="width: 100%; text-align:center; background: #232323;">
        <img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0"
             usemap="#Map" longdesc="http://die6.frontcube.com"/>
        <map name="Map" id="Map">
            <area shape="rect" coords="496,201,604,329"
                  href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank"
                  alt="Download Interent Explorer"/>
            <area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank"
                  alt="Download Apple Safari"/>
            <area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank"
                  alt="Download Opera"/>
            <area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank"
                  alt="Download Firefox"/>
            <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank"
                  alt="Download Google Chrome"/>
        </map>
    </div>

    <script src="js/html5shiv.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
    <![endif]-->
</head>

<body>
    <div id="fb-root"></div>

    <div class="page">
        <!--========================================================
                                  HEADER
        =========================================================-->
        <header id="header" class="header">
            <div class="container header-panel">
                <div class="brand">
                    <h1>
                        <a href="./" class="paw-ripple-effect" data-color="#fff">
                            <span>Bikes</span>
                            repair
                        </a>
                    </h1>
                </div>
                <address class="header-address">
                    <p>Need help? Contact Us!</p>

                    <div class="email">Email: <a href="#">info@demolink.org</a></div>
                    <div class="phone">80023456789</div>
                </address>
            </div>

            <div id="stuck_container" class="stuck_container">
                <div class="container">
                    <div class="row">
                        <div class="grid_12">
                            <form id="search" data-type="paw-search-form" class="search-form" action="search.php" method="GET"
                                  accept-charset="utf-8">
                                <label class="input">
                                    <input class="_input" type="text" name="s" value="Search..."
                                           onblur="if(this.value == '') { this.value='Search...'}"
                                           onfocus="if (this.value == 'Search...') { this.value = '' }" />
                                </label>
                                <button class="submit" type="submit">
                                    <span class="fa fa-search"></span>
                                </button>
                            </form>

                            <nav class="nav">
                                <ul class="sf-menu" data-type="paw-sidenav">
                                    <li>
                                        <a href="./">Home</a>
                                    </li>
                                    <li>
                                        <a href="index-1.html">About</a>
                                        <ul>
                                            <li><a href="#">Lorem ipsum</a></li>
                                            <li>
                                                <a href="#">Dolor sit amet </a>
                                            </li>
                                            <li>
                                                <a href="#">Conse ctetur </a>
                                                <ul>
                                                    <li><a href="#">Sit amet ipsum</a></li>
                                                    <li><a href="#">Lorem conse amet</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="index-2.html">
                                            Services
                                        </a>
                                    </li>
                                    <li>
                                        <a href="index-3.html">News</a>
                                    </li>
                                    <li>
                                        <a href="index-4.html">Contacts</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--========================================================
                                  CONTENT
        =========================================================-->
        <section id="content" class="content">
			<div class="container well__ins2 well__ins3">
                <h4>Search Results</h4>

				<div class="row">
					<div class="grid_12">
						<div id="search-results"></div>
					</div>
				</div>
            </div>
		</section>

<!--========================================================
                          FOOTER
=========================================================-->
<footer id="footer" class="footer">
	<div class="container">
		Bikes repair © <span id="copyright-year"></span>. <a href="index-5.html">Privacy Policy</a>
	</div>
</footer>

<script src="js/script.js"></script>
</body>
</html>