<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Site Title Goes Here!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
		<link rel="stylesheet" href="css/masonry.css">
		<link rel="stylesheet" href="css/fancybox.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

		<div id="loading" style="text-align: center;color: white;margin-top: 100px;">
			<noscript><p>JavaScript is off. Please enable it to view this page.</p></noscript>
			<p class="loading"><img class="center" src="/img/vc_loading_anim.gif"/></p>
			<p class="loading">Hold on...We're searching Instagram for all the pics tagged #yourHashtagHere!</p>
		</div>

        <div class="main-container">



				<?php
					// Supply a user id and an access token
					$userid = "self";
					// input your access token for the instagram api here
					$accessToken = "";
					// using the -1 count displays all photos otherwise specify a number
					$count = "-1";
					$tagname = "YourHashtagHere";
					// Gets our data
					function fetchData($url){
					     $ch = curl_init();
					     curl_setopt($ch, CURLOPT_URL, $url);
					     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
					     $result = curl_exec($ch);
					     curl_close($ch); 
					     return $result;
					}

					// Pulls and parses data.
					$result = fetchData("https://api.instagram.com/v1/tags/{$tagname}/media/recent/?access_token={$accessToken}&count={$count}");
					$result = json_decode($result);
				?>

				<div id="container" class="clearfix masonry transitions-enabled">
					<div class="corner-stamp masonry-brick item"></div>
					<?php foreach ($result->data as $post): ?>
						
						<!-- Renders images. @Options (thumbnail,low_resoulution, high_resolution) -->
						<div class="item">
							<a class="group" title="<?= $post->caption->text ?> (Uploaded by: @<?= $post->user->username ?>)" rel="group1" href="<?= $post->images->standard_resolution->url ?>"><img title="<?= $post->caption->text ?> (Uploaded by: @<?= $post->user->username ?>)" src="<?= $post->images->thumbnail->url ?>"><span class="hover_info">Uploaded by: @<?= $post->user->username ?></span><span class="overlay"></span></a>
						</div>
					<?php endforeach ?>
				</div>

				
			<footer>
				<p>Personalized footer message goes here!</p>
			</footer>
        </div> <!-- #main-container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

        <script src="js/main.js"></script>
		<script src="js/vendor/masonry.js"></script>
		<script src="js/vendor/fancybox.js"></script>
		
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("a.group").fancybox({
					'nextEffect'	:	'fade',
					'prevEffect'	:	'fade',
					helpers : {
					        title: {
					            type: 'inside'
					        }
					    }
				});
				
				
				// Masonry corner stamp modifications
				  $.Mason.prototype.resize = function() {
				    this._getColumns();
				    this._reLayout();
				  };


				var $container = $('#container');

				$container.imagesLoaded( function(){
				  $container.masonry({
				    itemSelector : '.item',
					cornerStampSelector: '.corner-stamp',
					columnWidth: 1
				  });
				});
			});
			
			$(window).load(function(){
				// HIDE SPINNER, SHOW APP
				$('#loading').hide();
				$('.main-container').fadeIn();
			});
			
		</script>
    </body>
</html>
