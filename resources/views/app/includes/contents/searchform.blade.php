<form action="{{ route('searchsuya') }}" role="search">
    <div class="input-field">
        <input name = "query" id="query" type="search" class="search" required>
        <label for="search">
            <i class="material-icons teal-text text-lighten-2">search</i>
        </label>
        <button type="submit" style="display:none;" name="search">search</button>
        <i class="material-icons">close</i>
    </div>
</form>