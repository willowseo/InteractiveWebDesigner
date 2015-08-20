/* variable */

var MIN_DISTANCE = 3; // minimum distance to "snap" to a guide
var guides = []; // no guides available ... 
var innerOffsetX, innerOffsetY; // we'll use those during drag ... 
var selectedELEMENT = "QIDworkArea";

/* prototype */
String.prototype.replaceAll = function(originalString, replacedString)
{
	var rtn = this;
	while(rtn.indexOf(originalString) > -1)
	{
		rtn = rtn.replace(originalString, replacedString);
	}
	return rtn;
}

/* htmlSourceEdit */
function htmlSourceEdit()
{
	$('#QIDworkArea').html($('#sourcearea').val());

	$('.QIDivOuterX').resizable().draggable(
	{
		start: function( event, ui ) 
		{
			guides = $.map( $( ".QIDivOuterX" ).not( this ), computeGuidesForElement );
			innerOffsetX = event.originalEvent.offsetX;
			innerOffsetY = event.originalEvent.offsetY;
		}, 
		drag: function( event, ui )
		{
			// iterate all guides, remember the closest h and v guides
			var guideV, 
			guideH, 
			distV = MIN_DISTANCE+1, 
			distH = MIN_DISTANCE+1, 
			offsetV, 
			offsetH;
			
			var chosenGuides = 
			{ 
				top: { dist: MIN_DISTANCE+1 }, 
				left: { dist: MIN_DISTANCE+1 } 
			}; 
			var $t = $(this); 
			var pos = 
			{
				top: event.originalEvent.pageY - innerOffsetY, 
				left: event.originalEvent.pageX - innerOffsetX
			}; 
			var w = $t.outerWidth() - 1; 
			var h = $t.outerHeight() - 1; 
			var elemGuides = computeGuidesForElement( null, pos, w, h ); 
			$.each( guides, function( i, guide )
			{
				$.each( elemGuides, function( i, elemGuide )
				{
					if( guide.type == elemGuide.type )
					{
						var prop = guide.type == "h"? "top":"left"; 
						var d = Math.abs( elemGuide[prop] - guide[prop] ); 
						if( d < chosenGuides[prop].dist )
						{
							chosenGuides[prop].dist = d; 
							chosenGuides[prop].offset = elemGuide[prop] - pos[prop]; 
							chosenGuides[prop].guide = guide; 
						}
					}
				}); 
			});

			if( chosenGuides.top.dist <= MIN_DISTANCE )
			{
				$( "#guide-h" ).css( "top", chosenGuides.top.guide.top ).show(); 
				ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset - 76;
			}
			else
			{
				$( "#guide-h" ).hide(); 
				ui.position.top = pos.top - 76; 
			}

			if( chosenGuides.left.dist <= MIN_DISTANCE )
			{
				$( "#guide-v" ).css( "left", chosenGuides.left.guide.left ).show(); 
				ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset - 194; 
			}
			else
			{
				$( "#guide-v" ).hide(); 
				ui.position.left = pos.left - 194; 
			}
		}, 
		stop: function( event, ui )
		{
			$( "#guide-v, #guide-h" ).hide(); 
		}
	});
}

$(document).keydown(function( event ) 
{
	if ( event.which == 46 ) 
	{
		if(confirm("해당 객체를 정말 삭제하시겠습니까?\n\nID : "+$('#QIDSELATTRD').html()) == true)
		{
			$('#'+$('#QIDSELATTRD').html()).remove();
		}
	}
});

function computeGuidesForElement( elem, pos, w, h )
{
	if( elem != null )
	{
		var $t = $(elem); 
		pos = $t.offset(); 
		w = $t.outerWidth() - 1; 
		h = $t.outerHeight() - 1; 
	}

	return [
		{ type: "h", left: pos.left, top: pos.top }, 
		{ type: "h", left: pos.left, top: pos.top + h }, 
		{ type: "v", left: pos.left, top: pos.top }, 
		{ type: "v", left: pos.left + w, top: pos.top },
		// you can add _any_ other guides here as well (e.g. a guide 10 pixels to the left of an element)
		{ type: "h", left: pos.left, top: pos.top + h/2 },
		{ type: "v", left: pos.left + w/2, top: pos.top } 
	]; 
}

