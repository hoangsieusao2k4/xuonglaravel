<!-- resources/views/transaction/start.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Transaction</title>
</head>
<body>
    <h1>Start a New Transaction</h1>
    <form action="{{ url('/transaction/start') }}" method="POST">
        @csrf
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" required>
        <br><br>
        <label for="receiver_account">Receiver Account:</label>
        <input type="text" name="receiver_account" id="receiver_account" required>
        <br><br>
        <button type="submit">Start Transaction</button>
    </form>
</body>
</html>
