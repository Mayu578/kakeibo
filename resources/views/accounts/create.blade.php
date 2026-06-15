<h1>口座登録</h1>

<form action="{{ route('accounts.store') }}" method="POST">
    @csrf

    <label>口座名</label>
    <input type="text" name="name">

    <label>残高</label>
    <input type="number" name="balance" step="0.01">

    <button type="submit">登録</button>
</form>
