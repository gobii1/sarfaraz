<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
