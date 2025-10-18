    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 5
            });
        });

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

        // Add event listeners for character count and validation
        @foreach ($donations as $donation)
        document.getElementById('description{{$donation->id}}').addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            document.getElementById('charCount{{$donation->id}}').textContent = remaining + ' characters remaining';

            if (currentLength > maxLength) {
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'block';
            } else {
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'none';
            }
        });

        // Initial character count on page load
        const initialDescription{{$donation->id}} = document.getElementById('description{{$donation->id}}').value;
        const initialRemaining{{$donation->id}} = 500 - initialDescription{{$donation->id}}.length;
        document.getElementById('charCount{{$donation->id}}').textContent = initialRemaining{{$donation->id}} + ' characters remaining';

        document.getElementById('editDonationForm{{$donation->id}}').addEventListener('submit', function(event) {
            const description = document.getElementById('description{{$donation->id}}').value;
            if (description.length > 500) {
                event.preventDefault();
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'block';
            }
        });
        @endforeach
    </script>