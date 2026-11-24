@extends('layouts.app')

@section('content')
<div class="page-head">
    <div>
        <p class="eyebrow">Transaction processing</p>
        <h1>Edit transaction</h1>
    </div>
    <a class="btn-primary" href="{{ route('transactions.show', $transaction) }}">Back to details</a>
</div>

<form class="form-card" method="POST" action="{{ route('transactions.update', $transaction) }}">
    @csrf
    @method('PUT')

    <div class="form-grid">
        <label>
            Member
            <select name="member_id" required>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected($transaction->member_id == $member->id)>
                        {{ $member->full_name }} - {{ $member->membership_number }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>
            Transaction type
            <select name="type" required>
                <option value="application" @selected($transaction->type === 'application')>Application</option>
                <option value="renewal" @selected($transaction->type === 'renewal')>Renewal</option>
            </select>
        </label>

        <label>
            Amount
            <input type="number" step="0.01" min="0" name="amount" value="{{ $transaction->amount }}" required>
        </label>

        <label>
            Status
            <select name="status" required>
                @foreach (['pending', 'paid', 'approved', 'expired', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected($transaction->status === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </label>
    </div>

    <label>
        Remarks
        <textarea name="remarks">{{ $transaction->remarks }}</textarea>
    </label>

    <button class="btn-primary" type="submit">Save changes</button>
</form>
@endsection
