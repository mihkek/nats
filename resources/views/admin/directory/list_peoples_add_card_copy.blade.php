@section('title', 'Карточка преподавателя')
@extends('admin.template')

@section('main')
<?PHP use App\Models\User; ?>
{{ $count=1 }}


{{--
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
--}}
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

a.pull-right {
	margin-left:6px;
}
</style>

<link href='/engines/fullcalendar-4.3.1/packages/core/main.css' rel='stylesheet' />
<link href='/engines/fullcalendar-4.3.1/packages/daygrid/main.css' rel='stylesheet' />
<link href='/engines/fullcalendar-4.3.1/packages/timegrid/main.css' rel='stylesheet' />
<link href='/engines/fullcalendar-4.3.1/packages/list/main.css' rel='stylesheet' />

<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<style>
	.fc-button-primary {
		border-radius: 50px!important;
		background-color: #377BB5!important;
		border-color: #377BB5!important;
	}
</style>







<div class="page-content-wrapper">
	<div class="page-content">

		<div id="vueapp">
			<v-container fluid grid-list-md style="padding: 0 !important;">
			  <v-layout row wrap>
			   	<v-flex md6>
			   		<v-card style="border-radius: 8px !important;">
			   		  	<v-card-title primary-title style="padding-bottom: 0 !important;">Новый преподаватель</v-card-title>
			   		  	<v-divider style="margin: 15px 0;"></v-divider>
						<v-card-text>
							<v-text-field
 							  placeholder="Полное имя"
 							  filled
 							  hint="ФИО"
 							   v-model="newItem.name"
 							></v-text-field>
							<v-file-input
 							   placeholder="Фотография"
 							   filled
 							   prepend-icon="mdi-camera"
 							   clear-icon="mdi-close"
 							   hint="Фотография"
 							   accept="image/png, image/jpeg, image/bmp"
 							   v-model="newItem.photo"
 							></v-file-input>
 							<v-text-field
 							  placeholder="Город"
 							  filled
 							  hint="Название города"
 							   v-model="newItem.city"
 							></v-text-field>
 							<v-text-field
 							  placeholder="Метро"
 							  filled
 							  hint="Станция метро"
 							   v-model="newItem.metro"
 							></v-text-field>
 							<v-text-field
 							  placeholder="Адрес"
 							  filled
 							  hint="Адрес проживания"
 							   v-model="newItem.address"
 							></v-text-field>
 							<v-text-field
 							  placeholder="Телефон"
 							  filled
 							  hint="Номер телефона"
 							   v-model="newItem.phone"
 							></v-text-field>
 							<v-text-field
 							  placeholder="Email"
 							  filled
 							  hint="Электронная почта"
 							   v-model="newItem.email"
 							></v-text-field>
 							<v-text-field
 							  placeholder="Район работы"
 							  filled
 							  hint="Район работы"
 							  v-model="newItem.requisites"
 							></v-text-field>
 							<v-card flat class="text-right">
			   			  		<v-btn color="#4CAF50" dark @click.stop="save"><v-icon style="margin-right: 15px;">mdi-content-save</v-icon>Сохранить</v-btn>
			   			  	</v-card>
						</v-card-text>	   		  
			   		</v-card>
			   	</v-flex>
			   </v-layout>
			</v-container>
		</div>

		<a name="boxes"></a>
		<br />
	</div>
</div>










@include('admin._partials.editors.add_and_edit')
@endsection
@push('scripts')
	<script src="/js/jquery.mask.min.js" type="text/javascript"></script>
	<script src="/js/_partials/editors/add_and_edit.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
	<script>
        var app = new Vue({
            el: '#vueapp',
            data: {
                newItem: {},
            },
            methods: {

            }
        })
    </script>
    <style>
    	.v-input .v-label {
    		left: 15px !important;
    	}
    	.v-input__icon.v-input__icon--prepend {
    		margin-right: 15px !important;
    	}
    </style>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script>
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
					}
				},

				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ?
								i.replace(/[\$,]/g, '')*1 :
								typeof i === 'number' ?
										i : 0;
					};

					// Total over all pages
					total = api
							.column( 4 )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );

					// Total over this page
					pageTotal = api
							.column( 4, { page: 'all', search:'applied'} )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );

					// Update footer
					// pageTotal/100 + '<br><b>' + total/100 + '</b>'
					jQuery( api.column( 4 ).footer() ).html(
							pageTotal
					);

				}




			});


			jQuery('#tableMain tbody').on('click', 'tr', function () {
				var url = jQuery( this ).attr('data-href');
				if (url) {
					document.location = url;
				}
			} );


		} );
	</script>

@endpush