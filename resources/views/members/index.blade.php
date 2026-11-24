@extends('layouts.app')

@section('content')

<div class="page-head">
    <div>
        <p class="eyebrow">Member directory</p>
        <h1>Members</h1>
        <p class="muted">
            Manage registered members and their membership status.
        </p>
    </div>

    <a class="btn-primary" href="{{ route('members.create') }}">
        + Add Member
    </a>
</div>

<form class="search" method="GET" action="{{ route('members.index') }}">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search by name, category, level, or membership number"
    >

    <button class="btn-primary" type="submit">
        Search
    </button>
</form>

<section class="card">
    <table>
        <thead>
            <tr>
                <th>Membership No.</th>
                <th>Name</th>
                <th>Category</th>
                <th>Level</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>
                        {{ $member->membership_number }}
                    </td>

                    <td>
                        {{ $member->full_name }}
                    </td>

                    <td>
                        {{ $member->category->name }}
                    </td>

                    <td>
                        {{ $member->level->name }}
                    </td>

                    <td>
                        @if ($member->status === 'active')
                            <span class="badge badge-approved">
                                Active
                            </span>
                        @else
                            <span class="badge badge-cancelled">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('members.show', $member) }}">
                            View
                        </a>

                        @if ($member->status === 'active')
                            <form
                                method="POST"
                                action="{{ route('members.destroy', $member) }}"
                                style="display: inline;"
                                onsubmit="return confirm('Deactivate this member?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="danger-link">
                                    Deactivate
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">
                        No members found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $members->links() }}
</section>

@endsection