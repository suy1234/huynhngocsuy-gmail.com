<?php
function getLangCode()
{
	return Lang::locale();
}
function formatPrice($price , $currency = 'đ')
{
	return number_format($price, 0, ",", ".").$currency;
}
function formatUrl($text) {
	$text = html_entity_decode(trim(mb_strtolower($text, 'UTF-8')), ENT_QUOTES, 'UTF-8');
	$text = str_replace(
		array('/', "\\", '"', '?', '<', '>', "^", "`", "'", "=", "!", ":", ",", "*", "&", '$', '|', '%', '#', "▄", "♥", '  ', ' - ', 'quot;', '’', "®", "©", 'î', "'", '39;', '.', '(', ')', '“', '”'),
		array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' ', '-', '', '', '', '', 'i', '', '', '', '', '', '', ''),
		$text);
	$text = str_replace(
		array('_', '   ', '  ', ' '),
		array('-', '-', '-', '-'),
		$text);
	$chars = array("a", "A", "e", "E", "o", "O", "u", "U", "i", "I", "d", "D", "y", "Y");
	$uni[0] = array("á", "à", "ạ", "ả", "ã", "â", "ấ", "ầ", "ậ", "ẩ", "ẫ", "ă", "ắ", "ằ", "ặ", "ẳ", "� �", "ẵ");
	$uni[1] = array("Á", "À", "Ạ", "Ả", "Ã", "Â", "Ấ", "Ầ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ắ", "Ằ", "Ặ", "Ẳ", "� �");
	$uni[2] = array("é", "è", "ẹ", "ẻ", "ẽ", "ê", "ế", "ề", "ệ", "ể", "ễ");
	$uni[3] = array("É", "È", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ế", "Ề", "Ệ", "Ể", "Ễ");
	$uni[4] = array("ó", "ò", "ọ", "ỏ", "õ", "ô", "ố", "ồ", "ộ", "ổ", "ỗ", "ơ", "ớ", "ờ", "ợ", "ở", "ỡ", "� �");
	$uni[5] = array("Ó", "Ò", "Ọ", "Ỏ", "Õ", "Ô", "Ố", "Ồ", "Ộ", "Ổ", "Ỗ", "Ơ", "Ớ", "Ờ", "Ợ", "Ở", "Ỡ", "� �");
	$uni[6] = array("ú", "ù", "ụ", "ủ", "ũ", "ư", "ứ", "ừ", "ự", "ử", "ữ");
	$uni[7] = array("Ú", "Ù", "Ụ", "Ủ", "Ũ", "Ư", "Ứ", "Ừ", "Ự", "Ử", "Ữ");
	$uni[8] = array("í", "ì", "ị", "ỉ", "ĩ");
	$uni[9] = array("Í", "Ì", "Ị", "Ỉ", "Ĩ");
	$uni[10] = array("đ");
	$uni[11] = array("Đ");
	$uni[12] = array("ý", "ỳ", "ỵ", "ỷ", "ỹ");
	$uni[13] = array("Ý", "Ỳ", "Ỵ", "Ỷ", "Ỹ");
	$n = count($uni);
	for ($i = 0; $i < $n; ++$i) {
		$text = str_replace($uni[$i], $chars[$i], $text);
	}
	return $text;
}
function formatDate($date)
{
	if(!empty($date)){
		return date('d-m-Y H:i:s', strtotime($date));
	}
	return '';
}

function input($type, $name, $label, $custom = [])
{
	$class = '';
	if(!empty($custom['class'])){
		$class = $custom['class'];
		unset($custom['class']);
	}
	if(!empty($custom['required'])){
		$class = $custom['required'];
		unset($custom['required']);
	}
	
	return '<div class="form-group">
	<label for="'.$name.'">'.$label.'</label>
	<input type="'.$type.'" id="'.$name.'" '.$custom.' class="form-control '.$class.'" value=""/>
	</div>';
}