function clickEvent(tmp)
{
	selectedELEMENT = tmp.attr("id").toString();
	$('#QIDSELATTRL').val(tmp.position().left);
	$('#QIDSELATTRT').val(tmp.position().top);
	$('#QIDSELATTRW').val(tmp.width());
	$('#QIDSELATTRH').val(tmp.height());
	$('#QIDSELATTRD').html(tmp.attr('id')); $(this).draggable().resizable();
	if(tmp.position().left < 0)
	{
		$('#QIDSELATTRL').css('color', '#F00');
	}
	else
	{
		$('#QIDSELATTRL').css('color','#000');
	}

	if(tmp.position().top < 0)
	{
		$('#QIDSELATTRT').css('color', '#F00');
	}
	else
	{
		$('#QIDSELATTRT').css('color','#000');
	}
	$("#inputVALUE").val(tmp.attr("value"));
	$("#inputHTML").val(tmp.attr("data-html"));
}

$(".listItem").click(function(e)
{
	$("#tmpSELELEM").val($(this).attr("data-elem"));
	QIDACT.captionChange($(this).attr("data-elem"));				
	});

	$("#CLOSEBTN").click(function(){
	$("#webViewer").fadeOut(200);
	});

	$("#WEBVIEWBTN").click(function()
	{
	$("#webViewer").fadeToggle(200);

	$("#webArea").html($("#QIDworkArea").html().toString());

	var tmpHTML = $("#webArea").html();

	$("#webArea").html(tmpHTML.replaceAll("<selection","<input"));
	$("#webArea").html(tmpHTML.replaceAll("</selection","</input"));

	$("#webArea").html(tmpHTML.replaceAll("<tmparea","<textarea"));
	$("#webArea").html(tmpHTML.replaceAll("</tmparea","</textarea"));

	$("#webArea").html(tmpHTML.replaceAll("<other:","<"));
	$("#webArea").html(tmpHTML.replaceAll("</other:","</"));

	$("#webArea").html($("#QIDworkArea").html().toString());
	$("#webArea").find(".QIDivOuterX").each(function()
	{
	$(this).find(".ui-resizable-e").remove();
	$(this).find(".ui-resizable-s").remove();
	$(this).find(".ui-resizable-se").remove();

	$(this).removeClass("li-div");
	$(this).removeClass("li-span");
	$(this).removeClass("li-button");
	$(this).removeClass("li-radio");
	$(this).removeClass("li-checkbox");
	$(this).removeClass("li-text");
	$(this).removeClass("li-textarea");
	$(this).removeClass("li-select");
	$(this).removeClass("li-label");

	$(this).removeClass("ui-resizable");
	$(this).removeClass("ui-draggable");
	$(this).removeClass("ui-draggable-handle");

	$(this).attr("onclick","");
	});
});

$("#QIDSAVEAS").click(function()
{
var tmpHTML = $("#QIDworkArea").html().toString()

tmpHTML = tmpHTML.replaceAll("<selection","<input");
tmpHTML = tmpHTML.replaceAll("</selection","</input");

tmpHTML = tmpHTML.replaceAll("<tmparea","<textarea");
tmpHTML = tmpHTML.replaceAll("</tmparea","</textarea");

tmpHTML = tmpHTML.replaceAll("<other:","<");
tmpHTML = tmpHTML.replaceAll("</other:","</");

$("#webArea2").html(tmpHTML);

$("#webArea2").find(".QIDivOuterX").each(function()
{
$(this).find(".ui-resizable-e").remove();
$(this).find(".ui-resizable-s").remove();
$(this).find(".ui-resizable-se").remove();

$(this).removeClass("li-div");
$(this).removeClass("li-span");
$(this).removeClass("li-button");
$(this).removeClass("li-radio");
$(this).removeClass("li-checkbox");
$(this).removeClass("li-text");
$(this).removeClass("li-textarea");
$(this).removeClass("li-select");
$(this).removeClass("li-label");

$(this).removeClass("ui-resizable");
$(this).removeClass("ui-draggable");
$(this).removeClass("ui-draggable-handle");

$(this).attr("onclick","");
});

$("#FILEVALUE").val($("#webArea2").html().trim());
$("#SAVEAS").fadeIn(200);
});

