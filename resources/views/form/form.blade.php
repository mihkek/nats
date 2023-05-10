

<!--{{-- Modal Сатурн --}}-->
<div class="modal fade" id="CallMeSaturn" tabindex="-1" role="dialog" aria-labelledby="CallMeSaturnLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="CallMeSaturnLabel">Регистрация в САТУРН</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div>
					<input type="hidden" id="satrun_form_subject" name="satrun_form_subject" value="Регистрация в САТУРН">
					<div class="form-group">
						<label for="saturn_recipient" class="col-form-label">ФИО:</label>
						<input type="text" class="form-control" id="saturn_recipient" name="saturn_recipient">
					</div>
					<div class="form-group">
						<label for="saturn_company" class="col-form-label">Название компании:</label>
						<input type="text" class="form-control" id="saturn_company" name="saturn_company">
					</div>
					<div class="form-group">
						<label for="saturn_inn" class="col-form-label">ИНН:</label>
						<input type="text" class="form-control" id="saturn_inn" name="saturn_inn">
					</div>
					<div class="form-group">
						<label for="saturn_phone" class="col-form-label">Номер телефона:</label>
						<input type="text" class="form-control" id="saturn_phone" name="saturn_phone">
					</div>
					<div class="form-group">
						<label for="saturn_email" class="col-form-label">Email:</label>
						<input type="email" class="form-control" id="saturn_email" name="saturn_email">
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>-->
				<button type="button" class="btn btn-primary success" onclick="CallMeSaturn();" style="background-color: lightgreen;">Заказать</button>
			</div>
		</div>
	</div>
</div>














<!--{{-- Modal Обратный звонок --}}-->
<div class="modal fade" id="CallMe" tabindex="-1" role="dialog" aria-labelledby="CallMeLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="CallMeLabel">Обратный звонок</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div>
					<input type="hidden" id="form_subject" name="form_subject" value="Запрос на обратный звонок">
					<div class="form-group">
						<label for="recipient" class="col-form-label">Ваше имя:</label>
						<input type="text" class="form-control" id="recipient" name="recipient">
					</div>
					<div class="form-group">
						<label for="phone" class="col-form-label">Номер телефона:</label>
						<input type="text" class="form-control" id="phone" name="phone">
					</div>
				</div>
				<div class="captcha">
					<div class="g-recaptcha" data-sitekey="6Le7UWgjAAAAAMgR43b-SWnrywA5nYk_Rcunvrf8">
				</div>
			</div>
			<div class="modal-footer">
				<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>-->
				<button type="button" class="btn btn-primary success" onclick="CallMe();" style="background-color: lightgreen;">Заказать звонок</button>
			</div>
		</div>
	</div>
</div>










<!--{{-- Modal Агро сопровождение --}}-->
<div class="modal fade" id="CallMeAgro" tabindex="-1" role="dialog" aria-labelledby="CallMeAgroLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="CallMeAgroLabel">Подтвердите данные</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div>
					<input type="hidden" id="agro_form_subject" name="agro_form_subject" value="Запрос на агрономическое сопровождение">
					<div class="form-group">
						<label for="agro_recipient" class="col-form-label">Ваше имя:</label>
						<input type="text" class="form-control" id="agro_recipient" name="agro_recipient">
					</div>
					<div class="form-group">
						<label for="agro_phone" class="col-form-label">Номер телефона:</label>
						<input type="text" class="form-control" id="agro_phone" name="agro_phone">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary success" onclick="CallMeAgro();" style="background-color: lightgreen;">Подтверждаю</button>
			</div>
		</div>
	</div>
</div>



<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script src="/js/jquery.maskedinput.min.js"></script>
<script src="/js/form/callme.js"></script>


