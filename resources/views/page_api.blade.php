<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>API VPN</title>

    <!-- Styles -->
    <style>
        html,
        body {
            margin-left: 15px;
            font-family: source-code-pro,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;
        }

        .line span {
            font-size: .8rem;
            line-height: 1.9;
            display: inline-block;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
@php
    $i = 1;
@endphp
@foreach ($messages as $key => $user)
    @switch($user[0])

        @case("warning")
        @php
            $color = "#FF8E2A"; $text = "WARNING"; $bold = " bold";
        @endphp
        @break

        @case("error")
        @php
            $color = "#FF5572"; $text = "ERROR"; $bold = " bold";
        @endphp
        @break

        @case("infotg")
        @php
            $color = "#565454"; $text = "INFO"; $bold = " bold";
        @endphp
        @break

        @default
        @php
            $color = "#565454"; $text = "INFO"; $bold = "";
        @endphp
    @endswitch

    <div class="line{{ $bold }}"><span style="width:20px;text-align:right;">{{ $key+1 }}</span><span style="color: {{ $color }};width:70px;text-align:center;">{{ $text }}</span><span> {{ $user[1] }}</span></div>
@endforeach

</body>
</html>