@extends('template')

@section('page')

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Store Transactions</h1>

			<nav class="navbar navbar-default filter">
				{{ Form::open(['method'=>'GET', 'class'=>'navbar-form navbar-left']) }}
					Filter by
					<div class="form-group select">
						{{ Form::select('month', array(''=>'Month') + $months, Input::get('month'), ['class'=>'form-control']) }}
					</div>
					<div class="form-group select">
						{{ Form::select('type', array(''=>'Type') + $types, Input::get('type'), ['class'=>'form-control']) }}
					</div>
				{{ Form::close() }}
				<div class="navbar-form navbar-right">
					<a class="btn btn-default" href="{{ URL::action('PaymentController@export') }}">
						<i class="glyphicon glyphicon-download"></i> Download
					</a>
				</div>
			</nav>

			@if (count($transactions))
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Date &amp; Time</th>
						<th>User</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Confirmation</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($transactions as $transaction)
					<tr>
						<td>{{ $transaction->created_at->format('M j, Y - g:ia') }}</td>
						<td>{{ $transaction->user->name }}</td>
						<td>{{ $types[$transaction->type] }}</td>
						<td>{{ number_format($transaction->amount / 100, 2) }}</td>
						<td>{{ $transaction->confirmation }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<div class="alert alert-info">No transactions match those criteria</div>
			@endif
		</div>
	</div>
</div>

@endsection