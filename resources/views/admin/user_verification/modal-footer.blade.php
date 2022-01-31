<a class="btn btn-danger" data-dismiss="modal" data-toggle="modal" href="#rejectModal">Reject</a>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<form action="{{route('user.verification.accept')}}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="profile_id" value="{{$profile->id}}">
    <button type="submit" class="btn btn-success">Accept</button>
</form>
