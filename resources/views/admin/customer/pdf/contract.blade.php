<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Акт об оказании услуг</title>
</head>
<body>
    <img src="{{asset('images/header.jpg')}}" height="172px">
    <section id="main" style="padding: 10px 60px 20px 40px;">
        <h5 class="text-center contract-title">
            Договор  № {{$data['customer']['contract_number']}}
            <br />
            об оказании платных услуг
        </h5>
        <div style="width:50%; float: left;">
            <h5>г. Казань</h5>
        </div>
        <div style="width:50%; float: right; text-align: right;">
            <h5>{{$data['contract_date']}}</h5>
        </div>
        <div >
            <p>
                <span>ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "________"</span> именуемое в дальнейшем «Исполнитель», в лице <span>Исполнительного Директора БЕЛОВА ДМИТРИЯ АНДРЕЕВИЧА</span>, действующего на основании <span>Доверенности от 01.08.2020 г.</span>, с одной стороны, и <span style="text-transform: uppercase;">{{$data['customer']['full_name']}}</span> именуемый(ая) в дальнейшем «Заказчик», действующий в интересах несовершеннолетнего <span style="text-transform: uppercase;">{{$data['customer']['child_full_name']}}</span> «Потребитель», с другой стороны, заключили настоящий Договор о нижеследующем:
            </p>
        </div>
        <div>
            <h5 class="text-center">1. Предмет Договора</h5>
            <p>
                1.1.    Исполнитель предоставляет услуги, наименование, количество и график обучения которых определены в Приложении № 1 к настоящему Договору, являющегося неотъемлемой его частью, а Заказчик оплачивает услуги согласно раздела 2 настоящего Договора;
            </p>
            <p>
                1.2.    Услуги, оказываемые Исполнителем Заказчику, в соответствии с п. 1.1. настоящего Договора лицензированию не подлежат, поскольку не указаны в законодательстве в числе лицензируемых видов деятельности. В связи с чем Исполнитель информирует Заказчика о невозможности возмещения НДФЛ за услуги, оказываемые Исполнителем Заказчику.
            </p>
        </div>
        <div>
            <h5 class="text-center">2. Цена Договора</h5>
            <p>2.1. Стоимость оказываемых услуг   составляет {{$data['total_amount']}} рублей 00 копеек;</p>
            <p>2.2. Оплата услуг производится единовременным платежом за весь период обучения или в рассрочку, согласно графику платежей, указанному в п.2.3. настоящего Договора;</p>
            <p>2.3. Оплата услуг Исполнителя производится Заказчиком в соответствии с графиком платежей:</p>
            <p>2.4. Заказчик вправе погасить платежи досрочно.</p>
        </div>
        <div>
            <h5 class="text-center">3. Порядок оказания услуг</h5>
            <p>3.1.  Исполнитель обеспечивает проведение занятий по дисциплинам и в соответствии с графиком занятий, указанным в Приложении №1 к Договору. Длительность одного занятия составляет 45 минут;</p>
        </div>
        <div>
            <h5 class="text-center">4. Обязанности сторон</h5>
            <p>4.1. Обязанности Исполнителя: </p>
            <p>4.1.1. При выполнении Заказчиком условий, предусмотренных разделом 2 настоящего Договора (оплата услуг), зачислить Потребителя;</p>
            <p>4.1.2. Обеспечить проведение учебных занятий для Потребителя в соответствии с Приложением №1 к Договору и расписанием занятий, размещенным на сайте agtender.com;</p>
        </div>
    </section>
</body>
<style>
    table {
        width: 100%; /* Ширина таблицы */
        border-collapse: collapse; /* Убираем двойные линии между ячейками */
    }
    td, th {
        padding: 3px; /* Поля вокруг содержимого таблицы */
        border: 1px solid black; /* Параметры рамки */
    }
    th {
        background: #fdfdfd; /* Цвет фона */
        font-weight: 400;
        font-size: 14px;
    }
    td {
        font-weight: 400;
        font-size: 12px;
    }
    html {
        margin: 0;
        padding: 0;
    }
    body {
        font-family: DejaVu Sans, Helvetica, sans-serif !important;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-size: 14px;
    }
    footer { 
        position: fixed; 
        bottom: 60px; 
        font-size: 16px; 
        text-align: center; 
        line-height: 18px; 
    }
    h1 {
        font-size: 20px;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 30px;
        color: #333;
    }
    .contract-title {
        font-weight: 600;
        line-height: 24px;
    }
    p { 
        font-size: 12px;
        text-indent: 1.5em; /* Отступ первой строки */
        text-align: justify; /* Выравнивание по ширине */
    }
    .subtitle {
        color: #777;
    }
    .caption {
        font-size: 12px;
        color: #777;
    }
    .my-2 {
        margin-bottom: 15px;
        margin-top: 15px;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
</style>
</html>