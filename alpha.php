<?PHP
header("Content-type:text/HTML; Charset=UTF-8");
if($_POST['filesave'])
{
	$header = '
<!DOCTYPE html>
<html>
	<head>
		<title>INTEractive webDesigner</title>
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="http://wli.kr/whtml/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://wli.kr/whtml/jquery-ui.css" >
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.7/styles/default.min.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.7/highlight.min.js"></script>

		<style>
		</style>
	</head>
	<body>
	{CONTENT}
	</body>
</html>';
/*
$dir = "./savefiles/";
$filename = $_POST['filename'];
$filedata= str_replace( "{CONTENT}", $_POST['file'], $header);
$log_file = fopen($dir.$filename.".html", "w"); 

fwrite($log_file, $filedata);  
fclose($log_file);
*/
?>
<script>location.href="./alpha.php"</script>
<?
exit();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>INTEractive webDesigner</title>
		<script src="http://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<script src="http://wli.kr/whtml/jquery-ui.js"></script>
		<script src="//cdn.jsdelivr.net/ace/1.2.0/min/ace.js" type="text/javascript" charset="utf-8">
		</script>
		<link rel="stylesheet" type="text/css" href="http://wli.kr/whtml/jquery-ui.css" >
		<link rel="stylesheet" type="text/css" href="http://wli.kr/qakedesigner/res/default.css" >
	</head>
	<body>
		<div id="QIDtopToolBar">
			Current Document [ Untitled - mainpage ]
		</div>
		<div id="QIDtopMenuBar">
			<span class="contextMenuHeader" id="WEBVIEWBTN">Web View</span>
			<span class="contextMenuHeader" id="SOURCEVIEW">SOURCE</span>
			<span class="contextMenuHeader" id="QIDSAVEAS">Save As</span>
			<span id="QIDdrawingMode"></span>
		</div>
		<div id="QIDrightCSSbar">
			<span class="listItemT">
				<span class="blockspan">Selected ID</span>
				<input id="QIDSELATTRD" class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).attr('id',$(this).val());"/>
			</span>
			<span class="listItemT dividerstyle">
				Position &amp; Size
			</span>
			<span class="listItemT">
				<span class="blockspan">TOP</span>
				<input  id="QIDSELATTRT" class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('top',$(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">LEFT</span>
				<input  id="QIDSELATTRL" class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('left',$(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">WIDTH</span>
				<input  id="QIDSELATTRW" class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('width',$(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">HEIGHT</span>
				<input  id="QIDSELATTRH" class="QIDinputstyle" type="text" value="0" onkeyup	="$('#'+$('#QIDSELATTRD').val()).css('height',$(this).val()+'px');"/>
			</span>
			<div id="valueinput" style="display:none;">
			<span class="listItemT dividerstyle">
				Value
			</span>
			<span class="listItemT">
				<span class="blockspan">value</span>
				<input  id="inputVALUE" class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).attr('value', $(this).val());"/>
			</span>
			</div>
			<span class="listItemT dividerstyle">
				Class
			</span>
			<span class="listItemT">
				<span class="blockspan">classes</span>
				<input  id="inputCLASSES" class="QIDinputstyle" type="text" value="" onkeyup="$('#'+$('#QIDSELATTRD').val()).attr('data-class', $(this).val());"/>
			</span>
			<span class="listItemT dividerstyle">
				Background
			</span>
			<span class="listItemT">
				<span class="blockspan">color</span>
				<input class="QIDinputstyle" type="text" value="" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('background-color', $(this).val());"/>
			</span>
			<span class="listItemT dividerstyle">
				margin
			</span>
			<span class="listItemT">
				<span class="blockspan">top</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('margin-top', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">left</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('margin-left', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">right</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('margin-right', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">bottom</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('margin-bottom', $(this).val()+'px');"/>
			</span>
			<span class="listItemT dividerstyle">
				padding
			</span>
			<span class="listItemT">
				<span class="blockspan">top</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('padding-top', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">left</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('padding-left', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">right</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('padding-right', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<span class="blockspan">bottom</span>
				<input class="QIDinputstyle" type="text" value="0" onkeyup="$('#'+$('#QIDSELATTRD').val()).css('padding-bottom', $(this).val()+'px');"/>
			</span>
			<span class="listItemT">
				<select id="qToolSel">
					<option value="default">사용하지 않음</option>
					<option value="combo">uQuasar Combobox</option>
					<option value="grid">uQuasar Grid</option>
					<option value="tree">uQuasar Tree</option>
				</select>
			</span>
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
		<div id="QIDworkArea" onClick="$('#QIDSELATTRD').val('');">
		</div>
		<div id="QIDhiddenWorkArea">
		</div>
		<div id="QIDpropertyWindow">
		</div>
		<div id="webViewer"><div id="webArea"></div></div>
		<div id="webViewer2">
			<div id="webArea2"></div>
			<div id="sourcearea" style="background:#FFF; z-index:1000000000; resize:none; border:none;" onkeyup="htmlSourceEdit()"></div>
			<script>
				var editor = ace.edit("sourcearea");
				editor.setTheme("lib/ace/theme/monokai");
				editor.getSession().setMode("lib/ace/mode/html");
			</script>
		</div>
		<div id="guide-h" class="guide"></div>
		<div id="guide-v" class="guide"></div>
		<div id="SAVEAS" style="display:none; z-index:999999999999999999999;">
			<form active="./alpha.php?filesave=true" method="POST">
				<input type="hidden" name="file" id="FILEVALUE" />
				<input type="hidden" name="filesave" id="FILEVALUE" value="true" />
				파일 이름 <input type="text" name="filename" />
				<input type="submit" value="저장" />
			</form>
		</div>
		<script src="./res/default.js"></script>
	</body>
</html>
		