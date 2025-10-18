<div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/donation.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Donations: {{$donationscount}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/pending.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Pending Requests: {{$pendingreq}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/accept.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Accepted Requests: {{$acceptedreq}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/decline.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Rejected Requests: {{$rejectedreq}}</h5>
                                </div>
                            </div>
                        </div>