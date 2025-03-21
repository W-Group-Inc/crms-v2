<!DOCTYPE html>
<html>
<head>
    <title>New Customer Complaint Assignment</title>
</head>
<body>
    <p>Dear {{ $ConcernedName }},</p>
    
    <p>A new customer complaint issue has been assigned to your department.</p>

    <p><strong>Details:</strong></p>
    <ul>
        <li><strong>CCF #:</strong> {{ $customerComplaint->CcNumber }}</li>
        <li><strong>Date Complaint:</strong> {{ date('M. d, Y', strtotime($customerComplaint->created_at)) }}</li>
        <li><strong>Quality Class:</strong> {{ $customerComplaint->QualityClass }}: {{ $customerComplaint->ProductName }}</li>
        <li><strong>Company Name:</strong> {{ $customerComplaint->CompanyName }}</li>
        <li><strong>Customer:</strong> {{ $customerComplaint->CustomerRemarks ?? 'No customer remarks provided' }}</li>
    </ul>

    <p><strong>View Complaint:</strong> 
        <a href="{{ url('customer_complaint/view/'.$customerComplaint->id) }}" target="_blank">
            Click here to view details
        </a>
    </p>

    <!-- @if(!empty($attachments))
        <p><strong>Attachments:</strong></p>
        <ul>
            @foreach($attachments as $attachment)
                <li><a href="{{ storage_path('app/public/').$attachment }}" target="_blank">View Attachment</a></li>
            @endforeach
        </ul>
    @endif -->

    <p>Please take necessary action as soon as possible.</p>

    <p>Best regards,</p>
    <p>Your Company</p>
</body>
</html>
