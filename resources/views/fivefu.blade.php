<!doctype html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.4/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="./sass/index.css">
	<link rel="stylesheet" type="text/css" href="./sass/open.css">
	<title>Document</title>
	<script>
		function size() {
			var wDpr = window.devicePixelRatio;
			var deviceWidth = document.documentElement.clientWidth;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px'; //根据设计的尺寸宽度而定,这边设定的尺寸是750px的。
	        document.getElementsByTagName("html")[0].setAttribute("data-dpr", wDpr);
	    }
	    size();
	    window.onresize = function () {
	    	size();
	    }
	</script>
</head>
<body>
	<div class="container open-body">
		<header class="navbar">
			<div class="navbar-center">
				<div>
					<h2>集齐福卡，拼手气瓜分红包</h2>		
				</div>
			</div>
		</header>
		<div class="g-scrollview">
			<div class="navbar-center">
				<span>
					您还有 <span id="times">5</span> 次抽奖机会
				</span> 
			</div>
			<div class="swiper-container swiper-container-horizontal" id="swiper-container1"> 
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="navbar-center lotto">
							<div class="imshar"></div>
							<img src="http://www.ilvle.com/addons/gicai_xyx/public/default/images/anniu.png" class="dot">
							<div class="up-b"><img src="/img/up.png"></div>
						</div>
					</div>
					<div id="hb_2" class="swiper-slide heibai">
						<a class="btn-block gicai_kapiao btn-disabled" href='javascript:song("2d76D03ySDT65eteXvyh+y2wVHLq84jk2WqHxEmC5P1u+J0zEtpSURTB","祝","富强福");'>送一张给朋友</a> 
						<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/GV2aljz1XV0ArgGjr21aJX0y0jEn1l.jpg" class="main-img">
					</div>
					<div id="hb_3" class="swiper-slide heibai">
						<a class="btn-block gicai_kapiao btn-disabled" href='javascript:song("2d76D03ySDT65eteXv/0+S3jBnDt947t2z/akEqD5P1u+J0zEtpSURTB","爱","爱国福");'>送一张给朋友</a> 
						<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/GV2aljz1XV0ArgGjr21aJX0y0jEn1l.jpg" class="main-img">
					</div>
				</div>
			</div>
		</div>
		<div class="swiper-container swiper-container-horizontal" id="swiper-container2">
			<div class="swiper-wrapper">
				<div id="heibai_2" class="swiper-slide heibai swiper-slide-active active-nav">
					<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/T932j22Ws2sCJSyvsZ2s239s91Hy29.png">
					<i class="badge" id="num_2">0</i>
				</div>

				<div id="heibai_3" class="swiper-slide heibai swiper-slide-visible swiper-slide-next">
					<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/Gp7mmF7Zgf6E3mWfEFR6Y3eFMImy5n.png">
					<i class="badge" id="num_3">0</i>
				</div>

				<div id="heibai_4" class="swiper-slide heibai swiper-slide-visible">
					<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/T932j22Ws2sCJSyvsZ2s239s91Hy29.png">
					<i class="badge" id="num_4">0</i>
				</div>

				<div id="heibai_5" class="swiper-slide heibai swiper-slide-visible">
					<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/sZCQCuOCVFCOq4svcKBEGfcKEpBdOU.png">
					<i class="badge" id="num_5">0</i>
				</div>
				<div id="heibai_5" class="swiper-slide heibai swiper-slide-visible">
					<img src="http://ilvle.img.web.ilvle.com/ilvle/images/10/2018/01/sZCQCuOCVFCOq4svcKBEGfcKEpBdOU.png">
					<i class="badge" id="num_5">0</i>
				</div>
			</div>
		</div>
		<div class="wrapper" id="baoxiang">
			<div class="bg rotate"></div>
			<div class="open-has ">
				<h3 class="title-close">
					<div  class="title">点击开启您的幸运宝箱！</div></h3>
				<div class="mod-chest">
					<div class="chest-close show">
						<div class="gift"></div>
						<div class="tips">
							<i class="arrow"></i>
						</div>
					</div>
					<div class="chest-open">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.4/js/swiper.min.js"></script>
	<script type="text/javascript" src="/js/ydui.js"></script>
	<script> 
		var mySwiper1 = new Swiper('#swiper-container1', {})
		var mySwiper2 = new Swiper('#swiper-container2', {
			watchSlidesProgress : true,
			watchSlidesVisibility : true,
			slidesPerView : 5,
			onTap: function(){
				mySwiper1.slideTo(mySwiper2.clickedIndex+1)
			}
		})
		$(".chest-close").click(function(){
			$(".chest-close").unbind();
			$(this).addClass("shake");
			var that=this;
			setTimeout(function(){
				$(that).removeClass("show");
				$(that).closest(".mod-chest").find(".chest-open").addClass("show");
				setTimeout(function(){
					$("#baoxiang").fadeOut(10);
				},800)

			},200);

			this.addEventListener("webkitAnimationEnd", function(){}, false);

		});	
	</script>
</body>
</html>