<!DOCTYPE html>
<html>
<head>
	<title>Eastrington Energy</title>
	
	<meta name="description" content=""><!-- put the page description in here-->
	<meta name="keywords" content=""><!-- put the keywords in here-->
	<meta name="author" content="James Briant">
	<meta charset="iso-8859-1">
	<!-- <meta http-equiv="refresh" content="300"> -->
	
	<link rel="stylesheet" type="text/css" href="css/markdown.css">

	<script src="js/jquery-1.11.1.min.js"></script> 
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	
</head>
<body>

<div id="centre">

	<h1 id="title">Markdown Syntax Example</h1>
	<br/><br/><br/>

	<div class="code">
		<div class="line">##Eastrington Energy Granted £3 Billion for Wind Turbines</div>
		<div class="line"></div>
		<div class="line">Thanks to some affluent wizard with lots of money and</div>
		<div class="line">generosity, Eastrington Energy has successfully closed a</div>
		<div class="line">deal that could save the planet for ever. Speaking on</div>
		<div class="line">behalf of the magical wizard, his little minion makes a</div>
		<div class="line">public speech about the validity of the deal.</div>
		<div class="line"></div>
		<div class="line">"I'm sure the world is shocked to hear the plans of my</div>
		<div class="line">master but this really is a completely legit deal we</div>
		<div class="line">never agreed to or even made."</div>
		<div class="line"></div>
		<div class="line">![The minion as he makes his speech]</div>
		<div class="line"></div>
	</div>

	<p id="examplelink"><a href="article.php?alpha=cDXxTUP">Click here to see what this article would look like.</a></p>

</div>

<script>

$(function(){
	$(".line").each(function(index){
		var num = index + 1;
		$(this).before('<div class="precode">'+num+'</div>');
	});

	var height = $(".precode").height();
	$(".line").css({"height":height});
});

</script>

</body>
</html>