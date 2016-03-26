<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $title; ?></title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Responsive View Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Animate.CSS -->
    <link rel="stylesheet" href="/assets/css/animate.css"> 

    <!-- Font Aewsome Style -->
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">

    <!-- Bootstrap Style -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <!-- Reset Style -->
    <link rel="stylesheet" href="/assets/css/normalize.css">

    <!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>

	<!-- Jquery -->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"/></script>

	

    <!-- Main Style -->
    <link rel="stylesheet" href="/assets/css/fortune.css">
</head>
<body>
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<h1>ระบบจะทำการสุ่มชื่อผู้ได้รับรางวัลกรุณารอสักครู่</h1>
<?php  $num = 0;
	foreach ($peoples as $people) {
		echo "<div>".$people->id."</div>";
		$num++;
} ?>
<div id="response">

</div>
<!--code>var random = 1 + Math.floor(Math.random() * 107);</code-->
<h1>ผู้ได้รับรางวัลคือ</h1>

<script>
$(document).ready(function (){
  // FLip blocks
  var $count = 1;
   
  function randomFlip() {

    var $blocks = $('div');
    var random = 1 + Math.floor(Math.random() * <?php echo $num; ?>);
//	$('#response').text(random);

    $('div:nth-child(' + random + ')').addClass('flip-it');

    interval = setInterval(function() {
      var random = 1 + Math.floor(Math.random() * <?php echo $num; ?>);
      $blocks.removeClass('flip-it');
      $('div:nth-child(' + random + ')').addClass('flip-it');
      $count++;
	  if ($count >= 7) clearInterval(interval);
    }, 2250);

  }

  function deploy() {
    randomFlip();
  }

  window.alert('สู่มผู้โชคดีโปรดคลิก');

  deploy();

});


</script>
</body>
</html>
