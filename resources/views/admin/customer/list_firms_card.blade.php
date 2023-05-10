@section('title', 'Клиенты / Организация')
@extends('admin.template')

@section('main')
<?PHP use App\Models\User; ?>


<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
.btn-sm {
    padding: 3px 10px;
	margin:0px;
    font-size: 12px;
    line-height: 12px;
	}
table.dataTable thead th, table.dataTable tfoot th {
    font-weight: normal;
	}
.category-list .btn {
	margin: 5px 2px 0 0;
	}
table.dataTable thead th.sorting_asc, 
table.dataTable tfoot th.sorting_asc, 
table.dataTable thead th.sorting_desc, 
table.dataTable tfoot th.sorting_desc {
	font-weight:bold;
	}
.category-list .btn {
	border-bottom:0px;
	}

table.dataTable td i {
	margin-right:8px;
}

.list-group-item>span {
    float: right;
}
.list-group-item > .btn-group {
	margin: 5px 2px 0 0;
}
.list-group-item {
	border-left: 0px;
	border-right: 0px;
	}
.list-group .list-group-item:first-child {
	border-top: 0px !important;
	}
.list-group .list-group-item:last-child {
	border-bottom: 0px !important;
	}
.tabbable-custom > .tab-content {
	padding:15px 0px;
	}
.tabbable-custom .list-group {
	margin-bottom:0px;
	}
.tabbable-custom>.nav-tabs>li.active {
    border-top: 5px solid #377BB5;
	}
.list-group .list-group-item.small {
	padding-top:6px;
	padding-bottom:6px;
	}
.list-group-item.subitem {
	border:0px;
	padding-left:35px;
	}

.badge {
    font-size: 14px!important;
	height:auto;
	padding-left:15px;
	padding-right:15px;
	margin-top:-2px;
	margin-bottom:-2px;
	}
.badge-default {
	color:#000000;
	}
.list-group-item .big_header {
	font-size: 18px;
	font-weight:bold;
}
</style>




<div class="page-content-wrapper">
	<div class="page-content">




