<!-- resources/views/transaction/complete.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Transaction</title>
</head>
<body>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
    <h1>Complete Your Transaction</h1>
    <form action="{{ url('/transaction/complete') }}" method="POST">
        @csrf
        <button type="submit">Complete Transaction</button>
    </form>
    <br>
    <form action="{{ url('/transaction/cancel') }}" method="POST">
        @csrf
        <button type="submit">Cancel Transaction</button>
    </form>
</body>
</html>
