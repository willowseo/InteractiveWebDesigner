/*variable*/
var tmpid = 0;
var QIDACT = new qidactFunc();
var selectedELEMENT = "QIDworkArea";
var $container = $('#QIDhiddenWorkArea');
var $workspace = $('#QIDworkArea');

var MIN_DISTANCE = 3; // minimum distance to "snap" to a guide
var guides = []; // no guides available ... 
var innerOffsetX, innerOffsetY; // we'll use those during drag ... 

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
function htmlSourceEdit(val)
{
	$(".QIDivOuterX").resizable().draggable
	({
		start: function( event, ui ) 
		{
			guides = $.map( $( ".QIDivOuterX" ).not( this ), computeGuidesForElement );
			innerOffsetX = event.originalEvent.offsetX;
			innerOffsetY = event.originalEvent.offsetY;
		}, 
		drag: function( event, ui )
		{
			var wh = 0, hi = 0;
			if($(this).parent().attr("id") == "QIDworkArea")
			{
				wh = 94;
				hi = 76;
			}
			else
			{
				var tmp = $(this).parent();
				wh = 94;
				hi = 76;
				
				while(tmp.attr("id") != "QIDworkArea")
				{
					wh += tmp.position().left;
					hi += tmp.position().top;
					tmp = tmp.parent();
				}
			}
			var 
			guideV, 
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
				ui.position.top = chosenGuides.top.guide.top - chosenGuides.top.offset - hi;
			}
			else
			{
				$( "#guide-h" ).hide(); 
				ui.position.top = pos.top - hi; 
			}

			if( chosenGuides.left.dist <= MIN_DISTANCE )
			{
				$( "#guide-v" ).css( "left", chosenGuides.left.guide.left ).show(); 
				ui.position.left = chosenGuides.left.guide.left - chosenGuides.left.offset - wh; 
			}
			else
			{
				$( "#guide-v" ).hide(); 
				ui.position.left = pos.left - wh; 
			}
		}, 
		stop: function( event, ui )
		{
			$( "#guide-v, #guide-h" ).hide(); 
		}
	});
}

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

$(document).keydown(function( event ) 
{
	if ( event.which == 46 ) 
	{
		if(confirm("해당 객체를 정말 삭제하시겠습니까?\n\nID : "+$('#QIDSELATTRD').val()) == true)
		{
			$('#'+$('#QIDSELATTRD').val()).remove();
		}
	}
});

