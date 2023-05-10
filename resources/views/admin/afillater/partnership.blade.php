@section('title', 'Мои друзья')
@extends('admin.template')

@section('main')





    <div class="page-content-wrapper">
        <div class="page-content">



            @include('admin.afillater.afilliate_matrix')



            {{--
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light note note-danger" id="for-service">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-link font-red-mint"></i>
                                <span class="caption-subject font-red-mint sbold uppercase">Получай до 10% ОТ ПРИГЛАШЁННЫХ ТОБОЙ ДРУЗЕЙ</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>
                                Пригласи своих друзей, опубликуй ссылку в своих соцсетях, да и просто отправь её всем знакомым -
                                и ты будешь получать доход от их платежей. Всегда. Пожизненно.
                            </p>
                            <br>

                            <div class="text-center">
                                <a href="/admin/afillater/invite"class="btn btn-lg btn-lgg btn-primary">
                                    <i class="icon-arrow-right"></i>&nbsp;&nbsp;ПРИГЛАСИТЬ ДРУГА!
                                </a>
                            </div>

                        </div><!-- portlet-body -->
                    </div>
                </div>
            </div>
            --}}




        </div>
    </div>



@endsection