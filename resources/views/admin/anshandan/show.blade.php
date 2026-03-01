<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anshdaan Receipt - {{ $anshandan->receipt_no }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; line-height: 1.4; color: #003366; margin: 0; padding: 20px; background: #fff; }
        .receipt-container { max-width: 700px; margin: 0 auto; border: 2px solid #333; padding: 30px; position: relative; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { height: 80px; margin-bottom: 5px; }
        .header h1 { margin: 0; font-size: 18px; font-weight: bold; text-transform: none; }
        .header h2 { margin: 2px 0; font-size: 16px; font-weight: bold; }
        .header h3 { margin: 10px 0; font-size: 16px; font-weight: bold; text-decoration: underline; }
        
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .details-table td { border: 1px solid #333; padding: 8px 12px; vertical-align: middle; }
        .label { font-weight: bold; width: 25%; color: #333; }
        .value { color: #0056b3; font-weight: 500; }
        
        .amount-box { margin: 30px auto; text-align: center; border: 2px solid #333; width: fit-content; padding: 10px 25px; font-size: 20px; font-weight: bold; }
        .amount-box span { color: #0056b3; }

        .signatory-section { margin-top: 60px; text-align: right; }
        .signatory-line { border-top: 1px solid #999; display: inline-block; width: 200px; padding-top: 5px; font-size: 12px; }
        
        .footer-note { text-align: center; font-size: 11px; color: #666; font-style: italic; margin-top: 30px; }
        
        @media print {
            body { padding: 0; }
            .receipt-container { border: 2px solid #000; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Receipt</button>
        <a href="{{ route('admin.anshandan.download', $anshandan->id) }}" style="padding: 10px 20px; text-decoration: none; background: #10b981; color: #fff; margin-left: 10px; border-radius: 4px;">Download PDF</a>
        <a href="{{ route('admin.anshandan.index') }}" style="margin-left: 10px; color: #666;">Back to List</a>
    </div>

    <div class="receipt-container">
        <div class="header">
            @if(file_exists(public_path('images/association_logo.png')))
                <img src="{{ asset('images/association_logo.png') }}" alt="Logo">
            @else
                <div style="height: 60px; width: 60px; border: 1px dashed #ccc; display: inline-block; margin-bottom: 5px;">LOGO</div>
            @endif
            <h1>Educational Ministerial Office - State Education Department</h1>
            <h2>District {{ $anshandan->district->name }}</h2>
            <h3>Anshdaan Receipt</h3>
        </div>

        <table class="details-table">
            <tr>
                <td class="label">Receipt No.</td>
                <td class="value">{{ $anshandan->receipt_no }}</td>
                <td class="label">Date</td>
                <td class="value">{{ \Carbon\Carbon::parse($anshandan->payment_date)->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="label">Mr./Ms.</td>
                <td class="value" colspan="3" style="text-transform: uppercase;">{{ $anshandan->member_name }}</td>
            </tr>
            <tr>
                <td class="label">Depositor</td>
                <td class="value" colspan="3" style="text-transform: uppercase;">{{ $anshandan->depositor_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">School/Office</td>
                <td class="value" colspan="3" style="text-transform: uppercase;">{{ $anshandan->school_office ?? ($anshandan->user->staff->school->name ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td class="label">Block</td>
                <td class="value" colspan="3">{{ $anshandan->block->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Year</td>
                <td class="value" colspan="3">{{ $anshandan->year }}</td>
            </tr>
            <tr>
                <td class="label">Academic Year</td>
                <td class="value" colspan="3">{{ $anshandan->academic_year ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Remarks</td>
                <td class="value" colspan="3">{{ $anshandan->remarks ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="amount-box">
            Rs <span>{{ number_format($anshandan->amount, 2) }}</span>
        </div>

        <div class="signatory-section">
            <div class="signatory-line">Authorized Signatory</div>
        </div>

        <div class="footer-note">
            This is a computer generated receipt and does not require a physical signature.
        </div>
    </div>
</body>
</html>
