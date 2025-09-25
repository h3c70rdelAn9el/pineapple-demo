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
        3411 Silverside Road<br/>
        Tatnall Building #104<br/>
        Wilmington, DE, 19810<br/>
        Email: kellie@pineapplesupport.org<br>
    </p>

    <h3>Payment Terms:</h3>
    <p>Net 30</p>

    <h3>Itemized Services</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Client Code</th>
                <th>Session Type</th>
                <th>Session Cost</th>
                <th>Client Contribution</th>
                <th>Remaining Contribution</th>
            </tr>
        </thead>
        <tbody>
        @php $grandTotal = 0; @endphp
        @foreach($sessions as $session)
            <tr>
                <td>{{ $session->created_at->format('Y-m-d') }}</td>
                <td>{{ $session->client ? $session->client->client_code : 'N/A' }}</td>
                <td>Individual Session</td>
                <td>{{ $currencySymbol }}{{ number_format($session->session_cost, 2) }}</td>
                <td>{{ $currencySymbol }}{{ number_format($session->client_contribution, 2) }}</td>
                <td>{{ $currencySymbol }}{{ number_format($session->session_cost - $session->client_contribution, 2) }}</td>
            </tr>
            @php $grandTotal += ($session->session_cost - $session->client_contribution); @endphp
        @endforeach
        <tr>
            <td colspan="5" style="text-align:right;font-weight:bold;">Total</td>
            <td style="font-weight:bold;">{{ $currencySymbol }}{{ number_format($grandTotal, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <h3>Payment Instructions</h3>
    @if(!empty($therapist->payment_instructions))
        {!! nl2br(e($therapist->payment_instructions)) !!}
    @else
        Please refer to your payment instructions on file. Contact us if you need to update your payment details.
    @endif

    <h3>Banking Details for Payment</h3>
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px;">
        @if($therapist->account_name || $therapist->account_number || $therapist->routing_number || $therapist->iban_swift_code)
            @if($therapist->account_name)
                <p><strong>Account Name:</strong> {{ $therapist->account_name }}</p>
            @endif
            
            @if($therapist->account_number)
                <p><strong>Account Number:</strong> {{ $therapist->account_number }}</p>
            @endif
            
            @if($therapist->routing_number)
                <p><strong>Routing Number:</strong> {{ $therapist->routing_number }}</p>
            @endif
            
            @if($therapist->iban_swift_code)
                <p><strong>IBAN/SWIFT Code:</strong> {{ $therapist->iban_swift_code }}</p>
            @endif
        @else
            <p><em>Banking details not provided. Please contact us to update your payment information.</em></p>
        @endif
    </div>
</body>
</html>