$("#SOURCEVIEW").click(function()
{
$("#webViewer2").fadeToggle(200);

var tmpHTML = $("#QIDworkArea").html().toString()

tmpHTML = tmpHTML.replaceAll("<selection","<input");
tmpHTML = tmpHTML.replaceAll("</selection","</input");

tmpHTML = tmpHTML.replaceAll("<tmparea","<textarea");
tmpHTML = tmpHTML.replaceAll("</tmparea","</textarea");

tmpHTML = tmpHTML.replaceAll("<other:","<");
tmpHTML = tmpHTML.replaceAll("</other:","</");

$("#webArea2").html(tmpHTML);

$("#webArea2").html($("#QIDworkArea").html().toString());
$("#webArea2").find(".QIDivOuterX").each(function()
{
$(this).find(".ui-resizable-e").remove();
$(this).find(".ui-resizable-s").remove();
$(this).find(".ui-resizable-se").remove();

$(this).removeClass("li-div");
$(this).removeClass("li-span");
$(this).removeClass("li-button");
$(this).removeClass("li-radio");
$(this).removeClass("li-checkbox");
$(this).removeClass("li-text");
$(this).removeClass("li-textarea");
$(this).removeClass("li-select");
$(this).removeClass("li-label");

$(this).removeClass("ui-resizable");
$(this).removeClass("ui-draggable");
$(this).removeClass("ui-draggable-handle");

$(this).attr("onclick","");
});

$("#sourcearea").val($("#webArea2").html().trim());
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

$selection.addClass("li-"+elem.replace(':','-').replace(':','-'));
var click_y = e.pageY;
var click_x = e.pageX;

$selection.css({
'top':    click_y - 76,
'left':   click_x - 94,
'width':  0,
'height': 0
});
$selection.appendTo($container);

$container.on('mousemove', function(e)
{
	var move_x = e.pageX,
	move_y = e.pageY,
	width  = Math.abs(move_x - click_x),
	height = Math.abs(move_y - click_y),
	new_x, new_y;

	new_x = (move_x < click_x) ? (click_x - width) : click_x;
	new_y = (move_y < click_y) ? (click_y - height) : click_y;

	$selection.css
	({
	'width': width,
	'height': height,
	'top': new_y - 76,
	'left': new_x - 94
	});
	}).on('mouseup', function(e) 
	{
		$container.off('mousemove');
		$selection.remove();
		$selection.removeClass('QIDselectionBox');
		$selection.addClass('QIDivOuterX');


		tmpid++;

		$selection.attr("id", "tmpid_qiwd_"+tmpid);
		var act = "clickEvent($(this));";

		if(elem == "label")
		act += "$('#TARGETANCHOR').fadeIn(200);";

		$selection.attr("onclick", act);
		$selection.attr("data-html", " ");

		$selection.css("position","absolute");

		$("#QIDdrawingMode").html("");
		$("#QIDhiddenWorkArea").fadeOut(200);
		$workspace.append($selection);
		$('.QIDivOuterX').resizable().draggable(

		{
		start: function( event, ui ) {
		guides = $.map( $( ".QIDivOuterX" ).not( this ), computeGuidesForElement );
		innerOffsetX = event.originalEvent.offsetX;
		innerOffsetY = event.originalEvent.offsetY;
		}, 
		drag: function( event, ui ){
		// iterate all guides, remember the closest h and v guides
		var guideV, guideH, distV = MIN_DISTANCE+1, distH = MIN_DISTANCE+1, offsetV, offsetH; 
		var chosenGuides = { top: { dist: MIN_DISTANCE+1 }, left: { dist: MIN_DISTANCE+1 } }; 
		var $t = $(this); 
		var pos = { top: event.originalEvent.pageY - innerOffsetY, left: event.originalEvent.pageX - innerOffsetX }; 
		var w = $t.outerWidth() - 1; 
		var h = $t.outerHeight() - 1; 
		var elemGuides = computeGuidesForElement( null, pos, w, h ); 
		$.each( guides, function( i, guide ){
		$.each( elemGuides, function( i, elemGuide ){
		if( guide.type == elemGuide.type ){
		var prop = guide.type == "h"? "top":"left"; 
		var d = Math.abs( elemGuide[prop] - guide[prop] ); 
		if( d < chosenGuides[prop].dist ){
		chosenGuides[prop].dist = d; 
		chosenGuides[prop].offset = elemGuide[prop] - pos[prop]; 
		chosenGuides[prop].guide = guide; 
		}
		}
		}); 
		});

		if( chosenGuides.top.dist <= MIN_DISTANCE )
		{
		$( "#guide-h" ).css( "top", chosenGuides.top.guide.top ).show(); 
		ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset - 76;
		}
		else
		{
		$( "#guide-h" ).hide(); 
		ui.position.top = pos.top - 76; 
		}

		if( chosenGuides.left.dist <= MIN_DISTANCE )
		{
		$( "#guide-v" ).css( "left", chosenGuides.left.guide.left ).show(); 
		ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset - 94; 
		}
		else{
		$( "#guide-v" ).hide(); 
		ui.position.left = pos.left - 94; 
		}
		}, 
		stop: function( event, ui ){
		$( "#guide-v, #guide-h" ).hide(); 
		}
		});
	});
});