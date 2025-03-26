<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบแจ้งค่าเช่าทั้งหมด</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Sarabun', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f7f9;
        }
        .receipt-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            padding: 35px;
            position: relative;
            border-top: 6px solid #2c3e50;
            margin-bottom: 40px;
            page-break-after: always;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .receipt-header h3 {
            color: #2c3e50;
            margin: 0;
            font-size: 1.8em;
            font-weight: 600;
        }
        .receipt-header p {
            color: #7f8c8d;
            margin: 5px 0 0;
            font-size: 0.9em;
        }
        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .info-column {
            display: flex;
            flex-direction: column;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ecf0f1;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #2c3e50;
            font-weight: 600;
            margin-right: 10px;
        }
        .info-value {
            color: #34495e;
            text-align: right;
        }
        .receipt-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 25px;
        }
        .receipt-table th, .receipt-table td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
        }
        .receipt-table thead {
            background-color: #f1f3f5;
        }
        .receipt-table th {
            color: #2c3e50;
            font-weight: 600;
            text-align: left;
        }
        .amount-column {
            text-align: right;
            font-weight: 500;
            color: #2980b9;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .total-label {
            color: #2c3e50;
            font-size: 1.1em;
        }
        .total-amount {
            color: #e74c3c;
            font-size: 1.2em;
            text-align: right;
        }
        .payment-note {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 0.9em;
            font-style: italic;
        }
        @media print {
            body {
                background-color: white;
            }
            .receipt-container {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body onload="window.print()">
    @foreach($billings as $billing)
        <div class="receipt-container">
            <div class="receipt-header">
                <h3>{{ $organization->name }}</h3>
                <p>ใบแจ้งค่าเช่าประจำเดือน</p>
            </div>
            
            <div class="receipt-info">
                <div class="info-column">
                    <div class="info-row">
                        <span class="info-label">เดือน</span>
                        <span class="info-value">{{ date('m/Y', strtotime($billing->created_at)) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ห้องที่</span>
                        <span class="info-value">{{ $billing->room->name }}</span>
                    </div>
                </div>
                <div class="info-column">
                    <div class="info-row">
                        <span class="info-label">ผู้เข้าพัก</span>
                        <span class="info-value">{{ $billing->getCustomer()->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">เบอร์โทร</span>
                        <span class="info-value">{{ $billing->getcustomer()->phone }}</span>
                    </div>
                </div>
            </div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th style="text-align: right;">ราคา (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ค่าเช่า</td>
                        <td class="amount-column">{{ number_format($billing->amount_rent) }}</td>
                    </tr>
                    <tr>
                        <td>ค่าน้ำ</td>
                        <td class="amount-column">{{ number_format($billing->amount_water) }}</td>
                    </tr>
                    <tr>
                        <td>ค่าไฟ</td>
                        <td class="amount-column">{{ number_format($billing->amount_electric) }}</td>
                    </tr>
                    <tr>
                        <td>ค่าอินเตอร์เน็ต</td>
                        <td class="amount-column">{{ number_format($billing->amount_internet) }}</td>
                    </tr>
                    <tr>
                        <td>ค่าบริการอื่นๆ</td>
                        <td class="amount-column">{{ number_format($billing->amount_etc) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td class="total-label">รวมทั้งหมด</td>
                        <td class="total-amount">{{ number_format($billing->sumAmount()) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="payment-note">
                กรุณาชำระเงินภายในวันที่ 5 ของเดือน  
                หากชำระเกินกำหนด ท่านจะต้องชำระค่าปรับ
            </div>
        </div>
    @endforeach
</body>
</html>
