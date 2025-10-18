<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Request Matched</title>
</head>
<body>
    <h2>Good News! Your Request Has Been Matched</h2>
    
    <p>Hello {{ $request->user->name }},</p>
    
    <p>We're excited to inform you that your request for <strong>{{ $request->category }}</strong> has been matched with a donation!</p>
    
    <h3>Request Details:</h3>
    <ul>
        <li><strong>Category:</strong> {{ ucfirst($request->category) }}</li>
        <li><strong>Subcategory:</strong> {{ ucfirst($request->subcategory) }}</li>
        <li><strong>Quantity:</strong> {{ $request->quantity }}</li>
        <li><strong>Description:</strong> {{ $request->description }}</li>
    </ul>
    
    <h3>Donation Details:</h3>
    <ul>
        <li><strong>Donor:</strong> {{ $donation->full_name }}</li>
        <li><strong>Contact:</strong> {{ $donation->contact_number }}</li>
        <li><strong>Location:</strong> {{ $donation->location }}</li>
<li><strong>Available Date:</strong> {{ \Carbon\Carbon::parse($donation->available_date)->format('F j, Y') }}</li>
    </ul>
    
    <p>Please contact the donor within the next 48 hours to arrange for pickup/delivery.</p>
    
    <p>Thank you for using our platform!</p>
    
    <p><strong>The Donation Platform Team</strong></p>
</body>
</html>