    <script>
        var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        function preventBackAfterLogout() {
            if (!isLoggedIn) {
                // Clear session history and prevent going back
                history.pushState(null, "", location.href);
                history.pushState(null, "", location.href);

                window.addEventListener("popstate", function () {
                    // Push forward again so back button does nothing
                    history.go(1);
                });

                // Optional: Force redirect to login if back is pressed multiple times
                setTimeout(() => {
                    history.pushState(null, "", location.href);
                }, 100);
            }
        }

        // Execute when page loads
        window.onload = preventBackAfterLogout;

        // Navbar scroll behavior
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll Down
                navbar.style.top = "-80px"; // Adjust based on navbar height
                navbar.style.opacity = "0"; // Fade out
            } else {
                // Scroll Up
                navbar.style.top = "0";
                navbar.style.opacity = "1"; // Fade in
            }
            lastScrollTop = scrollTop;
        });
    </script>

    <script>
        //This section is only needed if you want to add an alert to the third image as it does not have a link.
        document.addEventListener('DOMContentLoaded', function() {
            var partnerLinks = document.querySelectorAll('.partner-link');

            partnerLinks.forEach(function(link, index) {
                if (index === 2 && link.getAttribute('href') === 'javascript:void(0);') { // Check if it's the third link and has no proper link
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent default action (navigation)
                        alert('No link provided for this partner.');
                    });
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
