<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Messages</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
    <style>
        .list-group {
            overflow-y: scroll;
            height: 200px;
        }
    </style>
</head>

<body class="theme-blush font-montserrat theme-blush light_version">
    <div id="wrapper">
        @include('layout.navbar')
        @include('layout.megamenu')
        @include('layout.searchbar')
        @include('layout.rightbar')
        @include('layout.sidebar')
        <div id="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center mmt-5" id="app">
                    <div class="clo-4 mt-5">
                        <ul class="list-group" v-chat-scroll>
                            <li class="list-group-item active">Chat Room</li>
                            <message v-for="value,index in chat.message" :key=value.index :color=chat.color[index]
                                :user=chat.user[index]>@{{value}}
                            </message>
                        </ul>
                        <input type="text" class="form-control" v-model="message" v-on:keyup.enter="send"
                            placeholder="Write Your Message">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>
