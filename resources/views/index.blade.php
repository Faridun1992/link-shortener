<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Shortener</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<form id="shorten-form">
    @csrf
    <label for="original_url">Ссылка:</label>
    <input type="text" id="original_url" name="original_url" required>
    <button type="submit">сократить</button>
</form>

<div>
    <h2>Последние 10 ссылок:</h2>
    <ul id="shortened-links">
        @foreach ($shortLinks as $shortLink)
            <li><a href="{{$shortLink->original_url}}" target="_blank">{{ $shortLink->short_code }}</a></li>
        @endforeach
    </ul>
</div>

<script>
    $(document).ready(function() {
        $('#shorten-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/shorten',
                data: $(this).serialize(),
                success: function(response) {
                    $('#shortened-links').prepend(`<li><a href=${response.short_link.original_url} target="_blank">${response.short_link.short_code}</a></li>`);
                    $('#shortened-links li:gt(9)').remove();
                    $('#original_url').val('');
                }
            });
        });
    });
</script>

</body>
</html>
