@extends('layouts.app')
@section('content')<h1>Add category</h1><form class="card form-card" method="POST" action="{{ route('categories.store') }}">@csrf<label>Name<input name="name" required></label><label>Description<textarea name="description"></textarea></label><button class="btn-primary">Save category</button></form>@endsection
