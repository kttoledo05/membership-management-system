@extends('layouts.app')

@section('content')

<div class="page-head">
    <div>
        <p class="eyebrow">Member management</p>
        <h1>Register Member</h1>
        <p class="muted">
            Add a new member to the membership system.
        </p>
    </div>

    <a class="btn-primary" href="{{ route('members.index') }}">
        Back to Members
    </a>
</div>

<form class="form-card"
      method="POST"
      action="{{ route('members.store') }}">

    @csrf

    @include('members.form')

    <button class="btn-primary" type="submit">
        Save Member
    </button>

</form>

@endsection