<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $anshandan->receipt_no }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background: #f4f4f4; }
        .receipt-container { max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border: 1px solid #ddd; position: relative; overflow: hidden; }
        .header { text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 20px; margin-bottom: 30px; }
        .header img { height: 80px; margin-bottom: 15px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { margin: 5px 0 0; color: #666; font-size: 16px; font-weight: normal; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 14px; color: #555; }
        .receipt-body { margin-bottom: 40px; }
        .row { display: flex; margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 8px; }
        .label { font-weight: bold; width: 200px; color: #1e3a8a; }
        .value { flex: 1; }
        .amount-section { background: #f9f9f9; padding: 20px; border-radius: 4px; text-align: right; margin-top: 30px; border-left: 5px solid #1e3a8a; }
        .amount-section h3 { margin: 0; font-size: 28px; color: #1e3a8a; }
        .footer { margin-top: 50px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature { text-align: center; width: 200px; }
        .signature div { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-size: 14px; font-weight: bold; }
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 100px; color: rgba(30, 58, 138, 0.05); white-space: nowrap; pointer-events: none; text-transform: uppercase; font-weight: bold; z-index: 0; }
        @media print {
            body { background: #fff; padding: 0; }
            .receipt-container { box-shadow: none; border: 1px solid #000; margin: 0; width: 100%; max-width: 100%; }
            .no-print { display: none; }
        }
        .btn-print { background: #1e3a8a; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" class="btn-print">Print Receipt</button>
        <a href="{{ route('admin.anshandan.download', $anshandan->id) }}" class="btn-print" style="background: #10b981; margin-left: 10px;">Download PDF</a>
        <a href="{{ route('admin.anshandan.index') }}" style="margin-left: 10px; color: #666;">Back to List</a>
    </div>

    <div class="receipt-container">
        <div class="watermark">OFFICIAL RECEIPT</div>
        
        <div class="header">
            <img src="{{ asset('images/association_logo.png') }}" alt="Logo">
            <h1>Educational Ministerial Officers Association</h1>
            <h2>Uttarakhand</h2>
        </div>

        <div class="meta">
            <div>
                <strong>Receipt No:</strong> {{ $anshandan->receipt_no }}
            </div>
            <div>
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($anshandan->payment_date)->format('d M, Y') }}
            </div>
        </div>

        <div class="receipt-body">
            <div class="row">
                <div class="label">Received From:</div>
                <div class="value">{{ $anshandan->member_name }}</div>
            </div>
            @if($anshandan->user_id)
            <div class="row">
                <div class="label">Employee Code:</div>
                <div class="value">{{ $anshandan->user->employee_code ?? 'N/A' }}</div>
            </div>
            @endif
            <div class="row">
                <div class="label">Contribution For:</div>
                <div class="value">{{ $anshandan->month }}, {{ $anshandan->year }}</div>
            </div>
            <div class="row">
                <div class="label">District:</div>
                <div class="value">{{ $anshandan->district->name }}</div>
            </div>
            @if($anshandan->block_id)
            <div class="row">
                <div class="label">Block:</div>
                <div class="value">{{ $anshandan->block->name }}</div>
            </div>
            @endif
            <div class="row">
                <div class="label">Payment Method:</div>
                <div class="value">{{ $anshandan->payment_method }} {{ $anshandan->transaction_id ? '(ID: '.$anshandan->transaction_id.')' : '' }}</div>
            </div>
            @if($anshandan->remarks)
            <div class="row">
                <div class="label">Remarks:</div>
                <div class="value">{{ $anshandan->remarks }}</div>
            </div>
            @endif
        </div>

        <div class="amount-section">
            <div style="font-size: 14px; color: #666; margin-bottom: 5px;">Total Amount Received</div>
            <h3>₹{{ number_format($anshandan->amount, 2) }}</h3>
        </div>

        <div class="footer">
            <div style="font-size: 12px; color: #888;">
                This is a computer-generated receipt and does not require a physical signature.<br>
                Generated by: {{ $anshandan->creator->name }}
            </div>
            <div class="signature">
                <div>Authorized Signatory</div>
            </div>
        </div>
    </div>
</body>
</html>
