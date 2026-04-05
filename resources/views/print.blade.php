<!DOCTYPE html>
<html>
<head>
    <title>Courrier {{ $courrier->reference }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body onload="window.print()">
    <h1>Courrier {{ $courrier->reference }}</h1>
    <p><strong>Objet:</strong> {{ $courrier->objet }}</p>
    <p><strong>Date:</strong> {{ $courrier->date }}</p>
    <p><strong>Type:</strong> {{ $courrier->type }}</p>

    @if($courrier->file)
        <p><strong>PDF attaché:</strong> {{ $courrier->file }}</p>
    @endif
</body>
</html>