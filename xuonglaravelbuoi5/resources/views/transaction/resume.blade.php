<!-- resources/views/transaction/resume.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Transaction</title>
</head>
<body>
    <h1>Resume Your Transaction</h1>
    @if($transaction)
        <p>Current Step: {{ $transaction['step'] }}</p>
        <p>Amount: {{ $transaction['amount'] }}</p>
        <p>Receiver Account: {{ $transaction['receiver_account'] }}</p>
        <form action="{{ url('/transaction/update') }}" method="POST">
            @csrf
            <input type="hidden" name="step" value="{{ $transaction['step'] }}">
            <button type="submit">Continue</button>
        </form>
    @else
        <p>No active transaction found.</p>
    @endif
</body>
</html>
