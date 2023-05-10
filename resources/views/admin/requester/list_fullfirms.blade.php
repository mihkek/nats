@section('title', 'Все заявки')
@extends('admin.template')

@section('main')
<?PHP use App\Models\User; ?>


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
table.dataTable td.signal i {
	margin:0px !important;
	padding:3px;
}
</style>



<div class="page-content-wrapper">
<div class="page-content">






<!--{{---------CATEGORIES------------}}-->
<div class="row">
	<div class="col-xs-12">
                                <div class="category-list">
                                    <a href="#" class="btn white font-dark">ВСЕ</a> 
                                    <a href="#" class="btn purple-wisteria">Новые</a> 
                                    <a href="#" class="btn purple-wisteria">Горячие</a> 
                                    <a href="#" class="btn purple-wisteria">Перезвонить</a> 
                                    <a href="#" class="btn purple-wisteria">Отложенные</a> 
                                    <a href="#" class="btn purple-wisteria">Отказанные</a> 
                                    <a href="#" class="btn purple-wisteria">Завершенные</a> 
					  </div>
	</div>
</div>

 




			<div class="row">
				<div class="col-lg-12">
                    <div class="portlet-body">
                        <div class="portlet light bordered">                           

                      <table class="table table-striped table-advance dataTable" id="tableMain">
                        <thead>
                            <tr>
                                <th class="">Дата заявки</th>
                                <th class="">Клиент</th>
                                <th class="">Контакты</th>
                                <th class="">E-mail</th>
                                <th class="">Сумма</th>
                                <th class="">Следующий контакт</th>
                                <th class="text-center">Статус заявки</th>
                                <th class="">Комментарий</th>
                                <th class="text-center hidden-xs">ID</th>
                            </tr>
                        </thead>
                        <tbody>



<?PHP 
$pays = array("Безнал р/сч", "Наличные", "Карта"); 
$status = array(
'<td class="text-center bg-white"><a href="/admin/requester/now/card/900" class=" font-dark" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Новое</a></td>',
'<td class="text-center bg-red-thunderbird"><a href="/admin/requester/now/card/900" class=" font-white" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Горячее</a></td>',
'<td class="text-center bg-green-jungle"><a href="/admin/requester/now/card/900" class=" font-white" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Перезвонить</a></td>',
'<td class="text-center bg-yellow-crusta"><a href="/admin/requester/now/card/900" class=" font-white" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Отложено</a></td>',
'<td class="text-center bg-green-jungle"><a href="/admin/requester/now/card/900" class=" font-white" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Отказано</a></td>',
'<td class="text-center bg-green-jungle"><a href="/admin/requester/now/card/900" class=" font-white" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Завершено</a></td>',
); 
$status3 = array("Живет на Рублевке", "Обратить важное внимание!", "&nbsp;", "&nbsp;", "&nbsp;");
?>

@for ($i = 0; $i < 14; $i++)
				<tr class="odd gradeX getDataId item-row" data-item-id="">
					<td class=""><?PHP print rand (01,29); ?> октября 2019, <?PHP print rand (1,12); ?>:<?PHP print rand (10,59); ?></td>
					<td class=""><a href="/admin/requester/now/card/900" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">ООО "Рога и копыта"</a></td>
					<td class="hidden-xs"><a href="/admin/requester/now/card/900" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Иванов Иван Иванович</a><br />
<a href="/admin/requester/now/card/900" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Сергеев Сергей Сергеевич</a></td>
					<td class="text-nowrap">
						<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 000-00-00<BR />
						<a href="callto:+74951111111" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 111-11-11<BR />
						<a href="mailto:info@mail.ru" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>info@mail.ru</a></td>
					<td class="text-right text-nowrap"><a href="/admin/orderer/now/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку"><?PHP print number_format(rand (500,3000), 2, ',', ' '); ?></a></td>
					<td class=""><?PHP print rand (15,29); ?> октября 2019, <?PHP print rand (1,12); ?>:<?PHP print rand (10,59); ?></td>
					<?PHP print $status[rand(0,5)]; ?>
					<td class=""><small><?PHP print $status3[rand(0,4)]; ?></small></td>
					<td class="text-center hidden-xs"><i class="icon-tag" data-toggle="tooltip" data-placement="left" data-original-title="ID заявки Q00000<?PHP print rand (1000,9999); ?>"></i></td>
				</tr>


				<tr class="odd gradeX getDataId item-row" data-item-id="">
					<td class=""><?PHP print rand (01,29); ?> октября 2019, <?PHP print rand (1,12); ?>:<?PHP print rand (10,59); ?></td>
					<td class=""><a href="/admin/requester/now/card/900" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">ООО "Тестовая компания"</a></td>
					<td class="hidden-xs"><a href="/admin/requester/now/card/900" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку">Петров Пётр Петрович</a></td>
					<td class="text-nowrap">
						<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 222-22-22<BR />
						<a href="mailto:info@mail.ru" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>info@mail.ru</a></td>
					<td class="text-right text-nowrap"><a href="/admin/orderer/now/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть заявку"><?PHP print number_format(rand (500,3000), 2, ',', ' '); ?></a></td>
					<td class=""><?PHP print rand (15,29); ?> октября 2019, <?PHP print rand (1,12); ?>:<?PHP print rand (10,59); ?></td>
					<?PHP print $status[rand(0,5)]; ?>
					<td class=""><small><?PHP print $status3[rand(0,4)]; ?></small></td>
					<td class="text-center hidden-xs"><i class="icon-tag" data-toggle="tooltip" data-placement="left" data-original-title="ID заявки Q00000<?PHP print rand (1000,9999); ?>"></i></td>
				</tr>
@endfor




                        </tbody>
                        <thead>
                            <tr>
                                <th class="">Дата заявки</th>
                                <th class="">Клиент</th>
                                <th class="">Контакты</th>
                                <th class="">E-mail</th>
                                <th class="">Сумма</th>
                                <th class="">Следующий контакт</th>
                                <th class="text-center">Статус заявки</th>
                                <th class="">Комментарий</th>
                                <th class="text-center hidden-xs">ID</th>
                            </tr>
                        </thead>
                    </table>

                        </div>
                    </div>
                </div>
			</div>










</div>
</div>









@endsection
@push('scripts')
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script>
{{--        App.components.admin_settings.init();
--}}
		jQuery(document).ready( function () {
			jQuery('#tableMain').DataTable({
"autoWidth": false,
"pageLength": 50, 
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