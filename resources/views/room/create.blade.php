<form action="/room/{{ $id }}" method="POST">
{{ csrf_field() }}
<input type="text" name="firstname">
<input type="submit">
</form>