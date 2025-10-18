<style>
/* Notification Dropdown Styles */
.dropdown-menu {
    max-height: 400px;
    overflow-y: auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
    border-radius: 8px;
}

.dropdown-header {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #196f38;
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
}

.dropdown-item {
    /* padding: 12px 15px; */
    border-bottom: 1px solid #f0f0f0;
    word-wrap: break-word;
    /* white-space: normal; */
    line-height: 1.4;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

/* Notification text styling */
.notification-item {
    max-width: 100%;
    overflow: hidden;
}

.notification-title {
    font-weight: 600;
    color: #196f38;
    margin-bottom: 3px;
    font-size: 0.9rem;
}

.notification-message {
    color: #666;
    font-size: 0.85rem;
    line-height: 1.3;
}

.notification-time {
    font-size: 0.75rem;
    color: #999;
    margin-top: 3px;
}

/* Custom scrollbar for dropdown */
.dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.dropdown-menu::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.dropdown-menu::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Badge styling */
#notifCount {
    font-size: 0.7rem;
    padding: 3px 6px;
    min-width: 18px;
    height: 18px;
}

/* Bell icon animation */
#notificationBell {
    transition: transform 0.3s ease;
    position: relative;
}

#notificationBell:hover {
    transform: scale(1.1);
}

#notificationBell.has-notifications {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Responsive design */
@media (max-width: 768px) {
    .dropdown-menu {
        width: 280px !important;
        max-width: 90vw;
        right: 0 !important;
        left: auto !important;
    }
}

/* No notifications styling */
.dropdown-menu .text-center {
    padding: 20px 15px;
    color: #999;
    font-style: italic;
}
</style>

<header>
    <nav class="navbar navbar-expand-lg" style="background-color: #196f38;">
        <div class="container-fluid">
            <span class="navbar-brand">
                <a href="{{ route('landingpageuser') }}">
                    <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                </a>
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="{{route('landingpageuser')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('donationuser')}}">Donations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('galleryuser')}}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('aboutususer')}}">About Us</a>
                    </li>
                </ul>
            </div>

            <div class="dropdown me-3">
                <a href="#" id="notificationBell" data-bs-toggle="dropdown" aria-expanded="false" style="color:white; font-size:20px; position:relative;">
                    <i class="fa fa-bell"></i>
                    <span id="notifCount" class="badge bg-danger" style="position:absolute; top:-5px; right:-10px; display:none;">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" id="notifList" style="width:350px; max-height:400px; overflow-y:auto;">
                    <li class="dropdown-header">Notifications</li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="text-center py-3">No notifications</li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown">
                    @if (Auth::check() && $auth->image)
                        <img src="{{ asset('storage/' . $auth->image) }}" alt="Authenticated Logo"
                             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
                             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    @else
                        <img src="{{ asset('assets/logo.jpg') }}" alt="Authenticated Logo"
                             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
                             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    @endif
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('donordashboard') }}">Donor Dashboard</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="background-color: red; color: white; width: 100%; text-align: left; border: none;">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadNotifications();

    function loadNotifications() {
        fetch("{{ route('notifications.show') }}")
            .then(res => res.json())
            .then(data => {
                let notifList = document.getElementById("notifList");
                let notifCount = document.getElementById("notifCount");
                let notificationBell = document.getElementById("notificationBell");

                // Clear existing notifications
                notifList.innerHTML = '<li class="dropdown-header">Notifications</li><li><hr class="dropdown-divider"></li>';

                // Show all notifications
                if (data.notifications.length > 0) {
                    data.notifications.forEach(n => {
                        const notificationItem = document.createElement('li');
                        notificationItem.className = 'dropdown-item notification-item';
                        notificationItem.innerHTML = `
                            <div class="notification-title">${n.title}</div>
                            <div class="notification-message">${n.message}</div>
                            <div class="notification-time">${formatTime(n.created_at)}</div>
                        `;
                        notifList.appendChild(notificationItem);
                    });

                    // Add bell animation if there are unread notifications
                    if (data.unreadCount > 0) {
                        notificationBell.classList.add('has-notifications');
                    }
                } else {
                    const noNotifications = document.createElement('li');
                    noNotifications.className = 'text-center py-3';
                    noNotifications.textContent = 'No notifications';
                    notifList.appendChild(noNotifications);
                }

                // Show unread count in badge
                if (data.unreadCount > 0) {
                    notifCount.innerText = data.unreadCount;
                    notifCount.style.display = "inline";
                } else {
                    notifCount.style.display = "none";
                    notificationBell.classList.remove('has-notifications');
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
            });
    }

    function formatTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInHours = (now - date) / (1000 * 60 * 60);

        if (diffInHours < 1) {
            return 'Just now';
        } else if (diffInHours < 24) {
            return `${Math.floor(diffInHours)} hours ago`;
        } else {
            return `${Math.floor(diffInHours / 24)} days ago`;
        }
    }

    document.getElementById("notificationBell").addEventListener("click", function() {
        // Mark notifications as read
        fetch("{{ route('notifications.read') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        }).then(() => {
            document.getElementById("notifCount").style.display = "none";
            document.getElementById("notificationBell").classList.remove('has-notifications');
        });
    });

    // Auto-refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});
</script>
