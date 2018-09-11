<!doctype html>
<html lang="zh">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.0.4/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="sass/ydui.css">
	<link rel="stylesheet" type="text/css" href="sass/index.css">
	<link rel="stylesheet" type="text/css" href="sass/open.css">
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
					您今天还有 <span id="times">{{ $residue }}</span> 次抽奖机会
				</span>
			</div>
			<div class="swiper-container swiper-container-horizontal" id="swiper-container1">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="navbar-center lotto">
							<div class="imshar"></div>
							<img src="/img/anniu.png" class="dot">
							<div class="up-b"><img src="/img/up.png"></div>
						</div>
					</div>
					@foreach ($cards as $card)
					<div id="{{ 'hb_' . $card['id'] }}" class="swiper-slide heibai" data-card-id="{{ $card['id'] }}">
						<a class="btn-block gicai_kapiao btn-disabled" href='javascript:void(0);'>送一张给朋友</a>
						<img src="{{ $card['image'] }}" class="main-img">
					</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="swiper-container swiper-container-horizontal" id="swiper-container2">
			<div class="swiper-wrapper">
				@foreach ($cards as $card)
                    <div id="{{ 'heibai_' . $card['id'] }}" class="swiper-slide swiper-slide-active active-nav {{ $card['num'] > 0 ? '' : 'heibai' }}">
                        <img src="{{ $card['thumb'] }}" alt="{{ $card['title'] }}">
                        <i class="badge" id="{{ 'num_' . $card['id'] }}">{{ $card['num'] }}</i>
                    </div>
				@endforeach
			</div>
		</div>
		<div class="wrapper" id="baoxiang">
			<div class="bg rotate"></div>
			<div class="open-has ">
				<h3 class="title-close">
					<div class="title">点击开启您的幸运宝箱！</div>
				</h3>
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
	<script src="/js/jweixin-1.4.0.js"></script>
	<script type="text/javascript" src="/js/ydui.js"></script>
	<script>
        wx.config({!! json_encode($config) !!});

        var random = function () {
			return Math.random().toString(36).substr(2);
        };

        wx.ready(function () {   //需在用户可能点击分享按钮前就先调用

			var share_message = {
                title: '分享标题', // 分享标题
                desc: '分享描述', // 分享描述
                link: location.origin + '/', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: location.origin + '/', // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function (res) {
                    // 用户点击了分享后执行的回调函数
                    alert(111)
                }
            };
            wx.onMenuShareAppMessage(share_message);

            // 分享
            $('.gicai_kapiao').on('click', function () {
                var token = random() + random();
                var card_id = $(this).parent('div').attr('data-card-id');
                share_message.link = location.origin + '/?token=' + token + '&card_id=' + card_id;
                share_message.success = (function (card_id) {
                    return function () {
                        $.post('/given', {token: token, card_id: card_id}, function (data) {
                            alert(JSON.stringify(data));
                        })
                        alert(222);
                    }
                })(card_id);
                //wx.onMenuShareAppMessage(share_message);
            })
        });

		var mySwiper1 = new Swiper('#swiper-container1', {})
		var mySwiper2 = new Swiper('#swiper-container2', {
			watchSlidesProgress: true,
			watchSlidesVisibility: true,
			slidesPerView: 5,
			onTap: function () {
				mySwiper1.slideTo(mySwiper2.clickedIndex + 1)
			}
		})
		//	开启宝箱
		$(".chest-close").click(function () {
			$(".chest-close").unbind();
			$(this).addClass("shake");
			var that = this;
			YDUI.dialog.loading.open('loading...');
			$.ajax({
				url: 'http://fivefu.lzp.name/lottery',
				type: 'GET',
				data: {},
				success: function (res) {
					YDUI.dialog.loading.close();
					$("#baoxiang").fadeOut(100);
					if (res.code == '200') {
						var data = res.data.card
						YDUI.dialog.alert(
							'<div class="alert_por">' +
							'<img src="' + data.image + '" class="btn-disabled" />' +
							'<div class="buttons">' +
							'<div onClick="javascript:addfuka(' + data.id + ',`' + data.title + '`);" class="btn btn-hollow">点击领取</div>' +
							'</div>' +
							'</div>');
						$("#YDUI_ALERT .primary").html('<i class="icon-error" style="color:#ffffff;font-size:25px"></i>');
						// if ($residue<0 || $residue = 0) return;
						// else $residue - 1;
					} else if (res.code == '101') {
						YDUI.dialog.loading.close();
						YDUI.dialog.alert(res.message)
					}
				}
			})
		});
		//	抽奖
		$(".imshar").click(function () {
			YDUI.dialog.loading.open('loading...');
			$.ajax({
				url: 'http://fivefu.lzp.name/lottery',
				type: 'GET',
				data: {},
				success: function (res) {
					YDUI.dialog.loading.close();
					if (res.code == '200') {
						var data = res.data.card
						YDUI.dialog.alert(
							'<div class="alert_por">' +
							'<img src="' + data.image + '" class="btn-disabled" />' +
							'<div class="buttons">' +
							'<div onClick="javascript:addfuka(' + data.id + ',`' + data.title + '`);" class="btn btn-hollow">点击领取</div>' +
							'</div>' +
							'</div>');
						$("#YDUI_ALERT .primary").html('<i class="icon-error" style="color:#ffffff;font-size:25px"></i>');
						// if ($residue < 0 || $residue = 0) return;
						// else $residue - 1;
					} else if (res.code == '101') {
						YDUI.dialog.loading.close();
						YDUI.dialog.alert(res.message)
					}
				}
			})
		});

		//	获得福卡
		function addfuka(id, title) {
			var ecahse = '';
			$("#swiper-container2 .swiper-wrapper div").each(function (s) {
				if ($("#swiper-container2 .swiper-wrapper div:eq(" + s + ")").attr("id") == "heibai_" + id) {
					ecahse = s;
				};
			});
			var hollows = Math.floor($('#num_' + id).html());
			$('#num_' + id).html(hollows + 1);
			YDUI.dialog.notify("恭喜获得一张" + title + "", 2000, function () { });
			$("#heibai_" + id).removeClass("heibai"); 
			$("#hb_" + id).removeClass("heibai");
			$("#hb_" + id).find('a').removeClass("btn-disabled");

			$("#YDUI_ALERT").fadeOut(300);
			$("#baoxiang").fadeOut(10);
			// if ($residue < 0 || $residue = 0) return;
			//  $residue - 1;
		}
	</script>
</body>

</html>