<div class="row">




		<div class="col-xs-12 col-sm-6">

			<ul class="list-group">
				<li class="list-group-item">
					<span>
						<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" data-toggle="tooltip" data-placement="left" data-original-title="Добавить новую строчку"><i class="fa fa-plus font-red-thunderbird"></i></a>
					</span>
					<h4><b>ООО "Рога и Копыта"</b> <span class="badge badge-danger circle">Клиент</span></h4>
				</li>
				<li class="list-group-item">
					Офис главный
					<span>Москва, Красная площадь, дом 1, офис 1 <a href="https://yandex.ru/maps/?ll=37.618174%2C55.754998&amp;mode=search&amp;text=Москва, Красная площадь, дом 1" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Показать на карте"><i class="icon-globe"></i></a>
					<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить адрес"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон основной 
					<span>+7 (495) 000-00-00 
					<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон бухгалтерии
					<span>+7 (495) 111-11-11 <a href="callto:+7495111111" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Факс основной
					<span>+7 (495) 222-22-22 <a href="callto:+7495222222" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить факс"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					E-mail основной
					<span>info@mail.ru <a href="mailto:info@mail.ru" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить E-mail"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					E-mail бухгалтерии
					<span>test@mail.ru <a href="mailto:test@mail.ru" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить E-mail"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Веб-сайт
					<span>www.mvideo.ru <a href="https://www.mvideo.ru/" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Посетить веб-сайт"><i class="icon-paper-plane"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить веб-сайт"></i></a></span>
					<div style="clear:both;"></div>
				</li>

				<li class="list-group-item">
					<div class="btn-group">
						<a href="/admin/orderer/now" class="btn btn-success"><i class="icon-earphones-alt"></i> ЗАНЯТИЯ</a>
						<a href="/admin/orderer/now" class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Добавить новый"><i class="fa fa-plus"></i></a>
					</div>
					<div class="btn-group">
						<a href="/admin/documenter/list" class="btn btn-primary"><i class="icon-folder"></i> ДОКУМЕНТЫ</a>
						<a href="/admin/templater/add" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Добавить новый"><i class="fa fa-plus"></i></a>
					</div>
					<?PHP /*
					<div class="btn-group">
						<a href="#events" class="btn btn-warning"><i class="icon-earphones-alt"></i> СОБЫТИЯ</a>
						<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" class="btn btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Добавить новое"><i class="fa fa-plus"></i></a>
					</div>
					*/ ?>
					<div class="btn-group">
						<a href="/admin/customer/represents" class="btn btn-danger"><i class="icon-users"></i> КОНТАКТЫ</a>
						<a href="/admin/customer/represents" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Добавить новый"><i class="fa fa-plus"></i></a>
					</div>
				</li>

			</ul>



			<ul class="list-group">
				<li class="list-group-item small bg-default font-grey-cascade">
					ID фирмы
					<span>F000000003725</span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item small bg-default font-grey-cascade">
					Ответственный менеджер
					<span><a href="/admin/configer/users" class="font-grey-cascade" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку менеджера">Яковлева С.В.</a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item small bg-default font-grey-cascade">
					Дата и время создания
					<span>2 октября 2019, 14:54</span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item small bg-default font-grey-cascade">
					Дата и время изменения
					<span>11 октября 2019, 06:33</span>
					<div style="clear:both;"></div>
				</li>
			</ul>



		</div>










		<div class="col-xs-12 col-sm-6">

			<ul class="list-group">
				<li class="list-group-item">
					<span>
						<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" data-toggle="tooltip" data-placement="left" data-original-title="Добавить новую строчку"><i class="fa fa-plus font-red-thunderbird"></i></a>
					</span>
					<h4><b><a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку человека">Иванов Иван Иванович</a></b></h4>
				</li>
				<li class="list-group-item">
					Должность
					<span>Генеральный директор 
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить должность"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон основной 
					<span>+7 (495) 000-00-00 
					<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон секретаря
					<span>+7 (495) 111-11-11 
					<a href="callto:+7495111111" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					E-mail основной
					<span>info@mail.ru 
					<a href="mailto:info@mail.ru" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить E-mail"></i></a></span>
					<div style="clear:both;"></div>
				</li>
			</ul>


			<ul class="list-group">
				<li class="list-group-item">
					<span>
						<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" data-toggle="tooltip" data-placement="left" data-original-title="Добавить новую строчку"><i class="fa fa-plus font-red-thunderbird"></i></a>
					</span>
					<h4><b><a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку человека">Наталья Наташкина</a></b></h4>
				</li>
				<li class="list-group-item">
					Должность
					<span>Помощник руководителя
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить должность"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон основной 
					<span>+7 (495) 000-00-00 
					<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					E-mail основной
					<span>info@mail.ru 
					<a href="mailto:info@mail.ru" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить E-mail"></i></a></span>
					<div style="clear:both;"></div>
				</li>
			</ul>

			<ul class="list-group">
				<li class="list-group-item">
					<span>
						<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" data-toggle="tooltip" data-placement="left" data-original-title="Добавить новую строчку"><i class="fa fa-plus font-red-thunderbird"></i></a>
					</span>
					<h4><b><a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку человека">Семён Семёнович</a></b></h4>
				</li>
				<li class="list-group-item">
					Должность
					<span>Менеджер
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить должность"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					Телефон основной 
					<span>+7 (495) 000-00-00 
					<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить телефон"></i></a></span>
					<div style="clear:both;"></div>
				</li>
				<li class="list-group-item">
					E-mail основной
					<span>info@mail.ru 
					<a href="mailto:info@mail.ru" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>
					<a href="#order-text-temp" data-toggle="modal"><i class="fa fa-sync font-red-thunderbird" data-toggle="tooltip" data-placement="left" data-original-title="Изменить E-mail"></i></a></span>
					<div style="clear:both;"></div>
				</li>
			</ul>

		</div>



	</div>


















