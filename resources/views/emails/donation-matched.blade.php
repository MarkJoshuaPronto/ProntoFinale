<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Matched</title>
</head>
<body>
    <h2>Your Donation Has Been Matched!</h2>
    
    <p>Hello {{ $donation->user->name }},</p>
    
    <p>We're excited to inform you that your donation of <strong>{{ $donation->category }}</strong> has been matched with a recipient in need!</p>
    
    <h3>Donation Details:</h3>
    <ul>
        <li><strong>Category:</strong> {{ ucfirst($donation->category) }}</li>
        <li><strong>Subcategory:</strong> {{ ucfirst($donation->subcategory) }}</li>
        <li><strong>Quantity:</strong> {{ $donation->quantity }}</li>
        <li><strong>Condition:</strong> {{ ucfirst(str_replace('_', ' ', $donation->condition)) }}</li>
    </ul>
    
    <h3>Recipient Details:</h3>
    <ul>
        <li><strong>Recipient:</strong> {{ $request->full_name }}</li>
        <li><strong>Contact:</strong> {{ $request->contact_number }}</li>
        <li><strong>Address:</strong> {{ $request->address }}</li>
        <li><strong>Need:</strong> {{ $request->description }}</li>
    </ul>
    
    <p>Please expect the recipient to contact you within the next 48 hours to arrange for pickup/delivery.</p>
    
    <p>Thank you for your generosity!</p>
    
    <p><strong>The Donation Platform Team</strong></p>
</body>
</html>