var baseurl = window.location.origin;
function addPreload() {
	//$(".page-loader-wrapper").remove();
	var html="<div class='page-loader-wrapper' >" +
		"<div class='loader'>" +
		"    <div class='preloader'>" +
		"        <div class='spinner-layer pl-red'>" +
		"            <div class='circle-clipper left'>" +
		"                <div class='circle'></div>" +
		"            </div>" +
		"            <div class='circle-clipper right'>" +
		"                <div class='circle'></div>" +
		"            </div>" +
		"        </div>" +
		"    </div>" +
		"    <p>Carregando o sistema...</p>" +
		"</div>" +
		"</div>";
	$('body').append(html);
}

function removePreload() {
	$(".page-loader-wrapper").fadeOut(1000).remove();
}

function loading() {
	$(".loading").remove();
	var html='<div class="loading"><div class="spinner-border text-primary loading-cicle" role="status"><span class="sr-only">Loading...</span></div></div>';
	$('body').append(html);
}

function progress(texto) {
	$(".progress").remove();
	var html='<div class="progress"><div class="progress-bar my-bg progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 10%">'+
		texto +'</div> </div>';
	$('.card .body').prepend(html);

	$('.progress .progress-bar').animate({width: '85%'}, 5000, 'linear');
}

function showNotify(title, text, type, y, x) {
	if (!type){ type = 'info';}
	if (!y){ y = 'top';}
	if (!x){ x = 'right';}

	var notify = $.notify(
		{ title: '<h5>'+title+'</h5>', message: text },
		{
			type: type,
			allow_dismiss: true,
			newest_on_top: true,
			showProgressbar: false,
			delay: 5000,
			timer: 1000,
			placement: {
				from: y,
				align: x
			},
			animate: {
				enter: 'animated fadeInRight',
				exit: 'animated fadeInRight'
			}
		}
	);
}

function showAlert(title, text, type, color) {
	var img = ((type=='success') ? 'thumbs-up.png' : (type=='error') ? 'thumbs-down.png' : '' );
	swal({
		title: title,
		text: text,
		imageUrl: baseurl+"/theme/_assets/images/"+img,
		confirmButtonColor: color
	});
}

/**  Remover acentos de string */
function removerAcentos( newStringComAcento ) {
	var string = newStringComAcento;
	var mapaAcentosHex = {
		a : /[\xE0-\xE6]/g,
		A : /[\xC0-\xC6]/g,
		e : /[\xE8-\xEB]/g,
		E : /[\xC8-\xCB]/g,
		i : /[\xEC-\xEF]/g,
		I : /[\xCC-\xCF]/g,
		o : /[\xF2-\xF6]/g,
		O : /[\xD2-\xD6]/g,
		u : /[\xF9-\xFC]/g,
		U : /[\xD9-\xDC]/g,
		c : /\xE7/g,
		C : /\xC7/g,
		n : /\xF1/g,
		N : /\xD1/g
	};

	for( var letra in mapaAcentosHex ) {
		var expressaoRegular = mapaAcentosHex[letra];
		string = string.replace( expressaoRegular, letra );
	}

	return string;
}

// Função para criar o cookie.
// Para que o cookie seja destruído quando o brawser for fechado, basta passar 0 no parametro lngDias.
function setCookie(strCookie, strValor, tempo, path) {
	var dtmData = new Date();

	var cookie = strCookie + "=" + strValor;
	if (tempo) {
		dtmData.setTime(dtmData.getTime() + tempo);
		cookie += "; expires=" + dtmData.toGMTString();
	}
	cookie += (path ? ";path=" + path : "");
	document.cookie = cookie;
}

// Função para ler o cookie.
function getCookie(strCookie) {
	var strNomeIgual = strCookie + "=";
	var arrCookies = document.cookie.split(';');

	for (var i = 0; i < arrCookies.length; i++) {
		var strValorCookie = arrCookies[i];
		while (strValorCookie.charAt(0) == ' ') {
			strValorCookie = strValorCookie.substring(1, strValorCookie.length);
		}
		if (strValorCookie.indexOf(strNomeIgual) == 0) {
			return strValorCookie.substring(strNomeIgual.length, strValorCookie.length);
		}
	}
	return null;
}

// Função para excluir o cookie desejado.
function deleteCookie(strCookie) {
	document.cookie = strCookie + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
}

$(".pagination .disabled a").on('click',
	function(avf){ avf.preventDefault();
	});
