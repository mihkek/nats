

	<!--{{-- ################ ОКНО ПОДТВЕРЖДЕНИЯ ЗАНЯТИЯ  ######################### --}}-->
	<div id="OrderConfirm" data-target="#OrderConfirm" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="title" style="font-weight:bold;">
						<i class="icon-pin"></i>
						Подтвердить занятие
					</h4>
				</div>
				<div class="modal-body">

					<ul class="list-group">

						<li class="list-group-item">
							Сначала необходимо обязательно указать дату и время <b>следующего</b> занятия
						</li>

						<li class="list-group-item">
							<font class="name">Дата следующего занятия <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">22.02.2020</font>
								<a href="#" class="modalTextShow pull-right" data-target="#AddEditRowText" data-mask="00.00.0000" data-placeholder="00.00.0000">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

						<li class="list-group-item">
							<font class="name">Время следующего занятия <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">13:00</font>
								<a href="#" class="modalTextShow pull-right" data-target="#AddEditRowText" data-mask="00:00" data-placeholder="00:00">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

					</ul>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Отмена</button>
					<button type="button" class="btn green" data-dismiss="modal">Сохранить</button>
				</div>
			</div>
		</div>
	</div>





	<!--{{-- ################ ОКНО ПЕРЕНОСЯ ЗАНЯТИЯ  ######################### --}}-->
	<div id="OrderMove" data-target="#OrderMove" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="title" style="font-weight:bold;">
						<i class="icon-action-redo"></i>
						Перенести занятие
					</h4>
				</div>
				<div class="modal-body">

					<ul class="list-group">

						<li class="list-group-item">
							<font class="name">Причина переноса <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">Болезнь</font>
								<a href="#" class="modalSelectShow pull-right" data-target="#AddEditRowSelect" data-options='Болезнь|Отпуск|Изменения в рабочем графика|Прочее'>
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

						<li class="list-group-item">
							<font class="name">Комментарий <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">Нет комментария</font>
								<a href="#" class="modalAreaShow pull-right" data-target="#AddEditRowArea">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

						<li class="list-group-item">
							<font class="name">Новая дата занятия <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">22.02.2020</font>
								<a href="#" class="modalTextShow pull-right" data-target="#AddEditRowText" data-mask="00.00.0000" data-placeholder="00.00.0000">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

						<li class="list-group-item">
							<font class="name">Новое время занятия <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">13:00</font>
								<a href="#" class="modalTextShow pull-right" data-target="#AddEditRowText" data-mask="00:00" data-placeholder="00:00">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

					</ul>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Отмена</button>
					<button type="button" class="btn green" data-dismiss="modal">Сохранить</button>
				</div>
			</div>
		</div>
	</div>





	<!--{{-- ################ ОКНО ОТМЕНЫ ЗАНЯТИЯ  ######################### --}}-->
	<div id="OrderCancel" data-target="#OrderCancel" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="title" style="font-weight:bold;">
						<i class="icon-ban"></i>
						Отменить занятие
					</h4>
				</div>
				<div class="modal-body">

					<ul class="list-group">

						<li class="list-group-item">
							<font class="name">Причина отмены <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">Болезнь</font>
								<a href="#" class="modalSelectShow pull-right" data-target="#AddEditRowSelect" data-options='Болезнь|Отпуск|Изменения в рабочем графика|Прочее'>
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

						<li class="list-group-item">
							<font class="name">Комментарий <span class="font-red-mint">*</span></font>
							<span>
								<font class="value" id="val{{ $count++ }}">Нет комментария</font>
								<a href="#" class="modalAreaShow pull-right" data-target="#AddEditRowArea">
                                    <i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Редактировать"></i>
                                </a>
							</span>
							<div style="clear:both;"></div>
						</li>

					</ul>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Отмена</button>
					<button type="button" class="btn green" data-dismiss="modal">Сохранить</button>
				</div>
			</div>
		</div>
	</div>





	<!--{{-- ################ ОКНО ОЦЕНКИ ЗАНЯТИЯ  ######################### --}}-->
	<div id="OrderVote" data-target="#OrderVote" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="title" style="font-weight:bold;">
						<i class="icon-like"></i>
						Оценить занятие
					</h4>
				</div>
				<div class="modal-body">

					<ul class="list-group">

						<li class="list-group-item text-center" style="font-size:300%;">
							<a class="votestar" href="#" data-dismiss="modal">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							</a>
						</li>
						<li class="list-group-item text-center" style="font-size:300%;">
							<a class="votestar" href="#" data-dismiss="modal">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							</a>
						</li>
						<li class="list-group-item text-center" style="font-size:300%;">
							<a class="votestar" href="#" data-dismiss="modal">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							</a>
						</li>
						<li class="list-group-item text-center" style="font-size:300%;">
							<a class="votestar" href="#" data-dismiss="modal">
								<i class="fa fa-star"></i><i class="fa fa-star"></i>
							</a>
						</li>
						<li class="list-group-item text-center" style="font-size:300%;">
							<a class="votestar" href="#" data-dismiss="modal">
								<i class="fa fa-star"></i>
							</a>
						</li>

					</ul>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Отмена</button>
				</div>
			</div>
		</div>
	</div>

