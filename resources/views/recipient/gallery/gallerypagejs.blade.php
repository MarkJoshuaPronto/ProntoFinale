    <!-- Add Swiper JS for the swipeable gallery -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        let swiper;

        // Function to initialize Swiper
        function initializeSwiper() {
            swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                keyboard: { enabled: true },
                touch: {
                    enabled: true,
                    dragSize: 20
                },
                mousewheel: {
                    enabled: true
                }
            });
        }

        // Open the floating card with the selected gallery
        function openGallery(index) {
            // Get the gallery card element
            const galleryCard = document.querySelectorAll('.gallery-card')[index];

            // Get all images from the selected gallery card
            const images = JSON.parse(galleryCard.querySelector('.card').getAttribute('data-images'));

            // Create slides for Swiper
            const imagesHTML = images.map(img => `
                <div class="swiper-slide">
                    <img src="{{ asset('storage/') }}/${img}" alt="Gallery Image">
                </div>
            `).join('');

            // Update Swiper container
            const swiperWrapper = document.querySelector('.swiper-wrapper');
            swiperWrapper.innerHTML = imagesHTML;

            // Destroy existing Swiper instance if it exists
            if (swiper) {
                swiper.destroy(true, true);
            }

            // Reinitialize Swiper
            initializeSwiper();

            // Show floating card
            document.querySelector('.floating-card').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        }

        // Close the floating card
        function closeGallery() {
            document.querySelector('.floating-card').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        }

        // Close the floating card when clicking outside
        document.querySelector('.overlay').addEventListener('click', closeGallery);

        // Add keyboard controls
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeGallery();
            }
        });
    </script>
    <!-- Add the scroll behavior script -->
<script>
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
