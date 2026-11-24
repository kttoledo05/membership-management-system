@extends('layouts.app')

@section('content')

<div class="page-head">
    <div>
        <p class="eyebrow">Member management</p>
        <h1>Edit Member</h1>
        <p class="muted">
            Update the member's information.
        </p>
    </div>

    <a class="btn-primary" href="{{ route('members.show', $member) }}">
        Back to Profile
    </a>
</div>

<form class="form-card"
      method="POST"
      action="{{ route('members.update', $member) }}">

    @csrf
    @method('PUT')

    @include('members.form')

    <button class="btn-primary" type="submit">
        Update Member
    </button>

</form>

@endsection