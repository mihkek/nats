<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ТЕСТ ВЕРТИКАЛЬНОГО КЭШБЭКА</title>
</head>


<h2>ТЕСТ ВЕРТИКАЛЬНОГО КЭШБЭКА</h2>


<form method="get" action="/test/vertical_cashback.php">
<table cellpadding="10">
	<tr>
		<td>ID пользователя</td>
		<td><input name="user_id" value="<?PHP if (isset($_REQUEST['user_id'])) {print $_REQUEST['user_id'];} else { ?>46<?PHP } ?>" /></td>
		<td>Внимание! Юзер ID 46 - это именно тот "конечный" юзер над которым существует 8 афиллатов</td>
	</tr>
	<tr>
		<td>ID партнёра</td>
		<td><input name="partner_id" value="<?PHP if (isset($_REQUEST['partner_id'])) {print $_REQUEST['partner_id'];} else { ?>4<?PHP } ?>" /></td>
		<td>Для тестирования не имеет значения, ID 4 - это тестовый партнёр "СДЭК"</td>
	</tr>
	<tr>
		<td>Кэшбек партнёра</td>
		<td><input name="partner_cashback" value="<?PHP if (isset($_REQUEST['partner_cashback'])) {print $_REQUEST['partner_cashback'];} else { ?>15<?PHP } ?>" /></td>
		<td><select name="partner_cashback_type">
			<option value="%" <?PHP if (isset($_REQUEST['partner_cashback_type']) && $_REQUEST['partner_cashback_type']=="%") {print "selected";} ?>>%</option>
			<option value="руб" <?PHP if (isset($_REQUEST['partner_cashback_type']) && $_REQUEST['partner_cashback_type']=="руб") {print "selected";} ?>>руб</option>
		</select></td>
	</tr>
	<tr>
		<td>Сумма покупки</td>
		<td><input name="summ" value="<?PHP if (isset($_REQUEST['summ'])) {print $_REQUEST['summ'];} else { ?>2000<?PHP } ?>" /></td>
		<td>рублей</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><button type="submit" value="Отправить">Отправить</button></td>
		<td><a href="/test/vertical_cashback.php">Сбросить по умолчанию</a></td>
	</tr>
</table><strong></strong>
</form>


<?PHP
if (
	isset($_REQUEST['user_id']) &&
	isset($_REQUEST['partner_id']) &&
	isset($_REQUEST['partner_cashback']) &&
	isset($_REQUEST['partner_cashback_type']) &&
	isset($_REQUEST['summ'])
	) {


$output =  shell_exec("/opt/php73/bin/php /var/www/fgvista/data/www/fgvista.ru/artisan bonuses_partners:update " . $_REQUEST['user_id'] . " "  . $_REQUEST['partner_id'] . " "  . $_REQUEST['partner_cashback'] . " "  . $_REQUEST['partner_cashback_type'] . " "  . $_REQUEST['summ'] );
echo "<pre>$output</pre>";


}
?>




<body>
</body>
</html>


