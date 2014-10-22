@extends('template')

@section('page')

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Store Transactions</h1>

			<nav class="navbar navbar-default filter">
				<form class="navbar-form navbar-left">
					Filter by
					<div class="form-group">
						<select class="form-control"><option>Month</option></select>
						<select class="form-control"><option>Type</option></select>
					</div>
				</form>
			</nav>

			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>User</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Confirmation</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($transactions as $transaction)
					<tr>
						<td>{{ $transaction->created_at->format('M j, Y') }}</td>
						<td>{{ $transaction->user->name }}</td>
						<td>Donation</td>
						<td>{{ number_format($transaction->amount / 100, 2) }}</td>
						<td>{{ $transaction->confirmation }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection