<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?');">
    @csrf
    @method('delete')

    <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data you wish to retain before deleting.</p>

    <button type="submit" class="btn btn-danger">Delete Account</button>
</form>
