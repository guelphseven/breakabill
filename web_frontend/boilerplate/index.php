<!doctype html>  

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!--  Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
  	<meta name="HandheldFriendly" content="true" />


  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS : implied media="all" -->
  <link rel="stylesheet" href="css/style.css?v=2">
  <link rel="stylesheet" href="css/style_kiel.css?v=2">
  <link rel="stylesheet" href="css/style_paul.css?v=2">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

  <div id="maincontainer" class="billcontainer">
    <header>
	<h1>Break A Bill</h1>
    </header>
    
    <div id="main">
		<div id="left">
				<br/>
				<p>Bill Title:<input id="billName" value="<?php if( isset($_REQUEST['billName']) ) { echo $_REQUEST['billName']; } ?>" /></p>
				<br/>
				<p>Name: <input id="billMaker" value="<?php if( isset($_REQUEST['name']) ) { echo $_REQUEST['name']; } ?>"/></p>
				<br/>
				<p>Email: <input id="makerEmail" value="<?php if( isset($_REQUEST['email']) ) { echo $_REQUEST['email']; } ?>"></p>
				<br/>
				<p>Amount: <input id="billAmount" type="number" min="0" value="<?php if( isset($_REQUEST['bill']) ) { echo $_REQUEST['bill']; }else{echo 0;} ?>"/></p>
				<br/>
				<p>Due: <input type="text" id="datepicker"></p>
				<br/>
				<p>
					<button style="float:left;" id="save">Save</button>
					<button style="float:right;" id="send">Send</button>
				</p>
				<br/>
		</div>
		<div class="right" id="rightpane">
				<div class="peoplecontainer" id="people"></div>
				<div class="addcontainer"><button class="add" id="addPerson" onclick="addPerson()">Add Person</button></div>
				<input type="hidden" value="0" id="total-people"/>
				<br style="clear: both"/>
		</div>
    </div>
    
    <footer>

    </footer>
  </div> <!--! end of #container -->
  <div class="footer">
	<div class="right">The Guelph Seven</div>
  </div>
  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.1.js"%3E%3C/script%3E'))</script>
  <!--
  <script>
  	$(function() {
		$( "#save" ).click(function(){
			//$.ajax(url:"localhost");	
		});
		$( "#send" ).click(function(){
			
		});
	});
  </script>-->
  <script>
  	$(function() {
		$( "#datepicker" ).datepicker();
		$( "button" ).button();
	});
  </script>

  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <script src="js/json2.js"></script>
  <script src="js/script_kiel.js"></script>
  <script src="js/script_paul.js"></script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg'); //fix any <img> or .png_bg background-images </script>
  <![endif]-->



  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
       change the UA-XXXXX-X to be your site's ID -->
  <script>
   var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
  </script>
</body>
</html>
