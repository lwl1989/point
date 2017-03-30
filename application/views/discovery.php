<?php require_once("public/base.php"); ?>
<link rel="stylesheet" type="text/css" href="/static/page/album.css">

</head>
<body>

<?php require_once("public/top.php"); ?>
	<div class="page">
		<div class="grid">
		
			参考：<a href="http://www.xiangqu.com/list/tag/2.html?sort=1">http://www.xiangqu.com/list/tag/2.html?sort=1</a>
			根据用户对分类的数据分析后	
			
		</div>
	</div>

<?php require_once("public/foot.php"); ?>
<script type="text/javascript">
	seajs.use(["jquery","ui/Waterfall/Waterfall"],function($){
		$(".albums li").hover(function(){
			$(this).find(".des").removeClass("d-n");
		},function(){
			$(this).find(".des").addClass("d-n");
		})
		// $('#photos').waterfall({

		// 	url: '/static/ui/Waterfall/json.js',
		// 	perNum: 5,			
		// 	ajaxTimes: 1 ,
		// 	colWidth: 290			
		// });
	
		// 按需加载方式
		// var wf_page = 0;
		// $('#photos').waterfall({
		// 	url: '/static/ui/Waterfall/json.js',
		// 	perNum: 5,			
		// 	ajaxTimes: 1
		// });

	})
</script>
</body>
</html>
