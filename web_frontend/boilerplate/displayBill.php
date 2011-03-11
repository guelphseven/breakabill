<?php
	require_once "../../db/lib.php";
	session_start();
	if (!isset($_SESSION['username']))
	{
		header("Location: login.php");
		exit();
	}
	
	startSQLConnection();
	//$bills = findOpenBills($_SESSION['userid']);
	$bill = getBillByID($_GET['bill']);
?>
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
  <link rel="stylesheet" href="css/receipt.css?v=2">
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css">

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->
 
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

	<div class="receipt">
		<div class="title"><span><?echo $bill['billName'];?></span></div>
		<div class="clear">&nbsp;</div>
		<div class="sheet">
			<div class="title">&nbsp;</div><div class="field">&nbsp;</div>
			<div class="clear">&nbsp;</div>
			<div class="title">Due: </div><div class="field"><?echo $bill['dueDate'];?></div>
			<div class="clear">&nbsp;</div>
			<div class="title">Total: </div><div class="field">$<?echo $bill['billAmount'];?></div>
			<div class="clear">&nbsp;</div>
			<div class="title">&nbsp;</div><div class="field">&nbsp;</div>
			<div class="clear">&nbsp;</div>
			<div class="title">Your Amount: </div><div class="field">$<?echo $bill['ownerAmount'];?></div>
			<div class="clear">&nbsp;</div>
<?
			$tally = $bill['ownerAmount'];
			foreach ($bill['people'] as $debtor)
			{
				$tally += $debtor['amount'];
?>
			<div class="title"><?echo $debtor['name'];?></div><div class="field">$<?echo $debtor['amount'];?></div>
			<div class="clear">&nbsp;</div>
<?
			}
			$diff = $bill['billAmount'] - $tally;
			if ($diff > 0)
			{
			
			}
?>
			<div class="title">&nbsp;</div><div class="field">&nbsp;</div>
			<div class="clear">&nbsp;</div>
			<div class="title">Amount Left:</div><div class="field">$<?echo $diff;?></div>
			<div class="clear">&nbsp;</div>
		</div>
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
  	$(document).ready(function() {
		$( "button" ).button();
		$( ".controls a" ).button();
		$( ".controls a" ).css('margin-left', '25px');
	});
  </script>

  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
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
