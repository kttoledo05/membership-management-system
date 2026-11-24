@extends('layouts.app')

@section('content')

<div class="page-head">
    <div>
        <p class="eyebrow">Transaction processing</p>
        <h1>New Transaction</h1>
        <p class="muted">
            Create a membership application or renewal transaction.
        </p>
    </div>

    <a class="btn-primary" href="{{ route('transactions.index') }}">
        Back to Transactions
    </a>
</div>

<form class="form-card"
      method="POST"
      action="{{ route('transactions.store') }}">

    @csrf

    <div class="form-grid">

        <label>
            Member

            <select name="member_id" required>
                <option value="" disabled selected>
                    Select a member
                </option>

                @forelse ($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->full_name }}
                        - {{ $member->membership_number }}
                    </option>
                @empty
                    <option value="" disabled>
                        No members available. Register a member first.
                    </option>
                @endforelse
            </select>
        </label>

        <label>
            Transaction Type

            <select name="type" required>
                <option value="" disabled selected>
                    Select transaction type
                </option>

                <option value="application">
                    Membership Application
                </option>

                <option value="renewal">
                    Membership Renewal
                </option>
            </select>
        </label>

        <label>
            Amount

            <input
                type="number"
                name="amount"
                step="0.01"
                min="0"
                placeholder="Enter amount"
                required
            >
        </label>

    </div>

    <label>
        Remarks

        <textarea
            name="remarks"
            rows="4"
            placeholder="Enter optional remarks"
        ></textarea>
    </label>

    <button class="btn-primary" type="submit">
        Create Transaction
    </button>

</form>

@endsection