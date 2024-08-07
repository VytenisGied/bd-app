<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BirthDay</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            *{
                transition: all 0.6s;
            }

            html {
                height: 100%;
            }

            body{
                font-family: 'Lato', sans-serif;
                background-color: #09090b;
                color: #f59e0b;
                margin: 0;
            }

            #main{
                display: table;
                width: 100%;
                height: 100vh;
                text-align: center;
            }

            .fof{
                display: table-cell;
                vertical-align: middle;
            }

            .fof h1{
                font-size: 50px;
                display: inline-block;
                padding-right: 12px;
                animation: type .5s alternate infinite;
            }

            @keyframes type{
                from{box-shadow: inset -3px 0px 0px #f59e0b;}
                to{box-shadow: inset -3px 0px 0px transparent;}
            }
        </style>
    </head>
    <body>
        <div id="main">
            <div class="fof">
                <h1>{{ $heading }}</h1>
                <h3>{{ $subheading }}</h3>
            </div>
        </div>
    </body>