function clickEvent(tmp)
{
	selectedELEMENT = tmp.attr("id").toString();
	$('#QIDSELATTRL').val(tmp.position().left);
	$('#QIDSELATTRT').val(tmp.position().top);
	$('#QIDSELATTRW').val(tmp.width());
	$('#QIDSELATTRH').val(tmp.height());
	$('#QIDSELATTRD').val(tmp.attr('id')); 
	$(this).draggable().resizable();
	
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

$("#CLOSEBTN").click(function()
{
	$("#webViewer").fadeOut(200);
});

function removeElementClass(elem)
{
	elem.find(".ui-resizable-e").remove();
	elem.find(".ui-resizable-s").remove();
	elem.find(".ui-resizable-se").remove();

	elem.removeClass("ui-resizable");
	elem.removeClass("ui-draggable");
	elem.removeClass("ui-draggable-handle");

	// elem.attr("onclick","");
}

function htmlTextVariable()
{
	var tmpHTML = $("#QIDworkArea").html().toString();

	tmpHTML = tmpHTML.replaceAll("<selection","<input");
	tmpHTML = tmpHTML.replaceAll("</selection","</input");

	tmpHTML = tmpHTML.replaceAll("<tmparea","<textarea");
	tmpHTML = tmpHTML.replaceAll("</tmparea","</textarea");

	tmpHTML = tmpHTML.replaceAll("<other:","<");
	tmpHTML = tmpHTML.replaceAll("</other:","</");

	return tmpHTML;
}

$("#WEBVIEWBTN").click(function()
{
	$("#webViewer").fadeToggle(200);

	var tmpHTML = htmlTextVariable();
	tmpHTML = tmpHTML.replaceAll("li-","");

	$("#webArea").html(tmpHTML);

	$("#webArea").find(".QIDivOuterX").each(function()
	{
	removeElementClass($(this));
	});
});

$("#QIDSAVEAS").click(function()
{
	var tmpHTML = htmlTextVariable();

	$("#webArea2").html(tmpHTML);

	$("#webArea2").find(".QIDivOuterX").each(function()
	{
		removeElementClass($(this));
	});

	$("#FILEVALUE").val($("#webArea2").html().trim());
	$("#SAVEAS").fadeToggle(200);
});

$("#SOURCEVIEW").click(function()
{
	if($("#webViewer2").css("display") == "block")
		htmlSourceEdit(true);
	$("#webViewer2").fadeToggle(200);
	var tmpHTML = htmlTextVariable();

	$("#webArea2").html(tmpHTML);

	$("#webArea2").html($("#QIDworkArea").html().toString());
	$("#webArea2").find(".QIDivOuterX").each(function()
	{
		removeElementClass($(this));
	});
	
	editor.setValue($("#webArea2").html().trim());
	editor.find("><");
	editor.replaceAll(">\r\n<");
});


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

$container.on('mousedown', function(e) 
{
	var elem = "div";
	var target = $('#tmpSELELEM').val().toString();
	var $selection = $('<'+ elem +'>').addClass('QIDselectionBox');
	var click_y = e.pageY;
	var click_x = e.pageX;
	
	var origelem = elem;
	
	var $addedCont = $workspace;
	var wh = 0, hi = 0;

	if(target.indexOf('form') > -1)
	{
		elem = "input_QID";
	}
	else if(target.indexOf('textarea') > -1)
	{
		elem = "textarea_QID";
	}
	else if(target.indexOf('other') > -1)
	{
		elem = target;
	}
	else
	{
		elem = $('#tmpSELELEM').val();
		if($('#QIDSELATTRD').val().trim() != "")
		{
			if($('#QIDSELATTRD').val() != "")
			{
				$addedCont = $('#'+$('#QIDSELATTRD').val());
			}
			else
			{
				$addedCont = $('#QIDworkArea');
			}
			
			wh = 94;
			hi = 76;
				
			var curElem = $addedCont;
			while(curElem.attr("id") != "QIDworkArea")
			{
				//wh += curElem.position().left;
				//hi += curElem.position().top;
				
				curElem = curElem.parent();
			}
		}
		else
		{
			$addedCont = $("#QIDworkArea");
			wh = 94;
			hi = 76;
		}
	}
	


	if($('#tmpSELELEM').val().toString().indexOf('form') > -1)
	{
		$selection.attr("type", $('#tmpSELELEM').val().replace("form:",""));
	}

	$selection.addClass("li-"+elem.replace(':','-').replace(':','-'));

	$selection.css
	({
		'top':    click_y - hi,
		'left':   click_x - wh,
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
			'top': new_y - hi,
			'left': new_x - wh
		});

	}).on('mouseup', function(e) 
	{
		$container.off('mousemove');
		tmpid++;

		$selection.attr("id", "tmpid_qiwd_"+tmpid);
		var wh = 0,hi = 0;
		
		var celem = $addedCont;
		while(celem.attr("id") != "QIDworkArea")
		{
			wh += celem.position().left;
			hi += celem.position().top;
			
			celem = celem.parent();
			alert(celem.attr("id"));
		}
		
		$("#tmpid_qiwd_"+tmpid).css("left",($("#tmpid_qiwd_"+tmpid).position().left - wh) + "px");
		$("#tmpid_qiwd_"+tmpid).css("top",($("#tmpid_qiwd_"+tmpid).position().top - hi) + "px");
		
		$("#tmpid_qiwd_"+tmpid).removeClass('QIDselectionBox');
		$("#tmpid_qiwd_"+tmpid).addClass('QIDivOuterX');
		
		

		var act = "clickEvent($(this));";

		if(elem == "label")
		act += "if($(this)[0].nodeName == 'INPUT'){$('#valueinput').slideDown()}else{$('#valueinput').slideUp()}";

		$("#tmpid_qiwd_"+tmpid).attr("onclick", act);
		$("#tmpid_qiwd_"+tmpid).attr("data-qtool", $("#qToolSel").val());
		$("#tmpid_qiwd_"+tmpid).css("position","absolute");

		$("#QIDdrawingMode").html("");
		$("#QIDhiddenWorkArea").fadeOut(50);
		//$workspace.append($selection);
		
		$addedCont.append($selection);
		$selection.remove();
		
		
		htmlSourceEdit(false);
	});
});