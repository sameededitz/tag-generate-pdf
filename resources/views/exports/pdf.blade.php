<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
            margin: 1.5mm;
            /* Change  */
            orientation: portrait;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .sheet {
            width: 100%;
        }

        .row {
            width: 100%;
            /* margin-bottom: 1mm; */
        }

        .tag {
            width: 49mm;
            height: auto;
            min-height: 26.5mm;
            border: 1px solid #000;
            box-sizing: border-box;
            padding: 1mm;
            text-align: center;
            align-content: center;
            float: left;
            /* margin-right: 0.5mm; */
            page-break-inside: avoid;
        }

        .tag:nth-child(4n) {
            margin-right: 0;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .title {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 1mm;
        }

        .address {
            font-size: 7pt;
            line-height: 1.1;
            font-weight: 600;
            margin-bottom: 1.5mm;
        }

        /* Date container to hold both dates in one line */
        .dates-container {
            line-height: 1.1;
        }

        .date-section {
            display: inline-block;
            vertical-align: top;
        }

        .date-section:first-child {
            margin-right: 4%;
        }

        .date-section {
            font-size: 9pt;
            line-height: 1.1;
            margin-bottom: 0.8mm;
        }

        .date-section:last-child {
            margin-bottom: 0;
        }

        .label {
            font-weight: bold;
        }

        .date-value {
            font-size: 11pt;
            margin-top: 0.2mm;
        }
    </style>
</head>

<body>
    <div class="sheet">
        @for ($row = 0; $row < 10; $row++)
            <div class="row clearfix">
                @for ($col = 0; $col < 4; $col++)
                    <div class="tag">
                        <div class="title">{{ strtoupper($title) }}</div>
                        <div class="address">{{ strtoupper($address) }}</div>
                        <div class="dates-container">
                            <div class="date-section">
                                <div class="label">Mfg Date</div>
                                <div class="date-value">
                                    {{ \Carbon\Carbon::createFromFormat('m-d-y', $mfg_date)->format('d/m/y') }}
                                </div>
                            </div>
                            <div class="date-section">
                                <div class="label">Exp Date</div>
                                <div class="date-value">
                                    {{ \Carbon\Carbon::createFromFormat('m-d-y', $exp_date)->format('d/m/y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        @endfor
    </div>
</body>

</html>
