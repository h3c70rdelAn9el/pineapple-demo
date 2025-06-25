<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Therapist Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Invoice</h2>
    <p><strong>Invoice Date:</strong> {{ $invoiceDate }}<br>
    <strong>Invoice Number:</strong> {{ $invoiceNumber }}</p>

    <h3>Billing From:</h3>
    <p>
        {{ $therapist->name }}<br>
        {{ $therapist->street_address }}<br>
        {{ $therapist->state }}, {{ $therapist->zip_code_postal_code }}<br>
        {{ $therapist->country }}<br>
        Contact: {{ $therapist->email }}<br>
        Tax ID: {{ $therapist->tax_id ?? 'N/A' }}
    </p>

    <h3>Bill To:</h3>
    <p>
        Pineapple Support<br>
        123 Pineapple Lane<br>
        Miami, FL 33101<br>
        Email: kellie@pineapplesupport.org<br>
    </p>

    <h3>Payment Terms:</h3>
    <p>Net 30</p>

    <h3>Itemized Services</h3>
    <table>
        <thead>
            <tr>
                <th>Client Code</th>
                <th>Session Type</th>
                
                <th>Quantity</th>
                <th>Session Cost</th>
                <th>Client Contribution</th>
                <th>Remaining Contribution</th>
            </tr>
        </thead>
        <tbody>
            <!--
            $sessionSummary[] = [
                'client_id' => $clientId,
                'client_code' => $client ? $client->client_code : null,
                'quantity' => $clientSessions->count(),
                'sessions' => $clientSessions,
                'total_session_cost' => $totalSessionCost,
                'total_client_contribution' => $totalClientContribution,
                'total_remaining_contribution' => $totalRemainingContribution,
            ];-->
        @php $grandTotal = 0; @endphp
        @foreach($sessionSummary as $session)
            <tr>
                <td>{{ $session['client_code'] }}</td>
                <td>{{ $session['type'] ?? 'Individual Session' }}</td>
                
                <td>{{ $session['quantity'] }}</td>
                <td>${{ number_format($session['total_session_cost'], 2) }}</td>
                <td>${{ number_format($session['total_client_contribution'], 2) }}</td>
                <td>${{ number_format($session['total_remaining_contribution'], 2) }}</td>
            </tr>
            @php $grandTotal += $session['total_remaining_contribution']; @endphp
        @endforeach
        <tr>
            <td colspan="5" style="text-align:right;font-weight:bold;">Total</td>
            <td style="font-weight:bold;">${{ number_format($grandTotal, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <h3>Payment Instructions</h3>
    @if(!empty($therapist->payment_instructions))
        {!! nl2br(e($therapist->payment_instructions)) !!}
    @else
        Please refer to your payment instructions on file. Contact us if you need to update your payment details.
    @endif
</body>
</html>
