

function show_dataType(dataType) {
	if (dataType != "all") {
		$('.search').attr('disabled',false);
	} else {
		$('.search').attr('disabled',true);
	}

	//alert(dataType+" TIPO"+typeof(dataType));

	switch (dataType) {
		/*
		case "int": var format = "(numero)";break;
		case "string":var format = "(referencia textual)";break;
		case "blob":var format = "(referencia textual)";break;
		case "date": var format = "(fecha en formato AAAA-MM-DD)";break;
		*/

		case "3": var format = "(numero)";break;
		case "246": var format = "(numero decimal)";break;
		case "253":var format = "(referencia textual)";break;
		case "12": var format = "(fecha en formato AAAA-MM-DD)";break;
		default: var format = ""; break;

		// 3 int / 253 string / 246 float / 12 datetypr
	}
	$('#dataType-ref').empty();
    $('#dataType-ref').append(format);	
}

function dataDisplayer_pagination(action) {

	//recogemos la pagina actual y las totales
	var actualPage = document.getElementById("actual-page").value;
	var totalPages = document.getElementById("total-pages").value;
	
	//en funcion de si la paginación es de retroceso o avance...
	$('#display_page_'+actualPage).css("display","none");
	
	switch (action) { 
		case "next": {
			actualPage++;
			break;
		}
		case "prev": {
			actualPage--;
			break;
		}
	}
	$('#display_page_'+actualPage).css("display","block");
	$('#actual-page').val(actualPage);
	$('#count-pages').empty();
    $('#count-pages').append(actualPage);	
	
	//borraremos los botones next o prev (o los mostraremos)
	if (actualPage==1) {
		$('#prev-button').css("display","none");
		$('#next-button').css("display","inline");
	} else if (actualPage==totalPages) {
		$('#next-button').css("display","none");
		$('#prev-button').css("display","inline");
	} else {
		$('#next-button').css("display","inline");
		$('#prev-button').css("display","inline");
	}

}

function windowScaleSize() {
  var size = [0, 0];
  if (typeof window.innerWidth != 'undefined')
  {
    size = [
        window.innerWidth,
        window.innerHeight
    ];
  }
  else if (typeof document.documentElement != 'undefined'
      && typeof document.documentElement.clientWidth !=
      'undefined' && document.documentElement.clientWidth != 0)
  {
 size = [
        document.documentElement.clientWidth,
        document.documentElement.clientHeight
    ];
  }
  else   {
    size = [
        document.getElementsByTagName('body')[0].clientWidth,
        document.getElementsByTagName('body')[0].clientHeight
    ];
  }
  return size;
}

function showText(textIndex) {
	var notext = $('#displayText_'+textIndex).val();
	if (notext == "" ) notext = true; else notext=false;
	
	if (notext) {
		text="<i><b>Este campo est&aacute; vac&iacute;o<b></i>"
	} else {
		var text = "<i><b>Click para copiar:</b></i><br/><br/>"; 
		text += $('#displayText_'+textIndex).val(); 
	}
	$('#textViewer_box').html(text);
}

window.onload = function() {
	size = windowScaleSize();
	$("#leftside-menu").css("min-height",size[1]-148);
	$("#info-displayer").css("min-height",size[1]-148);
	//$("#content").css("min-height",size[1]-118);
	$windowWidth = size[0];
	$windowHeight = size[1];
	
	var viewerBox = '<div id="textViewer_box"></div>';
	$('body').append(viewerBox);	
	
	$('.textViewer').hover(function() {	
		$('#textViewer_box').show();
	}, function() {
		$('#textViewer_box').hide();
	}).mousemove(function(e) {
		var x = e.pageX;
		var y = e.pageY;
						
		var tx = $('#textViewer_box').outerWidth();
		var ty = $('#textViewer_box').outerHeight();
						
		var bodyX = $('body').outerWidth();
		var bodyY = $('body').outerHeight();
						
		$('#textViewer_box').css({
			top: y + ty > bodyY ? y - ty : y,
			left: x + tx > bodyX ? x - tx - 10 : x + 15
		});
	});								
}

function copyToClipboard (textIndex) {
	var text = $('#displayText_'+textIndex).val(); 
	window.prompt ("Copia el texto con Ctrl+C:", text);
}

window.onresize = function() {
 	size = windowScaleSize();
	$("#leftside-menu").css("min-height",size[1]-148); 
	$("#info-displayer").css("min-height",size[1]-148);
	//$("#content").css("min-height",size[1]-118);
	$windowWidth = size[0];
	$windowHeight = size[1];
};
