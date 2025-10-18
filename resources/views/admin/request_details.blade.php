<div class="request-details">
    <h4>Request Details #{{ $request->id }}</h4>
    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>Requester Name:</strong> {{ $request->full_name }}</p>
            <p><strong>Contact Number:</strong> {{ $request->contact_number }}</p>
            <p><strong>Address:</strong> {{ $request->address }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Status:</strong> <span class="badge bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning') }}">
                {{ ucfirst($request->status) }}
            </span></p>
            <p><strong>Request Date:</strong> {{ $request->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5>Request Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Category:</strong> {{ ucfirst($request->category) }}</p>
                    <p><strong>Subcategory:</strong> {{ ucfirst($request->subcategory) }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Specific Needs:</strong>
                        {{ $request->specific_items ?? $request->specific_needs ?? 'N/A' }}
                    </p>
                    <p><strong>Size:</strong> {{ $request->size ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Quantity:</strong> {{ $request->quantity }}</p>
                    <p><strong>Urgency:</strong> {{ $request->urgency ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($request->additional_notes)
    <div class="card">
        <div class="card-header">
            <h5>Additional Notes</h5>
        </div>
        <div class="card-body">
            <p>{{ $request->additional_notes }}</p>
        </div>
    </div>
    @endif
</div>
