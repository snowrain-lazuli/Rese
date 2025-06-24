<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
    /* メール用のインラインスタイル（推奨） */
    body {
        font-family: Arial, sans-serif;
        color: #333;
        line-height: 1.6;
    }
    </style>
</head>

<body>
    <h2>{{ $subjectText }}</h2>
    <p>{!! nl2br(e($bodyText)) !!}</p> {{-- 改行を保持 --}}
</body>

</html>