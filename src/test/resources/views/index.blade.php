<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                font-size: 30px;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .font-sm {
                font-size: 13px;
            }

            .font-md {
                font-size: 30px;
            }

            .links > button {
                color: #636b6f;
                padding: 0 25px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                background-color: white;
                border: none;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .bottom-container {
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">ホーム</a>
                    @else
                        <a href="{{ route('login') }}">ログイン</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">新規登録</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    To Do List
                </div>

                <div class="top-left">
                    {{$group}}
                </div>
                
                <div  class='flex-center'>
                    <table>
                        @foreach($todos as $todo)
                        @if (!$todo->done)
                        <tr>
                        <th><div class='links font-md'><a href='/todolists/{{$todo->id}}'>{{$todo->title}}</a></div></th>
                        <th>
                            <div>
                                <form method='post' action='/todolists/{{$todo->id}}' >
                                @csrf <!-- CSRF対策 -->
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="done" type="hidden" value='true'>
                                    <div class='links'>
                                        <button type='submit' class='font-md'>Done
                                    </div>
                                </form>
                            </div>
                        </th>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                </div>

                <div class='bottom-container'>
                    <div class='links font-sm'>
                        <a href='/todolists/create'>新規作成</a>
                    </div>
                </div>
                <div class='bottom-container'>
                    <div class='links font-sm'>
                        <a href='/tags/create'>タグ作成</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
