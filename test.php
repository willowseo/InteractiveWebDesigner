<?PHP

?>
<!DOCUMENT html>
<html>
	<head>
		<title></title>
		<script src="http://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<script src="http://wli.kr/whtml/jquery-ui.js"></script>
		<script src="//cdn.jsdelivr.net/ace/1.2.0/min/ace.js" type="text/javascript" charset="utf-8">
		</script>
		<link rel="stylesheet" type="text/css" href="http://wli.kr/whtml/jquery-ui.css" >
		<style>
			@font-face 
			{
				font-family: mtcg;
				src: url(seoulhanriverL_M.ttf);
			}
			html, body{padding:0px; margin:0px;font-family:'mtcg';} .TlBtn, .SLBtn{border-radius:4px; box-shadow:0px 0px 3px rgba(0,0,0,0.5); margin:3px; float:left; height:18px; padding:3px; padding-left:10px; padding-right:10px; background:#FFF; min-width:40px; font-size:13px; text-align:center; line-height:18px; cursor:default;} .TlBtnSubmenu{float:left; border-radius:4px; padding:5px; width:100px; background:#FFF; box-shadow:0px 0px 3px rgba(0,0,0,0.5); line-height:20px; min-height:40px; display:none; margin-left:-10px; margin-top:3px;position:absolute;} .TlBtn:hover .TlBtnSubmenu{display:block; z-index:99999999999999;} .TlBtnSubmenuItem:hover{background:#5AF; color:#FFF} .SLBtn{float:right;} .TlBtn:hover, .SLBtn:hover{background:#5AF; color:#FFF;} .TlBtnSubmenuItem{height:22px; color:#000;} .PRESETINPUT{width:100px; border:none; background:#FFF; border-radius:4px;} .settingClassDiv{padding:3px; padding-left:10px;} .spTextC{width:50px; display:inline-block;text-align:right;}
		</style>
	</head>
	<body>
		<div id="headTitleBar" style="position:fixed; left:0px; top:0px; right:0px; height:30px; padding:5px; margin:0px; background:#EEE;">
			<span class="TlBtn" onMouseOver="$('#TdivMenu').css('display','block');" onMouseOut="$('#TdivMenu').css('display','none');">DIV
				<div id="TdivMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem">Normal Div</div>
					<div class="TlBtnSubmenuItem">uQgrid Div</div>
					<div class="TlBtnSubmenuItem">uQtree Div</div>
					<div class="TlBtnSubmenuItem">uQcombo Div</div>
				</div>
			</span>
			<span class="TlBtn">OBJECT
				<div id="TobjMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem">TAB OBJECT</div>
					<div class="TlBtnSubmenuItem">SPAN</div>
					<div class="TlBtnSubmenuItem">IMAGE</div>
				</div>
			</span>
			<span class="TlBtn" onMouseOver="$('#TinputMenu').css('display','block');" onMouseOut="$('#TinputMenu').css('display','none');">INPUT
				<div id="TinputMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem">TEXT</div>
					<div class="TlBtnSubmenuItem">LABEL</div>
					<div class="TlBtnSubmenuItem">BUTTON</div>
					<div class="TlBtnSubmenuItem">TEXTAREA</div>
					<div class="TlBtnSubmenuItem">CHECKBOX</div>
					<div class="TlBtnSubmenuItem">RADIOBUTTON</div>
					<div class="TlBtnSubmenuItem">COMBOBOX</div>
				</div>
			</span>
			<span style="float:left; line-height:20px; height:20px; display:inline-block; padding:5px;">
				Create Preset : 
				W <input type="text" id="PREWIDTH" class="PRESETINPUT"/>
				H <input type="text" id="PREHEIGHT" class="PRESETINPUT"/>
				T <input type="text" id="PRETOP" class="PRESETINPUT"/>
				L <input type="text" id="PRELEFT" class="PRESETINPUT"/>
			</span>
			<span class="SLBtn">LOAD</span>
			<span class="SLBtn">SAVE</span>
		</div>
		<div style="position:fixed; right:0px; top:40px; bottom:30px; background:#DDD; width:300px;">
			<div class="settingClassDiv">
				<span class="spTextC">Top</span>
				<input type="text" id="PRETOP" class="PRESETINPUT"/>
			</div>
			<div class="settingClassDiv">
				<Span class="spTextC">Left</span>
				<input type="text" id="PRELEFT" class="PRESETINPUT"/>
			</div>
			<div class="settingClassDiv">
				<Span class="spTextC">Width</span>
				<input type="text" id="PREWIDTH" class="PRESETINPUT"/>
			</div>
			<div class="settingClassDiv">
				<Span class="spTextC">HEIGHT</span>
				<input type="text" id="PREHEIGHT" class="PRESETINPUT"/>
			</div>
		</div>
		<div id="WORKAREA" style="position:fixed; right:300px; left:0px; top:40px; bottom:30px; background:#FFF;">
			
		</div>
		<script>
			$("#PREWIDTH").val("120");
			$("#PREHEIGHT").val("24");
			$("#PRETOP").val("12");
			$("#PRELEFT").val("12");
		</script>
	</body>
</html>