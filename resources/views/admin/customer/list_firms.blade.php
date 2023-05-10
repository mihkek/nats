@section('title', 'Все клиенты')
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
</style>



<div class="page-content-wrapper">
	<div class="page-content">






<!--{{---------CATEGORIES------------}}-->
<div class="row">
	<div class="col-xs-12">
                                <div class="category-list">
                                    <a href="#" class="btn white font-dark">ВСЕ</a> 
                                    <a href="#" class="btn grey-mint">Клиенты</a> 
                                    <a href="#" class="btn grey-mint">Поставщики</a> 
                                    <a href="#" class="btn grey-mint">Партнёры</a> 
                                    <a href="#" class="btn grey-mint">Прочие</a>
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
                                <th class="">Название</th>
                                <th class="">Телефоны</th>
                                <th class="">E-mail</th>
                                <th class="hidden-xs">Контакт</th>
                                <th class="hidden-xs">Менеджер</th>
                                <th class="hidden-xs text-center">ID</th>
                            </tr>
                        </thead>
                        <tbody>





@for ($i = 0; $i < 14; $i++)
				<tr class="odd gradeX getDataId item-row" data-item-id="">
					<td class=""><a href="/admin/customer/firms/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку компании">ООО "Рога и копыта"</a></td>
					<td class="text-nowrap">
						<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 000-00-00<BR />
						<a href="callto:+74951111111" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 111-11-11
					</td>
					<td class="text-nowrap"><a href="mailto:info@mail.ru" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>info@mail.ru</a></td>
					<td class="hidden-xs"><a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку человека">Иванов Иван Иванович</a><br />
<a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку контакта">Сергеев Сергей Сергеевич</a></td>
					<td class="text-nowrap hidden-xs"><a href="/admin/configer/users">Яковлева С.В.</a></td>
					<td class="text-center hidden-xs"><i class="icon-tag" data-toggle="tooltip" data-placement="left" data-original-title="ID оргиназации F00000<?PHP print rand (1000,9999); ?>"></i></td>
				</tr>

				<tr class="odd gradeX getDataId item-row" data-item-id="">
					<td class=""><a href="/admin/customer/firms/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку компании">ООО "Тестовая компания"</a></td>
					<td class="text-nowrap">
						<a href="callto:+74950000000" data-toggle="tooltip" data-placement="left" data-original-title="Позвонить прямо сейчас"><i class="icon-call-out"></i></a>+7 (495) 000-00-00
					</td>
					<td class="text-nowrap"><a href="mailto:test-test-test@mail.ru" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="Письмо прямо сейчас"><i class="icon-envelope"></i></a>test-test-test@mail.ru</a></td>
					<td class="hidden-xs"><a href="/admin/customer/represents/card/100" data-toggle="tooltip" data-placement="left" data-original-title="Открыть карточку человека">Петров Пётр Петрович</a></td>
					<td class="text-nowrap hidden-xs"><a href="/admin/configer/users">Яковлева С.В.</a></td>
					<td class="text-center hidden-xs"><i class="icon-tag" data-toggle="tooltip" data-placement="left" data-original-title="ID оргиназации F00000<?PHP print rand (1000,9999); ?>"></i></td>
				</tr>
@endfor




                        </tbody>
                        <thead>
                            <tr>
                                <th class="">Название</th>
                                <th class="">Телефоны</th>
                                <th class="">E-mail</th>
                                <th class="hidden-xs">Контакт</th>
                                <th class="hidden-xs">Менеджер</th>
                                <th class="hidden-xs text-center">ID</th>
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