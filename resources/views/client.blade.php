<!DOCTYPE html>
<html>
    <head></head>
    <body>
        @foreach ($clients as $item)
            <p>{{ $item->name }}</p>
        @endforeach
    </body>
</html>