<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Isabela State University | Sentiment Analysis</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var _token = $('meta[name=csrf-token').attr('content');

        function loader()
        {
            document.getElementById('loader').style.display = 'block';
        }

        function loaderx()
        {
            document.getElementById('loader').style.display = 'none';
        }

        function alert(type, message)
        {
            var title = type.toUpperCase()+'!';
            Swal.fire({
                //position: 'top',
                icon: type,
                title: title,
                html: message,
                showConfirmButton: true,
            });
        }

        function view(){
            var route = $('#view-route').val();
            if(route !== '#') {
                $.ajax({
                    url:route,
                    method:'POST',
                    data:{
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType:'json',
                    success:function(response){
                        $('#records-container').html(response.html);
                    }
                });
            }
        }

        function remove(id){
            var route = $('#delete-route').val();
            if(route !== '#') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Once submitted, you will not be able to undo this.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:route,
                            method:'POST',
                            data:{
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id:id
                            },
                            dataType:'json',
                            success:function(response){
                                if(response.success) {
                                    alert('success', response.success);
                                    view();
                                } else {
                                    alert('error', response.error);
                                }
                            }
                        });
                    }
                });
            }
        }

        function reset(form){
            $(form)[0].reset();
            $('.modal-title').html('ADD NEW RECORD');
        }

        $(function(){
            $('#simple').DataTable();
            $('#custom').DataTable({
                ordering:false,
                info:false,
                paging:false
            });
            $('.select2').select2({
                dropdownParent: $("#modal"),
                width: 'resolve',
                theme: "classic",
            });

            view();

            $(document).on('click', '.delete', function(){
                var id = $(this).data('id');
                remove(id);
            });

            $(document).on('click', '.edit', function(){
                var data = $(this).data();
                $.each(data, function(key, value) {
                    $('#'+key).val(value);
                });
                $('.add-new').trigger('click');
                $('.modal-title').html('UPDATE RECORD');
            });

            $(document).on('click', '.close', function(){
                reset('#form');
            });

            $(document).on('submit', '#form', function(e){
                e.preventDefault();
                var route = $('#save-route').val();
                if(route !== '#') {
                    $.ajax({
                        url:route,
                        type:'POST',
                        data: new FormData(this),
                        contentType:false,
                        cache:false,
                        processData:false,
                        dataType:'json',
                        beforeSend:function(){
                            loader();
                            $('#modal').addClass('d-none'); 
                            $('.modal-backdrop').addClass('d-none');
                        },
                        success:function(response){
                            loaderx();
                            $('#modal').removeClass('d-none');
                            $('.modal-backdrop').removeClass('d-none'); 
                            if(response.success) {
                                view();
                                reset('#form');
                                alert('success', response.success);
                                //$('.close').trigger('click');
                            } else {
                                alert('error', response.error);
                            }
                        },
                        error:function(data){
                            loaderx();
                            $('#modal').removeClass('d-none');
                            $('.modal-backdrop').removeClass('d-none');
                            console.log(data);
                            var message = "";
                            var errors = data.responseJSON;
                            $.each( errors.errors, function(key, value) {
                                message += '<li>'+ value +'</li>';
                            });
                            alert('error', message);
                        }   
                    });
                }
            });
        });
    </script>
    @guest
        <style>
            /* body{
                background: url('{{asset("images/logo.png")}}') no-repeat center center fixed  #eee; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                background-size:500px;
            } */
            label {
                color:#555 !important;
                font-weight:bold;
            }
            .address, .email, .contact{
                line-height:0.5 !important;
                padding:0 !important;
            }
            .email, .contact{
                font-size:11px;
                font-weight:bold;
            }
            .address{
                font-size:13px;
            }
            .name{
                font-size:20px;
                font-weight:bold;
            }
            .index-body{
                border-bottom:2px solid #005F33 !important;
                cursor:pointer;
                padding:10px;
            }
            .index-body:hover{
                background:#eee;
                color:#000;
                border-radius:15px;
                box-shadow:0 1px 15px 0 #ccc;
            }
        </style>
    @else
        <style>
            .dashboard img{
                opacity:0.4;
                width:auto;
            }
            .container-theme{
                border:1px solid #eee;
                border-radius:10px;
                padding:20px;
                box-shadow:0 0 15px 1px #ddd;
            }
            .form-floating input, textarea{
                font-size:14px !important;
                border:1px solid #ddd;
                font-weight:bold;
            }
            .form-floating label{
                font-size:13px;
                color: #333;
                font-weight:normal !important;
            }
            .form-floating label i{
                font-weight:normal !important;
                font-size:12px;
            }
            .required{
                color:red;
                font-weight:bold !important;
            }

            .fixed-button{
                position:fixed;
                bottom:0;
                right:0;
                margin: 0 40px 40px 0;
                border-radius:50%;
                border:1px solid #aaa;
                padding:14px 20px;
                font-size:20px;
                box-shadow:0 0 15px 1px #aaa;
            }
            #loader{
                background:rgb(0,0,0,0.2);
                padding-top:20px;
            }
            #loader .w3-modal-content p{
                position:relative;
                z-index:99999999 !important;
            }

            .swal2-container, .swal2-popup{
                padding:0 0 20px 0 !important;
                font-size:12px !important;
            }
            textarea{
                height:150px !important;
                resize:none;
            }
            .controls a{
                text-decoration:none !important;
                font-size:15px;
            }
            .controls a .fa-edit{
                color:#FFCC06;
                margin-right:10px;
            }
            .controls a .fa-trash{
                color:#EC1D24;
            }
            .modal-title{
                font-weight:bold !important;
            }
            #custom_wrapper #custom_filter{
                float:left !important;
                margin-bottom:20px;
            }
            table thead tr th{
                border-bottom:3px solid #005F33 !important;
            }
            .nav-link{
                text-transform:uppercase !important;
                font-weight:bold;
            }
            .nav-item i{
                color:#005F33;
                text-shadow:1px 1px #eee;
            }
            header{
                font-size:25px;
                font-weight:bold;
                margin:0 0 20px 0;
                padding:0 0 10px 20px;
                border-bottom: 1px solid #005F33;
            }
            .uppercase{
                text-transform:uppercase !important;
            }
            .float-left{
                float:left !important;
            }

            @media only screen and (max-width:600px) {
                .container-theme{
                    width:100% !important;
                    overflow-x:scroll;
                    overflow-y:hidden;
                    font-size:12px;
                }
                .container-theme #records-container{
                    width:800px;
                }
                main, .main{
                    padding:0;
                }
            }
        </style>
    @endguest
    <style>
        .bold{
            font-weight:bold !important;
        }
        .nav-item a{
            margin:0 4px;
        }
        .nav-item a:hover{
            /* background:#ddd; */
            border-bottom: 3px solid #005F33;
        }
        .theme{
            background:#005F33 !important;
            color:#FFF !important;
        }
        .color-theme{
            color:#005F33 !important;
        }
        .text-right{
            text-align:right !important;
        }
        .radio{
            width:50px;
            padding:20px !important;
        }
        a{
            text-decoration:none;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container-fluid p-0 px-3">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{asset('images/logo.png')}}" style="width:40px;" alt="LOGO">
                    ISU | Sentiment Analysis
                </a>
                <button class="navbar-toggler mt-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item bold">
                                    <a class="nav-link" href="/campuses">
                                        <i class="fa fa-list color-theme"></i> Answer survey!
                                    </a>
                                </li>
                                <li class="nav-item pt-2">
                                    |
                                </li>
                                <li class="nav-item bold">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fa fa-lock color-theme"></i> Login
                                    </a>
                                </li>
                                <li style="width:150px;">

                                </li>
                            @endif
                        @else
                            @if(Auth::user()->user_type == \App\Models\User::TYPE_SUPER_ADMIN)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Settings <i class="fa fa-cog"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end small p-0 border shadow-lg" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item m-0" href="/settings/users">
                                        <i class="fa fa-users"></i> Users
                                    </a>
                                    <a class="dropdown-item m-0" href="/settings/campuses">
                                        <i class="fa fa-map-marked-alt"></i> Campuses
                                    </a>
                                    <hr class="my-0 border-dark">
                                    <a class="dropdown-item py-3 m-0" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out-alt"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @elseif(Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                                <li class="nav-item small">
                                    <a class="nav-link" href="/admin/questions">SURVEY QUESTIONNAIRES</a>
                                </li>
                                <li class="nav-item small">
                                    <a class="nav-link" href="/admin/answers">MANAGE ANSWERS</a>
                                </li>
                                <li class="nav-item small">
                                    <a class="nav-link" href="/admin/offices">OFFICES</a>
                                </li>
                                <li class="nav-item small">
                                    <a class="nav-link" href="/admin/courses">COURSES</a>
                                </li>
                                <li class="nav-item small">
                                    <a class="nav-link" href="/admin/colleges">COLLEGES</a>
                                </li>
                                <li class="nav-item dropdown small">
                                    <a id="navbarDropdown" 
                                        class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="text-transform:initial !important;">
                                         <i class="fa fa-user"></i> {{ucwords(Auth::user()->name)}}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end small p-0 border shadow-lg" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item m-0" href="/admin/setting">
                                            <i class="fa fa-wrench"></i> Settings
                                        </a>
                                        <a class="dropdown-item m-0 py-3" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out-alt"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="w3-modal" id="loader">
            <div class="w3-modal-content w-25 w3-transparent">
                <center>
                    <p class="alert alert-warning p-0 shadow-lg">
                        <b>Processing...</b>
                    </p>
                </center>
            </div>
        </div>
        <main class="py-4 mb-5 pb-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
