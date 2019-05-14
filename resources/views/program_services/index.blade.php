@extends('layouts.members')
@section('content')
<div class="content row text-center w-75 mx-auto">
    <div class="col-12 py-5">
        <span class="h3">Programs</span>
        <div class="row py-4">
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/savings') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-briefcase"></i>
                    </span>
                    <br>Savings
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/financing') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-money-bill-alt"></i>
                    </span>
                    <br>Financing
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/hospitalization') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-hospital" data-fa-transform="shrink-2"></i>
                    </span>
                    <br>Hospitalization
                </a>
            </div>
            <div class="w-100"></div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/education') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-graduation-cap" data-fa-transform="shrink-2"></i>
                    </span>
                    <br>Education
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/franchise') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-star" data-fa-transform="shrink-12 up-8"></i>
                        <i class="fas fa-handshake" data-fa-transform="shrink-4"></i>
                        <i class="fas fa-star" data-fa-transform="shrink-12 down-8"></i>
                    </span>
                    <br>Franchise
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/damayan') }}">
                    <span class="orange bg rounded-circle mb-3 p-5 fa-layers fa-4x fa-inverse">
                        <i class="fas fa-male" data-fa-transform="shrink-2 right-4"></i>
                        <i class="fas fa-male" data-fa-transform="shrink-5 right-7"></i>
                        <i class="fas fa-male"></i>
                        <i class="fas fa-male" data-fa-transform="shrink-2 left-4"></i>
                        <i class="fas fa-male" data-fa-transform="shrink-5 left-7"></i>
                    </span>
                    <br>Damayan
                </a>
            </div>
        </div>
    </div>
    <div class="col-12 py-3">
        <span class="h3">Services Offered</span>
        <div class="row py-4">
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/eHotel') }}">
                    <span class="fa-layers fa-fw fa-4x mb-3">
                    <i class="fas fa-building"></i>
                    <span class="fa-layers-text" data-fa-transform="shrink-12 up-10" style="font-weight:700">HOTEL</span>
                    </span>
                    <br>eHotel
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/eLoading') }}">
                    <span class="fa-layers fa-fw fa-4x mb-3">
                    <i class="fas fa-mobile-alt"></i>
                    <i class="fas fa-wifi" data-fa-transform="shrink-11 up-1"></i>
                    </span>
                    <br>eLoading
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/eTicket') }}">
                    <span class="fa-layers fa-fw fa-4x mb-3">
                    <i class="fas fa-ticket-alt" data-fa-transform="shrink-6 right-11 rotate-20"></i>
                    <i class="fas fa-ship fa-inverse" data-fa-transform="shrink-13 right-11 rotate-20"></i>
                    <i class="fas fa-ticket-alt" data-fa-transform="shrink-4 up-2"></i>
                    <i class="fas fa-plane fa-inverse" data-fa-transform="shrink-13 up-2"></i>
                    <i class="fas fa-ticket-alt" data-fa-transform="shrink-6 left-11 rotate--20"></i>
                    <i class="fas fa-bus fa-inverse" data-fa-transform="shrink-13 left-11 rotate--20"></i>
                    </span>
                    <br>eTicket
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/eTours') }}">
                    <span class="fa-layers fa-fw fa-4x mb-3">
                    <i class="fas fa-suitcase"></i>
                    <i class="fas fa-plane fa-inverse" data-fa-transform="shrink-11 down-2"></i>
                    </span>
                    <br>eTours
                </a>
            </div>
            <div class="col my-4">
                <a class="text-dark" href="{{ URL::to('member/programServices/eCommerce') }}">
                    <span class="fa-layers fa-fw fa-4x mb-3">
                    <i class="fas fa-shopping-bag"></i>
                    <i class="fas fa-globe fa-inverse" data-fa-transform="shrink-9 down-3"></i>
                    </span>
                    <br>eCommerce
                </a>
            </div>
        </div>
    </div>
</div>
@stop