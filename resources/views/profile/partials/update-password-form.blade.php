<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label class="form-label">Current Password</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
