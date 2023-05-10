@extends('layouts.main_blog')

@section("title", "Блог - Национальная Аграрная Тендерная Система (НАТС)")

@section('content')
    






<main class="v-main" style="padding: 50px 0px 350px;" data-booted="true">
    <div class="v-main__wrap">
        <div class="container container--fluid grid-list-lg">
            <div class="layout row wrap">
                <div class="flex md12 xs12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-title">
                                    <h2>Блог</h2>
                                </div>
                            </div>




                        @foreach($news as $new)

                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/{{$new->slug}}" class="post-img">
                                        <img src="{{isset($new->image)?$new->image:'/img/no-image.jpg'}}"
                                             alt="{{$new->title}}"
                                             title="{{$new->title}}"
                                             style="width: 100%;" 
                                            ></a>
                                    </a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">{{$new->created_formated}}</span></div>
                                        <h3 class="post-title"><a href="/news/{{$new->slug}}">{{$new->title}}</a></h3>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach




                            <!--<div class="col-md-3">
                                <div class="post">
                                    <a href="/news/osobennosty-torhovoi-ploshchadky-dlia-selskoho-khoziaistva" class="post-img"><img src="/storage/uploads/Claas_Lexion_560.jpg" title="Особенности торговой площадки для сельского хозяйства" alt="Особенности торговой площадки для сельского хозяйства"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">12.08.2022 14:37</span></div>
                                        <h3 class="post-title"><a href="/news/osobennosty-torhovoi-ploshchadky-dlia-selskoho-khoziaistva">Особенности торговой площадки для сельского хозяйства</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/torhovaia-ploshchadka-dlia-ahrokholdynha" class="post-img"><img src="/storage/uploads/ecommerce-1-104831.jpg" title="Торговая площадка для агрохолдинга" alt="Торговая площадка для агрохолдинга"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">12.08.2022 14:30</span></div>
                                        <h3 class="post-title"><a href="/news/torhovaia-ploshchadka-dlia-ahrokholdynha">Торговая площадка для агрохолдинга</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/kak-rabotaet-auktsyon-selkhoztekhnyky" class="post-img"><img src="/storage/uploads/3b94vpftoy2o8888ow804ogk0kgc8c.jpg" title="Как работает аукцион сельхозтехники" alt="Как работает аукцион сельхозтехники"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">12.08.2022 13:54</span></div>
                                        <h3 class="post-title"><a href="/news/kak-rabotaet-auktsyon-selkhoztekhnyky">Как работает аукцион сельхозтехники</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/torgovye-ploshchadki-v-internete" class="post-img"><img src="/storage/uploads/56e1a6b2ef562b2c9320488c64185d91.png" title="Торговые площадки в интернете" alt="Торговые площадки в интернете"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 14:03</span></div>
                                        <h3 class="post-title"><a href="/news/torgovye-ploshchadki-v-internete">Торговые площадки в интернете</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/raznovidnosti-funkcii-i-preimushchestva-ehlektronnyh-ploshchadok" class="post-img"><img src="/storage/uploads/5d4296028a68b.png" title="Разновидности, функции и преимущества электронных площадок" alt="Разновидности, функции и преимущества электронных площадок"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 13:47</span></div>
                                        <h3 class="post-title"><a href="/news/raznovidnosti-funkcii-i-preimushchestva-ehlektronnyh-ploshchadok">Разновидности, функции и преимущества электронных площадок</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/princip-raboty-i-preimushchestva-torgovyh-ploshchadok" class="post-img"><img src="/storage/uploads/276807.jpg" title="Принцип работы и преимущества торговых площадок" alt="Принцип работы и преимущества торговых площадок"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 13:44</span></div>
                                        <h3 class="post-title"><a href="/news/princip-raboty-i-preimushchestva-torgovyh-ploshchadok">Принцип работы и преимущества торговых площадок</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/tender-ehlektronnaya-torgovaya-ploshchadka" class="post-img"><img src="/storage/uploads/perechen-elektronnyh-torgovyh-ploshhadok-1.png" title="Тендер электронная торговая площадка" alt="Тендер электронная торговая площадка"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 13:42</span></div>
                                        <h3 class="post-title"><a href="/news/tender-ehlektronnaya-torgovaya-ploshchadka">Тендер электронная торговая площадка</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/sajt-ehlektronnoj-torgovoj-ploshchadki" class="post-img"><img src="/storage/uploads/18.jpg" title="Сайт электронной торговой площадки" alt="Сайт электронной торговой площадки"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 13:33</span></div>
                                        <h3 class="post-title"><a href="/news/sajt-ehlektronnoj-torgovoj-ploshchadki">Сайт электронной торговой площадки</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/onlajn-torgovye-ploshchadki" class="post-img"><img src="/storage/uploads/Без названия.jpg" title="Онлайн торговые площадки" alt="Онлайн торговые площадки"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">18.07.2022 13:31</span></div>
                                        <h3 class="post-title"><a href="/news/onlajn-torgovye-ploshchadki">Онлайн торговые площадки</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/chem-udivil-den-voronezhskogo-polya-2022" class="post-img"><img src="/storage/uploads/LbT8gu6Hac8.jpg" title="Чем удивил «День Воронежского Поля 2022»?" alt="Чем удивил «День Воронежского Поля 2022»?"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">21.06.2022 11:32</span></div>
                                        <h3 class="post-title"><a href="/news/chem-udivil-den-voronezhskogo-polya-2022">Чем удивил «День Воронежского Поля 2022»?</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/vystavka-demonstraciya-dostizhenij-v-apk-den-voronezhskogo-polya-2022" class="post-img"><img src="/storage/uploads/aP2cb9adKkc.jpg" title="Выставка-демонстрация достижений в АПК «День Воронежского Поля 2022»" alt="Выставка-демонстрация достижений в АПК «День Воронежского Поля 2022»"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">17.06.2022 09:57</span></div>
                                        <h3 class="post-title"><a href="/news/vystavka-demonstraciya-dostizhenij-v-apk-den-voronezhskogo-polya-2022">Выставка-демонстрация достижений в АПК «День Воронежского Поля 2022»</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/podrobnee-pro-himicheskie-sredstva-zashchity-rastenij" class="post-img"><img src="/storage/uploads/obpryskuvannya.jpg" title="Подробнее про химические средства защиты растений" alt="Подробнее про химические средства защиты растений"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:20</span></div>
                                        <h3 class="post-title"><a href="/news/podrobnee-pro-himicheskie-sredstva-zashchity-rastenij">Подробнее про химические средства защиты растений</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/dlya-chego-nuzhny-tendery-v-selskohozyajstvennoj-sfere" class="post-img"><img src="/storage/uploads/сельское-хозяйство.jpg" title="Для чего нужны тендеры в сельскохозяйственной сфере" alt="Для чего нужны тендеры в сельскохозяйственной сфере"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:18</span></div>
                                        <h3 class="post-title"><a href="/news/dlya-chego-nuzhny-tendery-v-selskohozyajstvennoj-sfere">Для чего нужны тендеры в сельскохозяйственной сфере</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/osobennosti-i-princip-provedeniya-tendernyh-zakupok" class="post-img"><img src="/storage/uploads/1-1.jpg" title="Особенности и принцип проведения тендерных закупок" alt="Особенности и принцип проведения тендерных закупок"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:15</span></div>
                                        <h3 class="post-title"><a href="/news/osobennosti-i-princip-provedeniya-tendernyh-zakupok">Особенности и принцип проведения тендерных закупок</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/kak-rabotaet-torgovaya-ploshchadka" class="post-img"><img src="/storage/uploads/marketplace-3.jpg" title="Как работает торговая площадка" alt="Как работает торговая площадка"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:13</span></div>
                                        <h3 class="post-title"><a href="/news/kak-rabotaet-torgovaya-ploshchadka">Как работает торговая площадка</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/dlya-chego-ispolzuyut-pesticidy" class="post-img"><img src="/storage/uploads/Без названия.jpg" title="Для чего используют пестициды" alt="Для чего используют пестициды"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:10</span></div>
                                        <h3 class="post-title"><a href="/news/dlya-chego-ispolzuyut-pesticidy">Для чего используют пестициды</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/insekticidy-i-pesticidy" class="post-img"><img src="/storage/uploads/1.jpg" title="Инсектициды и пестициды" alt="Инсектициды и пестициды"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:07</span></div>
                                        <h3 class="post-title"><a href="/news/insekticidy-i-pesticidy">Инсектициды и пестициды</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/gerbicidy-dlya-udaleniya-sornyakov" class="post-img"><img src="/storage/uploads/111_0--002.jpg" title="Гербициды для удаления сорняков." alt="Гербициды для удаления сорняков."></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:05</span></div>
                                        <h3 class="post-title"><a href="/news/gerbicidy-dlya-udaleniya-sornyakov">Гербициды для удаления сорняков.</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/onlajn-torgi-v-selskohozyajstvennoj-sfere" class="post-img"><img src="/storage/uploads/sez-full.jpg" title="Онлайн торги в сельскохозяйственной сфере" alt="Онлайн торги в сельскохозяйственной сфере"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">27.04.2022 15:04</span></div>
                                        <h3 class="post-title"><a href="/news/onlajn-torgi-v-selskohozyajstvennoj-sfere">Онлайн торги в сельскохозяйственной сфере</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/sredstva-zashchity-rastenij" class="post-img"><img src="/storage/uploads/1562318213.jpg" title="Средства защиты растений" alt="Средства защиты растений"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">25.03.2022 19:35</span></div>
                                        <h3 class="post-title"><a href="/news/sredstva-zashchity-rastenij">Средства защиты растений</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/budushchee-rossijskih-ferm-prognoz-na-20-let" class="post-img"><img src="/storage/uploads/тенденции_Монтажная область 1.jpg" title="Будущее российских ферм: прогноз на 20 лет" alt="Будущее российских ферм: прогноз на 20 лет"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">19.01.2022 15:40</span></div>
                                        <h3 class="post-title"><a href="/news/budushchee-rossijskih-ferm-prognoz-na-20-let">Будущее российских ферм: прогноз на 20 лет</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/minselhoz-rf-otkazalsya-ot-planov-po-izmeneniyu-uslovij-lgotnogo-kreditovaniya-apk" class="post-img"><img src="/storage/uploads/14.01-1.jpg" title="Минсельхоз РФ отказался от планов по изменению условий льготного кредитования АПК" alt="Минсельхоз РФ отказался от планов по изменению условий льготного кредитования АПК"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">14.01.2022 16:33</span></div>
                                        <h3 class="post-title"><a href="/news/minselhoz-rf-otkazalsya-ot-planov-po-izmeneniyu-uslovij-lgotnogo-kreditovaniya-apk">Минсельхоз РФ отказался от планов по изменению условий льготного кредитования АПК</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/s-12-yanvarya-ehksportnaya-poshlina-na-pshenicu-povyshaetsya-do-98-2-za-tonnu" class="post-img"><img src="/storage/uploads/14.01.jpg" title="С 12 января экспортная пошлина на пшеницу повышается до $98,2 за тонну" alt="С 12 января экспортная пошлина на пшеницу повышается до $98,2 за тонну"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">14.01.2022 16:24</span></div>
                                        <h3 class="post-title"><a href="/news/s-12-yanvarya-ehksportnaya-poshlina-na-pshenicu-povyshaetsya-do-98-2-za-tonnu">С 12 января экспортная пошлина на пшеницу повышается до $98,2 за тонну</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/s-nastupayushchim-novym-godom-i-rozhdestvom" class="post-img"><img src="/storage/uploads/с новым годом для инсты 2022_Монтажная область 1.jpg" title="С наступающим Новым годом и Рождеством!" alt="С наступающим Новым годом и Рождеством!"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">29.12.2021 11:08</span></div>
                                        <h3 class="post-title"><a href="/news/s-nastupayushchim-novym-godom-i-rozhdestvom">С наступающим Новым годом и Рождеством!</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/pravitelstvo-utverdilo-subsidirovaniya-proizvoditelej-selhoztekhniki" class="post-img"><img src="/storage/uploads/техника субсидии.jpg" title="Правительство утвердило субсидирования производителей сельхозтехники" alt="Правительство утвердило субсидирования производителей сельхозтехники"></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">22.12.2021 14:09</span></div>
                                        <h3 class="post-title"><a href="/news/pravitelstvo-utverdilo-subsidirovaniya-proizvoditelej-selhoztekhniki">Правительство утвердило субсидирования производителей сельхозтехники</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/s-tochnostyu-do-millilitra-kak-zashchitit-selhozkultury-bez-poter" class="post-img"><img src="/storage/uploads/Банер Миксмэйт.png" title="С точностью до миллилитра. Как защитить сельхозкультуры без потерь." alt="С точностью до миллилитра. Как защитить сельхозкультуры без потерь."></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">22.12.2021 08:34</span></div>
                                        <h3 class="post-title"><a href="/news/s-tochnostyu-do-millilitra-kak-zashchitit-selhozkultury-bez-poter">С точностью до миллилитра. Как защитить сельхозкультуры без потерь.</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="post">
                                    <a href="/news/povyshenie-ehffektivnosti-vedeniya-biznesa-za-schet-vnedreniya-peredovyh-upravlencheskih-reshenij" class="post-img"><img src="/storage/uploads/рекламный.jpg" title="Повышение эффективности ведения бизнеса за счет внедрения передовых управленческих решений." alt="Повышение эффективности ведения бизнеса за счет внедрения передовых управленческих решений."></a> 
                                    <div class="post-body">
                                        <div class="post-meta"><span class="post-date">21.12.2021 23:04</span></div>
                                        <h3 class="post-title"><a href="/news/povyshenie-ehffektivnosti-vedeniya-biznesa-za-schet-vnedreniya-peredovyh-upravlencheskih-reshenij">Повышение эффективности ведения бизнеса за счет внедрения передовых управленческих решений.</a></h3>
                                    </div>
                                </div>
                            </div>-->





                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>






@endsection

