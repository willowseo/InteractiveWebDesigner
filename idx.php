<?PHP
header("Content-type:text/HTML; Charset=UTF-8");

?>
<!DOCTYPE html>
<html>
	<head>
		<title>INTEractive webDesigner</title>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="http://wli.kr/whtml/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://wli.kr/whtml/jquery-ui.css" >
		<style>
			/* 스타일은 포지션-마진-패딩-보더-백그라운드-너비-높이-좌표(상, 좌, 우, 하) 순서로 둘 것 */
			html, body
			{
				margin:0px;
				padding:0px;
				background:#EEE;
				
				min-width:1200px;
				min-height:840px;
			}
			
			#QIDtopToolBar
			{
				position:fixed;
				margin:0px;
				padding:5px;
				background-color:#222;
				color:#FFF;
				
				height:28px;
				top:0px;
				left:0px;
				right:0px;
				
				line-height:28px;
			}
			
			#QIDtopMenuBar
			{
				position:fixed;
				margin:0px;
				background-color:#DDD;
				
				height:24px;
				top:38px;
				left:0px;
				right:0px;
				
				line-height:24px;
			}
			
			#QIDtopMenuBar .contextMenuHeader
			{
				padding-left:8px;
				padding-right:8px;
				
				cursor:default;
				display:inline-block;
				float:left;
				font-size:13px;
			}
			
			#QIDtopMenuBar .contextMenuHeader:hover
			{
				background-color:#57A2F2;
				color:#FFF;
			}
			
			#QIDleftToolBox
			{
				position:fixed;
				margin:0px;
				padding:0px;
				background-color:#EEE;
				
				width:180px;
				
				top:62px;
				left:0px;
				bottom:30px;
			}
			
			#QIDleftToolBox .listItem
			{
				display:block;
				
				padding:5px;
				padding-left:10px;
				
				font-size:13px;
			}
			
			#QIDleftToolBox .listItem:hover
			{
				background:#57A2F2;
				color:#FFF;
			}
			
			#QIDrightCSSbar .listItemT
			{
				display:block;
				
				padding:5px;
				padding-left:10px;
				
				font-size:13px;
			}
			
			#QIDrolerX
			{
				position:fixed;
				background:url(img/rolerX.png);
				height:14px;
				
				top:62px;
				left:194px;
				right:300px;
			}
			
			#QIDrolerY
			{
				position:fixed;
				background:url(img/rolerY.png);
				width:14px;
				
				top:76px;
				left:180px;
				bottom:30px;
			}
			
			#QIDrolerC
			{
				position:fixed;
				background:#FFF;
				width:14px;
				height:14px;
				
				top:62px;
				left:180px;
			}
			
			#QIDworkArea
			{
				position:fixed;
				top:76px;
				left:194px;
				right:300px;
				bottom:30px;
				background:#FFF;
				
				overflow:auto;
			}
			
			#QIDhiddenWorkArea
			{
				position:fixed;
				top:76px;
				left:194px;
				right:300px;
				bottom:30px;
				background:rgba(0,0,0,0.2);
				
				overflow:auto;
				display:none;
				z-index:999999;
			}
			
			#QIDdrawingMode
			{
				float:left;
			}
			
			.QIDselectionBox
			{
				position:absolute;
				box-shadow:inset 0px 2px 0px rgba(55,121,241,0.5),inset 2px 0px 0px rgba(55,121,241,0.5),inset 0px -2px 0px rgba(55,121,241,0.5),inset -2px 0px 0px rgba(55,121,241,0.5);
			}
			
			.QIDivOuterX
			{
				position:absolute;
				box-shadow:inset 0px 2px 0px rgba(0,0,0,0.5),inset 2px 0px 0px rgba(0,0,0,0.5),inset 0px -2px 0px rgba(0,0,0,0.5),inset -2px 0px 0px rgba(0,0,0,0.5);
				background:#FFF;
				z-index:1;
			}
			
			/* 스타일은 포지션-마진-패딩-보더-백그라운드-너비-높이-좌표(상, 좌, 우, 하) 순서로 둘 것 */
			#QIDpropertyWindow
			{
				position:fixed;
				margin:0px
				padding:10px;
				border:1px solid #333;
				background-color:#FFE97F;
				width:200px;
				height:180px;
				display:none;
			}
			
			#webViewer
			{
				position:fixed;
				left:100px;
				right:100px;
				top:100px;
				bottom:100px;
				background:#FFF;
				border:5px solid #3478F1;
				border-top-width:32px;
				border-top-color:#3478F1;
				box-shadow:
				1px 1px 0px rgba(255,255,255,1),
				-1px -1px 0px rgba(255,255,255,1),
				1px -1px 0px rgba(255,255,255,1),
				-1px 1px 0px rgba(255,255,255,1),
				0px 0px 5px rgba(0,0,0,0.5);
				display:none;
				z-index:999999999;
			}
			
			#titleTitleArea
			{
				color:#FFF;
				position:absolute;
				top:-24px;
				left:6px;
			}
			
			#CLOSEBTN
			{
				position:absolute;
				right:5px;
				top:-24px;
				color:#FFF;
				wi
			}
			
			#webArea
			{
				position:absolute;
				top:0px;
				left:0px;
				right:0px;
				bottom:0px;
				overflow:auto;
			}
			
			#TARGETANCHOR
			{
				position:absoulte;
				top:50%;
				left:50%;
				width:200px;
				height:120px;
				margin-left:-100px;
				margin-top:-60px;
				box-shadow:2px 2px 0px #FFF, -2px -2px 0px #FFF, -2px 2px 0px #FFF, 2px -2px 0px #FFF, 0px 0px 5px rgba(0,0,0,0.5);
			}
			
			#QIDrightCSSbar
			{
				position:fixed;
				right:0px;
				bottom:30px;
				top:62px;
				width:300px;
				background:#EEE;
			}
		</style>
		
		<style>
			/* Content */
			.li-div:after {content:"Div";}
			.li-span:after {content:"Span";}
			.li-label:after {content:"Label";}
			.li-button:after {content:"Button";}
			.li-radio:after {content:"Radio";}
			.li-checkbox:after {content:"Checkbox";}
			.li-text:after {content:"Text";}
			.li-textarea:after {content:"Textarea";}
			.li-select:after {content:"Select";}
		</style>
	</head>
	<body>
		<div id="QIDtopToolBar">
			Current Document [ Untitled - mainpage ] :: Quasar interACtivE webDesigner
		</div>
		<div id="QIDtopMenuBar">
			<span class="contextMenuHeader">New</span>
			<span class="contextMenuHeader" id="WEBVIEWBTN">Web View</span>
			<span id="QIDdrawingMode"></span>
		</div>
		<div id="QIDrightCSSbar">
			<span class="listItemT" id="QIDSELATTRT">TOP : 0px</span>
			<span class="listItemT" id="QIDSELATTRL">LEFT : 0px</span>
			<span class="listItemT" id="QIDSELATTRW">WIDTH : 0px</span>
			<span class="listItemT" id="QIDSELATTRH">HEIGHT : 0px</span>
			<span class="listItemT" id="QIDSELATTRD">ID : </span>
		</div>
		<div id="QIDleftToolBox">
			<input type="hidden" id="tmpSELELEM" value="div">
			<span class="listItem li-div" data-elem="div"></span>
			<span class="listItem li-span" data-elem="span"></span>
			<span class="listItem li-label" data-elem="label"></span>
			
			<span class="listItem li-button" data-elem="form:button"></span>
			<span class="listItem li-radio" data-elem="form:radio"></span>
			<span class="listItem li-checkbox" data-elem="form:checkbox"></span>
			<span class="listItem li-text" data-elem="form:text"></span>
			<span class="listItem li-textarea" data-elem="textarea"></span>
			<span class="listItem li-select" data-elem="other:select"></span>
			
		</div>
		<div id="QIDrolerC"></div>
		<div id="QIDrolerX"></div>
		<div id="QIDrolerY"></div>
		<!--통상적으로 보이는 부분이다-->
		<div id="QIDworkArea">
		
		</div>
		<!--그릴 때 나타나는 부분이다-->
		<!--스크롤이 있는 경우 통상 영역의 스크롤 상태를 높이값에 더해야 함.-->
		<div id="QIDhiddenWorkArea">
		
		</div>
		<div id="QIDpropertyWindow">
			
		</div>
		<div id="webViewer">
			<div id="titleTitleArea">WEBVIEW</div>
			<div id="CLOSEBTN">X</div>
			<div id="webArea"></div>
		</div>
		<div id="TARGETANCHOR">
			라벨의 인풋 타겟을 입력해주세요.
			<div>
			
			</div>
		</div>
		<script>
		
		$(".listItem").click(function(e)
		{
			$("#tmpSELELEM").val($(this).attr("data-elem"));
			QIDACT.captionChange($(this).attr("data-elem"));				
		});
		
		$("#CLOSEBTN").click(function(){
			$("#webViewer").fadeOut(200);
		});
		$("#WEBVIEWBTN").click(function(){
			$("#webViewer").fadeIn(200);
			var strHTML = $("#QIDworkArea").html().toString();
			$("#webArea").html(strHTML);
			$("#webArea").find(".QIDivOuterX").attr("onclick","");
			// 이부분을 하위 엘리먼트를 잡아내는 식으로 삭제해야 됨
			$("#webArea").find(".QIDivOuterX").find(".ui-resizable-handle").remove();
			//$("#webArea").find(".QIDivOuterX").attr("class","");
			var classes = $("#webArea").find(".QIDivOuterX").attr("class");
			classes = classes.toString();
			//QIDivOuterX ui-resizable ui-draggable ui-draggable-handle
			while(classes.indexOf("ui-resizable") > -1)
			{
				classes = classes.replace("ui-resizable","");
			}
			
			while(classes.indexOf("ui-draggable-handle") > -1)
			{
				classes = classes.replace("ui-draggable-handle","");
			}
			
			while(classes.indexOf("ui-draggable") > -1)
			{
				classes = classes.replace("ui-draggable","");
			}
			
			while(classes.indexOf("QIDivOuterX") > -1)
			{
				classes = classes.replace("QIDivOuterX","");
			}
			
			$("#webArea").find(".QIDivOuterX").attr("class", classes.trim());
			
			strHTML = $("#webArea").html().toString();
			
			/* 꼼수이므로 언젠간 다른 방법을 찾아야 함 */
			while(strHTML.indexOf("<selection") > -1)
			{
				strHTML = strHTML.replace("<selection","<input");
				strHTML = strHTML.replace("</selection","</input");
			}
			while(strHTML.indexOf("<tmparea") > -1)
			{
				strHTML = strHTML.replace("<tmparea","<textarea");
				strHTML = strHTML.replace("</tmparea","</textarea");
			}
			while(strHTML.indexOf("<other:") > -1)
			{
				strHTML = strHTML.replace("<other:","<");
				strHTML = strHTML.replace("</other:","</");
			}
			$("#webArea").html(strHTML);
		});
			var tmpid = 0;
			var QIDACT = new qidactFunc();
			
			
			function qidactFunc()
			{
				this.captionChange = function(val)
				{
					if(this.toString($("#QIDdrawingMode").html()) != "")
					{
						$("#QIDdrawingMode").html("");
						$("#QIDhiddenWorkArea").fadeOut(200);
					}
					else
					{
						$("#QIDdrawingMode").html($('#tmpSELELEM').val().toUpperCase());
						$("#QIDhiddenWorkArea").fadeIn(200);
					}
				}
				
				this.toString = function(val)
				{
					return val.toString();
				}
			}
			
			var $container = $('#QIDhiddenWorkArea');
			var $workspace = $('#QIDworkArea');
		
			$container.on('mousedown', function(e) 
			{
				var elem = "div";
				
				var target = $('#tmpSELELEM').val().toString();
				
				if(target.indexOf('form') > -1)
				{
					elem = "selection";
				}
				else if(target.indexOf('textarea') > -1)
				{
					elem = "tmparea";
				}
				else if(target.indexOf('other') > -1)
				{
					elem = target;
				}
				else
				{
					elem = $('#tmpSELELEM').val();
				}
				
				var $selection = $('<'+ elem +'>').addClass('QIDselectionBox');
				
				if($('#tmpSELELEM').val().toString().indexOf('form') > -1)
				{
					$selection.attr("type", $('#tmpSELELEM').val().replace("form:",""));
				}
				
				var click_y = e.pageY;
				var click_x = e.pageX;

				$selection.css({
				  'top':    click_y - 76,
				  'left':   click_x - 194,
				  'width':  0,
				  'height': 0
				});
				$selection.appendTo($container);

				$container.on('mousemove', function(e) {
					var move_x = e.pageX,
						move_y = e.pageY,
						width  = Math.abs(move_x - click_x),
						height = Math.abs(move_y - click_y),
						new_x, new_y;

					new_x = (move_x < click_x) ? (click_x - width) : click_x;
					new_y = (move_y < click_y) ? (click_y - height) : click_y;

					$selection.css({
					  'width': width,
					  'height': height,
					  'top': new_y - 76,
					  'left': new_x - 194
					});
				}).on('mouseup', function(e) {
					$container.off('mousemove');
					$selection.remove();
					$selection.removeClass('QIDselectionBox');
					$selection.addClass('QIDivOuterX');
					
					tmpid++;
					
					$selection.attr("id", "tmpid_qiwd_"+tmpid);
					var act = "$('#QIDSELATTRL').html('LEFT : '+$(this).position().left+'px');";
					act += "$('#QIDSELATTRT').html('TOP : '+$(this).position().top+'px');";
					act += "$('#QIDSELATTRW').html('WIDTH : '+$(this).width()+'px');";
					act += "$('#QIDSELATTRH').html('HEIGHT : '+$(this).height()+'px');";
					act += "$('#QIDSELATTRD').html('ID : '+$(this).attr('id')); $(this).draggable().resizable();";
					
					act += "if($(this).position().left < 0){$('#QIDSELATTRL').css('color', '#F00');}else{$('#QIDSELATTRL').css('color','#000')}if($(this).position().top < 0){$('#QIDSELATTRT').css('color', '#F00');}else{$('#QIDSELATTRT').css('color','#000')}";
					
					if(elem == "label")
						act += "$('#TARGETANCHOR').fadeIn(200);";
					
					$selection.attr("onclick", act);
					
					$selection.css("position","absolute");
					
					$("#QIDdrawingMode").html("");
					$("#QIDhiddenWorkArea").fadeOut(200);
					$workspace.append($selection);
					$('.QIDivOuterX').resizable().draggable();
				});
			});
		</script>
	</body>
</html>
		