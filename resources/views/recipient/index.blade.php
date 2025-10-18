<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add this in the head section if not already there -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('recipient.css')
</head>
<body>
    @include('recipient.header')
    <section>
        <div class="container-fluid">
            <div class="row">
                @include('recipient.sidebar')
                @include('recipient.table')
            </div>
        </div>
    </section>
    @include('recipient.footer')
</body>
</html>
