<?PHP
header("content-type:text/html; charset=utf-8");

$docDefault = '<!DOCUMENT html> <head> <title>Untitled Document</title> <script src="//code.jquery.com/jquery-1.11.3.min.js"> </script> <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"> </script> <script src="//wli.kr/whtml/jquery-ui.min.js"> </script> <link rel="stylesheet" type="text/css" href="//wli.kr/whtml/jquery-ui.css"> </head> <body>';
$docDefaultEnd = '</body> </html>';
$fileinter = $_POST["file"];
$ifoverwrite = $_POST['overw'];

$sdir = "./saveFiles/";
if(file_exists($sdir))
{
	
}
else
{
	mkdir($sdir);
}
	
if($_GET['mode'] == "saveFile")
{
	$filedata = $docDefault.html_entity_decode(str_replace("\\", "", $fileinter)).$docDefaultEnd;
	$filename = $_POST["filename"];
	
	$log_file = fopen($sdir.str_replace(".html","",$filename).".html", "w"); 

	fwrite($log_file, $filedata);  
	fclose($log_file);
	
	echo $filedata;
	
	exit();
}
else if($_GET['mode'] == "getFileList")
{
	$sdir = scandir($sdir);
	foreach($sdir as $key=>$val)
	{
		if($val == "." || $val == "..") continue;
		?>
<div class="flist" onclick="$('#FNAME').val('<?=$val?>'); $('#FNAME2').val('<?=$val?>');"><?=$val?></div>
		<?
	}
	exit();
}
else if($_GET['mode'] == "getFile")
{
	$fopen = fopen($sdir.$_GET['filename'],"rb");
	$cont = fread($fopen, filesize($sdir.$_GET['filename']));
	echo str_replace($docDefaultEnd, "", str_replace($docDefault, "", $cont));
	fclose($fopen);
	exit();
}
?>
<!DOCUMENT html>
<html>
	<head>
		<title></title>
		<script src="http://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<script src="http://wli.kr/whtml/jquery-ui.js"></script>
		<script src="res/jquery.ruler.js"></script>
		<script src="res/jq.mordenizer.js"></script>
		<script src="http://use.edgefonts.net/source-code-pro.js"></script>
		<script src="http://use.edgefonts.net/source-sans-pro.js"></script>
		<script src="jscolor.js"></script>
		<script src="//cdn.jsdelivr.net/ace/1.2.0/min/ace.js" type="text/javascript" charset="utf-8">
		</script>
		<link rel="stylesheet" type="text/css" href="http://wli.kr/whtml/jquery-ui.css" >
		<link rel="stylesheet" type="text/css" href="ruler/ruler.css" >
		<style>
			@font-face 
			{
				font-family: mtcg;
				src: url(seoulhanriverL_M.ttf);
			}
			
			label, span, img, textarea {margin:0px; padding:0px; display:block;}
			
			#workingPagePreset textarea {display:none;}
			#workingPagePreset select {display:none;}
			#workingPagePreset input {display:none;}
			#workingPagePreset img {display:none;}
			
			html, body{padding:0px; margin:0px;font-family:'mtcg';} .TlBtn, .SLBtn{border-radius:4px; box-shadow:0px 0px 3px rgba(0,0,0,0.5); margin:3px; float:left; height:18px; padding:3px; padding-left:10px; padding-right:10px; background:#FFF; min-width:40px; font-size:13px; text-align:center; line-height:18px; cursor:default;} .TlBtnSubmenu{z-index:99999999;float:left; border-radius:4px; padding:5px; width:100px; background:#FFF; box-shadow:0px 0px 3px rgba(0,0,0,0.5); line-height:20px; min-height:40px; display:none; margin-left:-10px; margin-top:3px;position:absolute;} .TlBtn:hover .TlBtnSubmenu{display:block; z-index:99999999;} .TlBtnSubmenuItem:hover{background:#5AF; color:#FFF} .SLBtn{float:right;} .TlBtn:hover, .SLBtn:hover{background:#5AF; color:#FFF;} .TlBtnSubmenuItem{height:22px; color:#000;} .PRESETINPUT{width:60px; border:none; background:#FFF; border-radius:4px;} .settingClassDiv{padding:3px; padding-left:10px; height:20px;} .spTextC{width:100px; display:inline-block;text-align:right;} .settingClassDiv .PRESETINPUT{width:130px; padding-left:10px; padding-right:10px;} .groupBox{border:1px solid #AAA; border-radius:5px; padding:5px; margin:5px; margin-top:12px;} .groupBoxTitle{position:absolute; float:left; margin-top:-16px; height:16px; padding-left:8px; padding-right:8px; background:#DDD; border-radius:5px;} .talignR{text-align:right;} .talignC{text-align:center;} .dividerLine{border-top:1px solid #AAA; margin-top:5px;} #workingPagePreset .objectOL{box-shadow:inset 1px 1px 0px #777,inset -1px -1px 0px #777, inset -1px 1px 0px #777, inset 1px -1px 0px #777; position:absolute;} .selectEOL{box-shadow:inset 2px 2px 0px #5AF,inset -2px -2px 0px #5AF, inset -2px 2px 0px #5AF, inset 2px -2px 0px #5AF;} #sourcearea{position:absolute;top:0px;left:0px;right:0px;bottom:0px;border:0px;width:100%;height:100%;overflow:auto;} .tabClass{height:25px; padding:5px; border:1px solid #CCC; position:absolute; top:4px; width:100px; text-align:center; line-height:25px; cursor:default; border-bottom:none;} .tabClass:hover{background:#5AF; color:#FFF;} .tabActive{background:#FFF;} .objectOL{position:absolute !important;}

			.SL{box-shadow:inset 1px 1px 0px #5AF,inset -1px -1px 0px #5AF, inset -1px 1px 0px #5AF, inset 1px -1px 0px #5AF; background:#FFF;}
			
			.SL_NE{width:8px; height:8px; position:absolute; top:-2px; left:-2px;}
			.SL_N{width:8px; height:8px; position:absolute; top:-2px; left:50%; margin-left:-4px;}
			.SL_NW{width:8px; height:8px; position:absolute; top:-2px; right:-2px;}
			
			.SL_E{width:8px; height:8px; position:absolute; top:50%; left:-2px; margin-top:-4px;}
			.SL_W{width:8px; height:8px; position:absolute; top:50%; right:-2px; margin-top:-4px;}
			
			.SL_SE{width:8px; height:8px; position:absolute; bottom:-2px; left:-2px;}
			.SL_S{width:8px; height:8px; position:absolute; bottom:-2px; left:50%; margin-left:-4px;}
			.SL_SW{width:8px; height:8px; position:absolute; bottom:-2px; right:-2px;}
			
			#workingPagePreset .s-label:before{content:"LABEL";}
			#workingPagePreset .s-div:before{content:"DIV";}
			#workingPagePreset .s-input-img:before{content:"IMAGE";}
			#workingPagePreset .s-input-text:before{content:"Input-Text";}
			#workingPagePreset .s-input-radio:before{content:"Input-Radio";}
			#workingPagePreset .s-input-checkbox:before{content:"Input-Checkbox";}
			#workingPagePreset .s-input-button:before{content:"Input-Button";}
			#workingPagePreset .s-span:before{content:"SPAN";}
			#workingPagePreset {top:18px; left:18px; position:absolute;}
			
			#quickEditor {width:100%; height:100%;}
			.hRule{position:absolute;}
			.corner{position:absolute;}
			
			.flist {padding:3px; cursor:default; padding-left:28px;}
			.flist:hover {box-shadow:inset 1px 1px 0px rgba(55,121,241,0.3), inset -1px -1px 0px rgba(55,121,241,0.3); background:rgba(55,121,241,0.1);}
		</style>
	</head>
	<body>
		<div id="QED2" style="position:fixed; width:1000px; left:50%; top:100px; bottom:100px; background:#FFF; z-index:99999999999999; margin-left:-500px; box-shadow:2px 2px 0px #5AF,-2px -2px 0px #5AF, -2px 2px 0px #5AF, 2px -2px 0px #5AF; display:none;">
			<div id="quickEditor" style="background:#FFF; resize:none; border:none;"></div>
			<script>
				var htmlQuickEditor = ace.edit("quickEditor");
				htmlQuickEditor.setTheme("lib/ace/theme/monokai");
				htmlQuickEditor.getSession().setMode("lib/ace/mode/html");
			</script>
			<div id="applyBTN" style="position:absolute; bottom:-30px; background:#EEE; height:30px; width:180px; right:0px;line-height:30px; text-align:center; cursor:default;" onclick="">
				적용
			</div>
		</div>
		<div id="WORKAREA" style="position:fixed; right:300px; left:0px; top:40px; bottom:30px; background:#FFF;">
			<div id="workingPagePreset">
			
			</div>
		</div>
		<div id="htmlSource" style="position:fixed; right:300px; left:0px; top:40px; bottom:30px; background:#FFF; display:none;">
			<div id="sourcearea" style="background:#FFF; z-index:1000000000; resize:none; border:none;" onkeyup="htmlSourceEdit()"></div>
			<script>
				var editor = ace.edit("sourcearea");
				editor.setTheme("lib/ace/theme/monokai");
				editor.getSession().setMode("lib/ace/mode/html");
			</script>
		</div>
		<div id="htmlPreview" style="position:fixed; right:300px; left:0px; top:40px; bottom:30px; background:#FFF; display:none; z-index:9999999999999;">
			<div id="previewPagePreset">
			
			</div>
		</div>
		<div id="saveAs" style="position:fixed; left:50%; top:50%; width:600px; height:340px; margin-top:-170px; margin-left:-300px; box-shadow:2px 2px 0px #000, -2px -2px 0px #000, -2px 2px 0px #000, 2px -2px 0px #000; z-index:1000000000; display:none;">
			<div style="height:30px; background:#EEE; line-height:30px; text-align:center;">
				Save Project
				<div style="float:right; width:30px; height:30px; display:inline-block; cursor:default; text-align:center;" onclick="$('#saveAs').css('display','none');">
					X
				</div>
			</div>
			<script>
				<?
					$fname = __FILE__;
					$fname = substr($fname, strrpos($fname, "\\")+1);
				?>
				$.get("./<?=$fname?>?mode=getFileList").done(function(e){
					$("#filelist").html(e);
				});
			</script>
			<div style="height:280px;">
			<div style="background:#FFF;float:left; height:280px; width:420px;" id="filelist">
			</div>
			<div style="width:180px; float:left; height:280px; background:#FFF;">
			</div>
			</div>
			<div style="height:20px; background:#EEE; line-height:20px; padding:5px;">
				<input id="FNAME2" type="text" class="PRESETINPUT" style="width:500px;"/>
				<button id="FFF" onclick="saveProc();">save</button>
			</div>
		</div>
		<div id="loadFile" style="position:fixed; left:50%; top:50%; width:600px; height:340px; margin-top:-170px; margin-left:-300px; box-shadow:2px 2px 0px #000, -2px -2px 0px #000, -2px 2px 0px #000, 2px -2px 0px #000; z-index:1000000000; display:none;">
			<div style="height:30px; background:#EEE; line-height:30px; text-align:center;">
				Load Project
				<div style="float:right; width:30px; height:30px; display:inline-block; cursor:default; text-align:center;" onclick="$('#loadFile').css('display','none');">
					X
				</div>
			</div>
			<script>
				<?
					$fname = __FILE__;
					$fname = substr($fname, strrpos($fname, "\\")+1);
				?>
				$.get("./<?=$fname?>?mode=getFileList").done(function(e)
				{
					$("#loadfilelist").html(e);
				});
			</script>
			<div style="height:280px;">
			<div style="background:#FFF;float:left; height:280px; width:420px;" id="loadfilelist">
			</div>
			<div style="width:180px; float:left; height:280px; background:#FFF;">
			</div>
			</div>
			<div style="height:20px; background:#EEE; line-height:20px; padding:5px;">
				<input id="FNAME" type="text" class="PRESETINPUT" style="width:500px;"/>
				<button onclick="loadProc();">load</button>
			</div>
		</div>
		<div id="headTitleBar" style="position:fixed; left:0px; top:0px; right:0px; height:30px; padding:5px; margin:0px; background:#EEE;">
			<span class="TlBtn" onMouseOver="$('#TdivMenu').css('display','block');" onMouseOut="$('#TdivMenu').css('display','none');">DIV
				<div id="TdivMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem" onclick="addedElement('div');">Normal Div</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('div','g');">uQgrid Div</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('div','t');">uQtree Div</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('div','c');">uQcombo Div</div>
				</div>
			</span>
			<span class="TlBtn" onMouseOver="$('#TobjMenu').css('display','block');" onMouseOut="$('#TobjMenu').css('display','none');">OBJECT
				<div id="TobjMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem" style="display:none;">TAB OBJECT</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('span');">SPAN</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('img','img');">IMAGE</div>
				</div>
			</span>
			<span class="TlBtn" onMouseOver="$('#TinputMenu').css('display','block');" onMouseOut="$('#TinputMenu').css('display','none');">INPUT
				<div id="TinputMenu" class="TlBtnSubmenu" onclick="$(this).css('display','none');">
					<div class="TlBtnSubmenuItem" onclick="addedElement('input','text');">INPUT(TEXT)</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('label');">LABEL</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('input','button');">BUTTON</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('textarea','textarea');">TEXTAREA</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('input','checkbox');">CHECKBOX</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('input','radio');">RADIOBUTTON</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('input','file');">FILE</div>
					<div class="TlBtnSubmenuItem" onclick="addedElement('select','select');">COMBOBOX</div>
				</div>
			</span>
			<span style="float:left; line-height:20px; height:20px; display:inline-block; padding:5px;">
				Create Preset : 
				W <input type="text" id="PREWIDTH" class="PRESETINPUT talignC"/>
				H <input type="text" id="PREHEIGHT" class="PRESETINPUT talignC"/>
				T <input type="text" id="PRETOP" class="PRESETINPUT talignC"/>
				L <input type="text" id="PRELEFT" class="PRESETINPUT talignC"/>
			</span>
			<span id="TB1" class="tabClass tabActive" style="right:531px; " onclick="tabChange('1');">
				Canvas
			</span>
			<span id="TB2" class="tabClass" style="right:416px;" onclick="tabChange('2');">
				HTML
			</span>
			<span id="TB3" class="tabClass" style="right:301px;" onclick="tabChange('3');">
				Preview
			</span>
			<span class="SLBtn" onclick="$('#loadFile').css('display','block');$('#saveAs').css('display','none');">LOAD</span>
			<span class="SLBtn" onclick="$('#saveAs').css('display','block');$('#loadFile').css('display','none');">SAVE</span>
		</div>
		<div style="position:fixed; right:0px; top:40px; height:20px; width:290px; background:#DDD; padding:5px;">
			<select id="ELEMS" class="PRESETINPUT" style="width:290px;" onChanged="">
				<option value="">Element 선택</option>
			</select>
		</div>
		<div style="position:fixed; right:0px; top:70px; bottom:30px; background:#DDD; width:300px; overflow:auto;">
			<div class="groupBox">
				<div class="groupBoxTitle">Position & Size</div>
				<div class="settingClassDiv">
					<span class="spTextC">Top</span>
					<input type="text" id="TGTOP" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('top',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left</span>
					<input type="text" id="TGLFET" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('left',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Width</span>
					<input type="text" id="TGWIDTH" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('width',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Height</span>
					<input type="text" id="TGHEIGHT" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('height',$(this).val().replace('px','')+'px');"/>
				</div>
			</div>
			<div class="groupBox">
				<div class="groupBoxTitle">Background</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Color</span>
					<input type="color" id="TGBGCOLOR" class="PRESETINPUT" onchange="$('#'+$('#ELEMS').val()).css('background-color',$(this).val());"/>
				</div>
			</div>
			<div class="groupBox">
				<div class="groupBoxTitle">Text</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Color</span>
					<input type="color" id="TGTXCOLOR" class="PRESETINPUT" onchange="$('#'+$('#ELEMS').val()).css('color',$(this).val());"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Size</span>
					<input type="text" id="TGTXSIZE" class="PRESETINPUT" onchange="$('#'+$('#ELEMS').val()).css('font-size',$(this).val().replace('px','') +'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Size</span>
					<input type="text" id="TGTXLHEIGHT" class="PRESETINPUT" onchange="$('#'+$('#ELEMS').val()).css('font-size',$(this).val().replace('px','') +'px');"/>
				</div>
			</div>
			<div class="groupBox">
				<div class="groupBoxTitle">Class</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Classes</span>
					<input type="text" id="TGMSELCLASS" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).attr('class',$(this).val());"/>
				</div>
			</div>					
			<div class="groupBox">
				<div class="groupBoxTitle">Margin</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Top</span>
					<input type="text" id="TGMTOP" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('margin-top',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left</span>
					<input type="text" id="TGMLEFT" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('margin-left',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Right</span>
					<input type="text" id="TGMRIGHT" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('margin-right',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Bottom</span>
					<input type="text" id="TGMBOTTOM" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('margin-bottom',$(this).val().replace('px','')+'px');"/>
				</div>
			</div>
			<div class="groupBox">
				<div class="groupBoxTitle">Padding</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Top</span>
					<input type="text" id="TGPTOP" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('padding-top',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left</span>
					<input type="text" id="TGPLEFT" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('padding-left',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Right</span>
					<input type="text" id="TGPRIGHT" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('padding-right',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Bottom</span>
					<input type="text" id="TGPBOTTOM" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('padding-bottom',$(this).val().replace('px','')+'px');"/>
				</div>
			</div>
			<div class="groupBox" style="display:none;">
				<div class="groupBoxTitle">Border</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Top-width</span>
					<input type="text" id="TGBDTW" class="PRESETINPUT talignR" onchange="$('#'+$('#ELEMS').val()).css('border-top-width',$(this).val().replace('px','')+'px');"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Top-color</span>
					<input type="text" id="TGBDTC" class="PRESETINPUT color {pickerMode:'HVS'}" onchange="cssChange('border-top-color',$(this).val());"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Top-style</span>
					<select id="TGBDTS" class="PRESETINPUT">
						<option value="solid">실선</option>
						<option value="dotted">짧은 점선</option>
						<option value="dashed">긴 점선</option>
						<option value="double">이중선</option>
					</select>
				</div>
				<div class="dividerLine"></div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left-width</span>
					<input type="text" id="TGBDLW" class="PRESETINPUT talignR" onchange="cssChange('border-left-width',$(this).val().replace('px','')+'px');" />
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left-color</span>
					<input type="text" id="TGBDLC" class="PRESETINPUT color {pickerMode:'HVS'}" onchange="cssChange('border-left-color',$(this).val());"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Left-style</span>
					<select id="TGBDLS" class="PRESETINPUT">
						<option value="solid">실선</option>
						<option value="dotted">짧은 점선</option>
						<option value="dashed">긴 점선</option>
						<option value="double">이중선</option>
					</select>
				</div>
				<div class="dividerLine"></div>
				<div class="settingClassDiv">
					<Span class="spTextC">Right-width</span>
					<input type="text" id="TGBDRW" class="PRESETINPUT talignR" onchange="cssChange('border-right-width',$(this).val()+'px');" />
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Right-color</span>
					<input type="text" id="TGBDRC" class="PRESETINPUT color {pickerMode:'HVS'}" onchange="cssChange('border-right-color',$(this).val());"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Right-style</span>
					<select id="TGBDRS" class="PRESETINPUT">
						<option value="solid">실선</option>
						<option value="dotted">짧은 점선</option>
						<option value="dashed">긴 점선</option>
						<option value="double">이중선</option>
					</select>
				</div>
				<div class="dividerLine"></div>
				<div class="settingClassDiv">
					<Span class="spTextC">Bottom-width</span>
					<input type="text" id="TGBDBW" class="PRESETINPUT talignR" onkeydown="cssChange('border-bottom-width',$(this).val()+'px');" />
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Bottom-color</span>
					<input type="text" id="TGBDBC" class="PRESETINPUT color {pickerMode:'HVS'}" onkeydown="cssChange('border-bottom-color',$(this).val());" onvaluechange="cssChange('border-bottom-color',$(this).val());"/>
				</div>
				<div class="settingClassDiv">
					<Span class="spTextC">Bottom-style</span>
					<select id="TGBDBS" class="PRESETINPUT">
						<option value="solid">실선</option>
						<option value="dotted">짧은 점선</option>
						<option value="dashed">긴 점선</option>
						<option value="double">이중선</option>
					</select>
				</div>
			</div>
		</div>
		<script>
			
			$("#PREWIDTH").val("120");
			$("#PREHEIGHT").val("24");
			$("#PRETOP").val("12");
			$("#PRELEFT").val("12");
			
			$("#TGTOP").val("");
			$("#TGLFET").val("");
			$("#TGWIDTH").val("");
			$("#TGHEIGHT").val("");
			
			$("#TGBGCOLOR").val("");
			
			$("#TGMTOP").val("");
			$("#TGMLEFT").val("");
			$("#TGMRIGHT").val("");
			$("#TGMBOTTOM").val("");
			
			$("#TGPTOP").val("");
			$("#TGPLEFT").val("");
			$("#TGPRIGHT").val("");
			$("#TGPBOTTOM").val("");
			
			$("#TGBDTW").val("");
			$("#TGBDTC").val("");
			$("#TGBDTS").val("");
			
			$("#TGBDLW").val("");
			$("#TGBDLC").val("");
			$("#TGBDLS").val("");
			
			$("#TGBDRW").val("");
			$("#TGBDRC").val("");
			$("#TGBDRS").val("");
			
			$("#TGTXSIZE").val("");
		
			$(function() {
				$('#WORKAREA').ruler({
					vRuleSize: 18,
					hRuleSize: 18,
					showCrosshair : false,
					showMousePos: true
				});    
			});
			
			var selectedElement = "";
			var tmpIDCOUNT = 0;
			var curTab = 1;
			var targetID = "";
			
			function loadProc()
			{
				$("#saveAs").css("display","none");
				
				$.get("./<?=$fname?>?mode=getFile&filename="+$("#FNAME").val()).done(function(e){
					$("#workingPagePreset").html(e);
					
					$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
					$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
					$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
					editor.setValue($("#workingPagePreset").html().trim().replaceAll("><",">\n<"));
					
					countElement();
				});
				
				$("#saveAs").css("display","none");
				$("#loadFile").css("display","none");
				
			}
			
			function saveProc()
			{
				$("#loadFile").css("display","none");
				
				$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
				$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
				$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
				editor.setValue($("#workingPagePreset").html().trim().replaceAll("><",">\n<"));
				
				$.post("./<?=$fname?>?mode=saveFile",
				{
					file:editor.getValue(),
					filename:$("#FNAME2").val()
				}).done(function(e){alert(e)});
				
				$.get("./<?=$fname?>?mode=getFileList").done(function(e){
					$("#filelist").html(e);
				});
				
					jqUIactive();
					
				$("#workingPagePreset").html(editor.getValue());
				
				$("#saveAs").css("display","none");
				$("#loadFile").css("display","none");
			}
			
			$("#applyBTN").click(function()
			{
				$('#QED').css('display','none'); 
				$('.objectOL').html(htmlQuickEditor.getValue());
				
				$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
				$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
				$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
				editor.setValue($("#workingPagePreset").html().trim().replaceAll("><",">\n<"));
				
				
				$("#workingPagePreset").html(editor.getValue());
					jqUIactive();
			});
			
			$("#WORKAREA").dblclick(function(event)
			{
				if(event.target.id == "") 
					targetID = $(event.target).parent().attr('id');
				else 
					targetID = event.target.id;
				
				$("#QED").css("display","block");
				$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
				$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
				
				$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
				editor.setValue($("#workingPagePreset").html().trim().replaceAll("><",">\n<"));
				htmlQuickEditor.setValue($("#"+targetID).html());
			});
			
			$(document).keydown(function( event ) 
			{
				if ( event.which == 46 && $('#ELEMS').val() != "") 
				{
					if(confirm("해당 객체를 정말 삭제하시겠습니까?\n\nID : "+$('#ELEMS').val()) == true)
					{
						$('#'+$('#ELEMS').val()).remove();
						countElement();
					}
				}
				else
				{
					switch(event.which)
					{
						case 37:
							$("#"+$('#ELEMS').val()).css("left", (parseInt($("#"+$('#ELEMS').val()).css("left").replace("px",""))-1)+"px");
						break;
						case 38:
							$("#"+$('#ELEMS').val()).css("top", (parseInt($("#"+$('#ELEMS').val()).css("top").replace("px",""))-1)+"px");
						break;
						case 39:
							$("#"+$('#ELEMS').val()).css("left", (parseInt($("#"+$('#ELEMS').val()).css("left").replace("px",""))+1)+"px");
						break;
						case 40:
							$("#"+$('#ELEMS').val()).css("top", (parseInt($("#"+$('#ELEMS').val()).css("top").replace("px",""))+1)+"px");
						break;
					}
					
					if(event.which == 37 || event.which == 38 || event.which == 39 || event.which ==40)
					{
						var DT = $('#ELEMS').val();
						$("#TGMSELCLASS").val($("#"+DT).attr('class'));
						
						$("#TGTOP").val($("#"+DT).css('top'));
						$("#TGLFET").val($("#"+DT).css('left'));
						$("#TGWIDTH").val($("#"+DT).css('width'));
						$("#TGHEIGHT").val($("#"+DT).css('height'));
						$("#TGBGCOLOR").val($("#"+DT).css('background-color'));
						
						$("#TGMTOP").val($("#"+DT).css('margin-top'));
						$("#TGMLEFT").val($("#"+DT).css('margin-left'));
						$("#TGMRIGHT").val($("#"+DT).css('margin-right'));
						$("#TGMBOTTOM").val($("#"+DT).css('margin-bottom'));
						
						$("#TGPTOP").val($("#"+DT).css('padding-top'));
						$("#TGPLEFT").val($("#"+DT).css('padding-left'));
						$("#TGPRIGHT").val($("#"+DT).css('padding-right'));
						$("#TGPBOTTOM").val($("#"+DT).css('padding-bottom'));
						
						$("#TGTXSIZE").val($("#"+DT).css('font-size'));
					}
				}
			});
			
			$("#WORKAREA").on("mousedown",function(e)
			{
				var DT = e.target.id;
				
				if(DT == "WORKAREA")
				{
					$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
					$("*").removeClass("selectEOL");
					$("#ELEMS").val("").attr("selected", "selected");
					
					$("#TGTOP").val("");
					$("#TGLFET").val("");
					$("#TGWIDTH").val("");
					$("#TGHEIGHT").val("");
					
					$("#TGBGCOLOR").val("");
					
					$("#TGMTOP").val("");
					$("#TGMLEFT").val("");
					$("#TGMRIGHT").val("");
					$("#TGMBOTTOM").val("");
					
					$("#TGPTOP").val("");
					$("#TGPLEFT").val("");
					$("#TGPRIGHT").val("");
					$("#TGPBOTTOM").val("");
					
					$("#TGBDTW").val("");
					$("#TGBDTC").val("");
					$("#TGBDTS").val("");
					
					$("#TGBDLW").val("");
					$("#TGBDLC").val("");
					$("#TGBDLS").val("");
					
					$("#TGBDRW").val("");
					$("#TGBDRC").val("");
					$("#TGBDRS").val("");
					
					$("#TGTXSIZE").val("");
				}
				else if(DT != undefined)
				{
					//REMOVE PROC
					$("*").removeClass("selectEOL");
					$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
					
					//ADD PROC
					$("#"+DT).addClass("selectEOL");
					
					$("#"+DT).append($('<div>').addClass('SL SL_NE'));
					$("#"+DT).append($('<div>').addClass('SL SL_N'));
					$("#"+DT).append($('<div>').addClass('SL SL_NW'));
					$("#"+DT).append($('<div>').addClass('SL SL_E'));
					$("#"+DT).append($('<div>').addClass('SL SL_W'));
					$("#"+DT).append($('<div>').addClass('SL SL_SE'));
					$("#"+DT).append($('<div>').addClass('SL SL_S'));
					$("#"+DT).append($('<div>').addClass('SL SL_SW'));
					
					$("#ELEMS").val(DT).attr("selected", "selected");
					
					//
					$("#TGMSELCLASS").val($("#"+DT).attr('class'));
					
					$("#TGTOP").val($("#"+DT).css('top'));
					$("#TGLFET").val($("#"+DT).css('left'));
					$("#TGWIDTH").val($("#"+DT).css('width'));
					$("#TGHEIGHT").val($("#"+DT).css('height'));
					$("#TGBGCOLOR").val($("#"+DT).css('background-color'));
					
					$("#TGMTOP").val($("#"+DT).css('margin-top'));
					$("#TGMLEFT").val($("#"+DT).css('margin-left'));
					$("#TGMRIGHT").val($("#"+DT).css('margin-right'));
					$("#TGMBOTTOM").val($("#"+DT).css('margin-bottom'));
					
					$("#TGPTOP").val($("#"+DT).css('padding-top'));
					$("#TGPLEFT").val($("#"+DT).css('padding-left'));
					$("#TGPRIGHT").val($("#"+DT).css('padding-right'));
					$("#TGPBOTTOM").val($("#"+DT).css('padding-bottom'));
					
					$("#TGTXSIZE").val($("#"+DT).css('font-size'));
				}
			});
			
			$(".WORKAREA").on("mousedown",function(e)
			{
				alert(e.target.id);
			});
			
			function countElement()
			{
				var chd = $("#workingPagePreset").find("*");
				var sel = $("#ELEMS").val();
				$("#ELEMS").html('<option value="">Element 선택</option>');
				chd.each(function(){
					if($(this).attr("id") != undefined)
					{
						var elem = $('<option>');
						elem.attr("value",$(this).attr("id"));
						elem.attr("onclick","selectElement($('#'+$(this).val()));");
						elem.html($(this).attr("id"));
						$("#ELEMS").append(elem);
					}
					
					if(sel == $(this).attr("id")) $("#ELEMS").val($(this).attr("id")).attr("selected", "selected");
				});
			}
			
			function jqUIactive()
			{
				$(".objectOL").resizable
				({
					autoHide:true,
					handles:"all"
				}).draggable
				({
					
				});
			}
			
			function tabChange(tab)
			{
				var tab1=$("#WORKAREA"),tab2=$("#htmlSource"),tab3=$("#htmlPreview"),tabin1=$("#workingPagePreset"),tabin3=$("#previewPagePreset");
				$("*").find(".tabActive").each(function(){$(this).removeClass("tabActive");});
				
				if(tab=="1")
				{
					if(curTab == 2)
					{
						$("#workingPagePreset").html(editor.getValue());
					}
					 
					jqUIactive();
					
					curTab = 1;
					$("#TB1").addClass("tabActive");
					tab2.css("display","block");
					tab2.css("display","none");
					tab3.css("display","none");
				}
				else if(tab=="2")
				{
					curTab = 2;
					$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
					$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
					$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
					editor.setValue($("#workingPagePreset").html().trim().replaceAll("><",">\n<"));
					
					$("#TB2").addClass("tabActive");
					tab2.css("display","none");
					tab2.css("display","block");
					tab3.css("display","none");
				}
				else
				{
					$("#workingPagePreset").find(".SL").each(function(){$(this).remove();});
					$(".objectOL").find(".ui-resizable-handle").each(function(){$(this).remove();});
					$(".objectOL").removeClass("ui-resizable ui-resizable-autohide ui-draggable ui-draggable-handle selectEOL");
					
					$("#previewPagePreset").html($("#workingPagePreset").html());
					curTab = 3;
					$("#TB3").addClass("tabActive");
					tab2.css("display","none");
					tab2.css("display","none");
					tab3.css("display","block");
				}
			}
			
			String.prototype.replaceAll = function(orig, target)
			{
				var rtn = this;
				while(rtn.indexOf(orig) > -1)
				{
					rtn = rtn.replace(orig, target);
				}
				return rtn;
			}
			
			function cssChange(css, val)
			{
				$('#'+$('#ELEMS').val()).css(css,val);
			}
			
			function addedElement(element,type)
			{
				var elm = element;
				if(elm == "input" || elm == "textarea" || elm == "select" || elm == "img") 
				{
					element = "div";
				}
				
				var elem = $('<'+ element +'>').addClass('objectOL');
				elem.css
				({
					"top":$("#PRETOP").val()+"px", 
					"left":$("#PRELEFT").val()+"px", 
					"width":$("#PREWIDTH").val()+"px",
					"height":$("#PREHEIGHT").val()+"px"
				});
				
				elem.attr("data-indisable","false");
				elem.attr("id","tmpID_"+tmpIDCOUNT);
				elem.attr("ondblcick","$('#QED').css('display','block');");
				
				if(elm == "input" || elm == "textarea" || elm == "select" || elm == "img")
				{
					var inputv = $('<'+elm+'>').css({"width":"100%", "height":"100%"});
					inputv.attr("type",type);
					
					elem.addClass('s-input-'+type);
					elem.attr("data-indisable","true");
					elem.append(inputv);
				}
				else if(elm == "div")
				{
					elem.attr("div-type",type);
					if(type != null)
					{
						elem.addClass('s-div-'+type);
						elem.attr("data-indisable","true");
					}
					else
					{
						elem.addClass('s-div');
					}
				}
				else
				{
					elem.addClass('s-'+elm);
				}
				
				tmpIDCOUNT++;
				
				elem.resizable
				({
					handles:"all"
				}).draggable
				({
					
				});
				
				if($("#ELEMS").val() == "")
				{
					$("#workingPagePreset").append(elem);
				}
				else if($("#"+$("#ELEMS").val()).attr("data-indisable") != "true")
				{
					$("#"+$("#ELEMS").val()).append(elem);
				}
				else
				{
					$("#workingPagePreset").append(elem);
				}
				
				elem=null;
				countElement();
			}
		</script>
	</body>
</html>