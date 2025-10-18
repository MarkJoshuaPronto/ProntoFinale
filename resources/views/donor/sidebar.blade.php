<div class="col-md-2 sidebar">
                    <div class="text-center mt-5">
                        @if(Auth::check() && $auth->image)
                            <img
                                src="{{ asset('storage/' . $auth->image) }}"
                                alt="User  Image"
                                width="80"
                                height="80"
                                class="rounded-circle mb-2"
                                id="profile-image-{{ $auth->id }}"
                                style="cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#editUser Modal-{{ $auth->id }}">
                        @else
                            <img
                                src="{{ asset('assets/logo.jpg') }}"
                                alt="User  Image"
                                width="80"
                                height="80"
                                class="rounded-circle mb-2"
                                id="profile-image-{{ $auth->id }}"
                                style="cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#editUser Modal-{{ $auth->id }}">
                        @endif
                    </div>
                    <h4 class="text-center text-white mb-4">{{ ucwords(Auth::user()->name) }}</h4>
                    <a href="{{route('donordashboard')}}">Dashboard</a>
                    <a href="{{ route('edituser', Auth::user()->id) }}">Edit Profile</a>
                    <a href="#" onclick="confirmDeactivate()">Deactivate Account</a>
                    <form id="deactivateForm" action="{{ route('userdeactivateaccount', $auth->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                    </form>
                    <script>
                        function confirmDeactivate() {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to undo this action!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, deactivate it!',
                                cancelButtonText: 'Cancel',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('deactivateForm').submit();
                                }
                            });
                        }
                    </script>
                    <a href="#" onclick="confirmDelete()">Delete Account</a>
                    <form id="deleteForm" action="{{ route('deleteaccount', $auth->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <script>
                        function confirmDelete() {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Do you really want to permanently delete this account?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('deleteForm').submit();
                                }
                            });
                        }
                    </script>
                </div>