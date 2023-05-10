@section('title', 'Партнёры')
@extends('admin.template')

@section('main')





    <div class="page-content-wrapper">
        <div class="page-content">

            <div id="app" style="margin-bottom: 0 !important;">
                <afillater :user_id="{{Auth::id()}}">
            </div>



            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light" id="for-service">
                        {{--
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-trophy font-dark"></i>
                                <span class="caption-subject font-dark sbold uppercase">@lang('afillater.your_personal_link')</span>
                            </div>
                        </div>
                        --}}
                        <div class="portlet-body">


                            <div class="text-center">
                                <span class="personal-link">{{ Config('global.project.url') }}/?ref{{ $referal }}</span><br />

                                <div class="text-center">
                                    <?PHP
                                    use App\Models\Barcode;
                                    $generator = new Barcode();
                                    $param = Config('global.project.url') . "/?ref" . $referal;
                                    $options = Array();
                                    $options['w'] = 250;
                                    $options['h'] = 250;
                                    $options['wq'] = 0;
                                    $result = $generator->output_image("svg", "qr", $param, $options);
                                    echo $result;
                                    ?>
                                </div>
                            </div>



                            <div class="text-center">
                                <a href="#modal-terms" data-toggle="modal">@lang('afillater.read_conditions')</a>
                            </div>



                            <div class="text-center">
                                <style>
                                    .ya-share2__container_size_m .ya-share2__icon {height: 48px; width: 48px;}
                                    .ya-share2__item_service_moimir .ya-share2__badge {margin-bottom: 4px;}
                                </style>
                                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" async="async"></script>
                                <script src="//yastatic.net/share2/share.js" async="async"></script>
                                <h2>@lang('afillater.share_link'):</h2>
                                <div style="margin-top:-25px;">
                                    <div class="ya-share2"
                                         data-services="vkontakte,odnoklassniki,facebook,whatsapp,viber,telegram"
                                         {{--
                                         data-services="collections,vkontakte,facebook,odnoklassniki,moimir,pinterest,twitter,blogger,delicious,digg,reddit,evernote,linkedin,lj,viber,whatsapp,skype,telegram"
                                         --}}
                                         data-image="{{ Config("global.project.url") }}/img_public/ico/02.png"
                                         data-url="{{ Config('global.project.url') }}/?ref{{ $referal }}"
                                         data-title="{{ Config("global.project.sitename") }}"
                                         data-description="{{ Config("global.project.sitedescription") }}"
                                         data-lang="ru"
                                         data-size="m"
                                    ></div>
                                </div>
                                <br /><br />

                            </div>

                        </div><!-- portlet-body -->
                    </div>
                </div>
            </div>




            @include('admin.afillater.afilliate_matrix')







        </div>
    </div>







    <!--{{-- ################ ОКНО УСЛОВИЙ ПРОГРАММЫ ######################### --}}-->
    <div id="modal-terms" class="modal fade in modal-overflow" tabindex="-1" role="basic" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4><b>@lang('afillater.conditions_title')</b></h4>
                </div>
                <div class="modal-body">
                    @lang('afillater.conditions_text')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">@lang('buttons.close')</button>
                </div>
            </div>
        </div>
    </div>

@endsection