<?PHP /*
<a name="events"></a>
<br />


<!--{{-- ########################## ТАБЫ ################################### --}}-->
<div class="tabbable-custom ">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_11" data-toggle="tab" aria-expanded="true"><b>События проекта</b></a></li>
		<li>
			<a href="javascript:alert('Здесь пока нет окна, но скоро оно сюда будет добавлено');" class="font-red-thunderbird"><i class="fa fa-plus font-red-thunderbird"></i> <b>Добавить</b></a>
		</li>
	</ul>

<div class="tab-content">





<!-- ########################## ТАБ 1 ################################### -->
<div class="tab-pane fade active in" id="tab_11">
	<div class="row">
		<div class="col-lg-12">
			<div style="padding:0 15px;">


                      <table class="table table-striped table-advance table-hover dataTable" id="tableMain">
                        <thead>
                            <tr>
                                <th class="">Дата события</th>
                                <th class="">Событие</th>
                                <th class="">Ответственный</th>
                            </tr>
                        </thead>
                        <tbody>

<?PHP
$array = Array();
$array[] = '<i class="icon-check"></i> Произведена оплата или доплата';
$array[] = '<i class="icon-check"></i> Проведено занятие с преподавателем';
$array[] ='<i class="icon-call-out"></i> Совершён телефонный звонок';
$array[] ='<i class="icon-envelope"></i> Отправлен E-mail c подробностями о нас';
?>

@for ($i = 0; $i < 30; $i++)
				<tr class="odd gradeX getDataId item-row" data-item-id="">
					<td class=""><?PHP print rand (1,29); ?> октября 2019, <?PHP print rand (1,12); ?>:<?PHP print rand (10,59); ?></td>
					<td class=""><?PHP print $array[rand(0,3)]; ?></td>
					<td class="text-nowrap hidden-xs"><a href="/admin/configer/users">Яковлева С.В.</a></td>
				</tr>
@endfor

                        </tbody>
                        <thead>
                            <tr>
                                <th class="">Дата события</th>
                                <th class="">Событие</th>
                                <th class="">Ответственный</th>
                            </tr>
                        </thead>
                    </table>


			</div>
		</div>
	</div>
</div>





</div>
</div>
*/ ?>












</div>
</div>








<!--{{-- ################ ОКНО ВВОДА СТРОЧКИ ######################### --}}-->
<div id="order-text-temp" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4><b>Ввести или изменить строку</b></h4>
			</div>
			<div class="modal-body">

				<div class="form-group"><label>
					<input type="text" class="form-control" value="">
				</label></div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn green" data-dismiss="modal">Сохранить</button>
			</div>
		</div>
	</div>
</div>





@endsection
@push('scripts')

<script src="/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/js/bootstrap-datetimepicker.ru.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery('.form_date_time').datetimepicker({
	language:  'ru',
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	forceParse: 0,
	showMeridian: 0
});
</script>

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
{{--        App.components.admin_settings.init(); --}}
		jQuery(document).ready( function () {
			jQuery('#tableMain').DataTable({
"autoWidth": false,
"pageLength": 25, 
"aaSorting": [
	[ 0, "desc" ]
	],
"aoColumnDefs" : [ 
		{ 'bSortable' : false, 'aTargets' : [ "no-sort" ] }
	],
"language": {
    "info":           "Показаны строки c _START_ по _END_ из _TOTAL_",
    "infoEmpty":      "",
    "infoFiltered":   "(отфильтровано из _MAX_ строчек)",
	"lengthMenu":     "Показать _MENU_ строчек",
    "loadingRecords": "Чтение...",
    "processing":     "Обработка...",
    "search":         "Поиск:",
    "zeroRecords":    "<BR><BR><BR>Не найдено ни одной записи,<BR>попробуй измени кретиреии поиска<BR><BR><BR><BR>",
    "paginate": {
        "first":      "Первая",
        "last":       "Последняя",
        "next":       "Вперёд",
        "previous":   "Назад"
    } }
});
			} );
    </script>
@endpush