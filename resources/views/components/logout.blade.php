<form action="/admin/logout" method="POST" accept-charset="utf-8">
    @csrf
    <button {{ $attributes }} type="submit">Logout</button>
</form>