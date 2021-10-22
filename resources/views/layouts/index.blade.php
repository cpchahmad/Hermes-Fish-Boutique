<html>
<head>
    <title>Hermes Fish Boutique</title>
    <link rel="stylesheet" href="{{ asset('polished.min.css')}}">
    <link rel="stylesheet" href="{{ asset('orders.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        hr {
            margin: 2rem 0;
        }
        .main-div{
            position: relative;
        }
        .order-for-checkout{
            position: absolute;
            top: 0;
            right: 0;
            background-color: #afdf3b;
            min-width: 20px;
            text-align: center;
            border-radius: 50%;
        }
    </style>
</head>

<body>

<nav class="navbar bg-primary-darkest navbar-expand p-0">
    <a class="navbar-brand text-center col-xs-12 col-md-3 col-lg-2 mr-0" href="{{route('home')}}">
         Fish Boutique</a>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('home') }}">Orders</a>
        </li>

        <li class="nav-item">
            <div class="main-div">
            <div><a class="nav-link text-white" href="{{ route('checkout.orders') }}">Checkout Orders</a></div>
            <span class="order-for-checkout" aria-hidden="true">@if(isset($notification) && $notification > 0){{$notification}} @endif</span>
            </div>
        </li>
        {{--        <li class="nav-item">--}}
{{--            <a class="nav-link text-white" href="{{ route('board.color.all') }}">Colors</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link text-white" href="{{ route('board.font.all') }}">Fonts</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link text-white" href="{{ route('board.options') }}">Options</a>--}}
{{--        </li>--}}
    </ul>
</nav>

<div class="container-fluid h-100 p-0">
    <div style="min-height: 100%" class="flex-row d-flex">
        <div class="col-lg-12 col-md-12 pl-5 pt-3 pr-5">
{{--            @include('layouts.flash_message')--}}
            @yield('content')
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

@if(\Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_enabled'))
    <script src="https://unpkg.com/@shopify/app-bridge{{ \Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
    <script src="https://unpkg.com/@shopify/app-bridge-utils{{ \Osiset\ShopifyApp\Util::getShopifyConfig('appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
    <script
        @if(\Osiset\ShopifyApp\Util::getShopifyConfig('turbo_enabled'))
        data-turbolinks-eval="false"
        @endif
    >
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var utils = window['app-bridge-utils'];
        var createApp = AppBridge.default;
        var app = createApp({
            apiKey: "{{ \Osiset\ShopifyApp\Util::getShopifyConfig('api_key', $shopDomain ?? Auth::user()->name ) }}",
            shopOrigin: "{{ $shopDomain ?? Auth::user()->name }}",
            host: "{{ \Request::get('host') }}",
            forceRedirect: true,
        });
    </script>

    @include('shopify-app::partials.token_handler')
    @include('shopify-app::partials.flash_messages')
@endif

@yield('scripts')

</body>

</html>
