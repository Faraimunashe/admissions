<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceptance Letter</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #2d5a27;
            padding-bottom: 20px;
        }

        .logo {
            max-width: 150px;
            max-height: 100px;
            margin-bottom: 20px;
        }

        .institute-name {
            font-size: 24px;
            font-weight: bold;
            color: #2d5a27;
            margin-bottom: 10px;
        }

        .institute-details {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .letter-content {
            margin: 40px 0;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .paragraph {
            margin-bottom: 20px;
            text-align: justify;
        }

        .student-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #2d5a27;
            margin: 20px 0;
        }

        .detail-row {
            margin-bottom: 8px;
        }

        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .signature-section {
            margin-top: 60px;
            text-align: right;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin-left: auto;
            margin-bottom: 10px;
        }

        .date {
            margin-top: 40px;
            text-align: right;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($institute->logo)
            <img src="{{ public_path('storage/' . $institute->logo) }}" alt="{{ $institute->name }} Logo" class="logo">
        @endif

        <div class="institute-name">{{ $institute->name }}</div>

        <div class="institute-details">
            @if($institute->address)
                {{ $institute->address }}<br>
            @endif
            @if($institute->phone)
                Tel: {{ $institute->phone }}<br>
            @endif
            @if($institute->web)
                Website: {{ $institute->web }}
            @endif
        </div>
    </div>

    <div class="letter-content">
        <div class="date">{{ date('F d, Y') }}</div>

        <div class="greeting">
            Dear {{ $applicant->firstnames }} {{ $applicant->surname }},
        </div>

        <div class="paragraph">
            We are pleased to inform you that you have been <strong>ACCEPTED</strong> to study <strong>{{ $programme->name }}</strong> at <strong>{{ $institute->name }}</strong> for the {{ $period->description ?? 'academic period' }}.
        </div>

        <div class="paragraph">
            Congratulations on your successful application! We were impressed by your qualifications and are excited to welcome you to our institution. This acceptance letter confirms your admission and outlines the next steps in your academic journey.
        </div>

        <div class="paragraph">
            <strong>Important Next Steps:</strong>
        </div>

        <div class="paragraph">
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li>Please confirm your acceptance by responding to this letter within 14 days</li>
                <li>Complete your registration process as outlined in the registration guide</li>
                <li>Submit any required documentation for verification</li>
                <li>Attend the orientation session (details will be provided separately)</li>
            </ul>
        </div>

        <div class="student-details">
            <h3 style="margin-top: 0; color: #2d5a27;">Student Details</h3>

            <div class="detail-row">
                <span class="detail-label">Full Name:</span>
                {{ $applicant->firstnames }} {{ $applicant->surname }}
            </div>

            <div class="detail-row">
                <span class="detail-label">Email:</span>
                {{ $applicant->user->email }}
            </div>

            @if($applicant->phone)
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                {{ $applicant->phone }}
            </div>
            @endif

            <div class="detail-row">
                <span class="detail-label">Programme:</span>
                {{ $programme->name }}
            </div>

            <div class="detail-row">
                <span class="detail-label">Institution:</span>
                {{ $institute->name }}
            </div>

            <div class="detail-row">
                <span class="detail-label">Application ID:</span>
                {{ $application->id }}
            </div>

            <div class="detail-row">
                <span class="detail-label">Acceptance Date:</span>
                {{ $acceptance->created_at->format('F d, Y') }}
            </div>

            <div class="detail-row">
                <span class="detail-label">Academic Period:</span>
                {{ $period->description ?? 'Not specified' }}
            </div>

            @if($period->start_date)
            <div class="detail-row">
                <span class="detail-label">Start Date:</span>
                {{ \Carbon\Carbon::parse($period->start_date)->format('F d, Y') }}
            </div>
            @endif
        </div>

        <div class="paragraph">
            Please keep this acceptance letter for your records. You may be required to present this document during your registration process. If you have any questions or need further assistance, please do not hesitate to contact our admissions office.
        </div>

        <div class="paragraph">
            We look forward to welcoming you to our campus and supporting your academic success. Once again, congratulations on your acceptance!
        </div>

        <div class="paragraph">
            Best regards,
        </div>

        <div class="signature-section">
            <div class="signature-line"></div>
            <div><strong>Admissions Office</strong></div>
            <div>{{ $institute->name }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This is an official acceptance letter generated on {{ date('F d, Y') }} at {{ date('h:i A') }}</p>
        <p>For verification purposes, please quote Application ID: {{ $application->id }}</p>
    </div>
</body>
</html>
