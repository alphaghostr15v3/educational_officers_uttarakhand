<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Courier', monospace; font-size: 14px; color: #003366; margin: 0; padding: 0; }
        .receipt-container { border: 2px solid #333; padding: 20px; position: relative; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 14px; font-weight: bold; }
        .header h3 { margin: 10px 0; font-size: 14px; font-weight: bold; text-decoration: underline; }
        
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table td { border: 1px solid #333; padding: 6px 10px; }
        .label { font-weight: bold; width: 25%; color: #333; }
        .value { color: #0056b3; }
        
        .amount-box { margin: 20px auto; text-align: center; border: 2px solid #333; width: 200px; padding: 10px; font-size: 18px; font-weight: bold; }
        
        .signatory-section { margin-top: 40px; text-align: right; }
        .signatory-line { border-top: 1px solid #666; display: inline-block; width: 180px; padding-top: 5px; font-size: 11px; text-align: center; }
        
        .footer-note { text-align: center; font-size: 10px; color: #666; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1 style="font-size: 18px;">Educational Ministerial Office - State Education Department</h1>
            <h2>District {{ $anshandan->district->name }}</h2>
            <h3 style="font-size: 16px;">Anshdaan Receipt</h3>
        </div>

        <table class="details-table" cellspacing="0">
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
            Rs {{ number_format($anshandan->amount, 2) }}
        </div>

        <div class="signatory-section">
            <div class="signatory-line">Authorized Signatory</div>
        </div>

        <div class="footer-note">
            <i>This is a computer generated receipt and does not require a physical signature.</i>
        </div>
    </div>
</body>
</html>
