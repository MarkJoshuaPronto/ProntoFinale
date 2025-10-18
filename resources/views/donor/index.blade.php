<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('donor.css')
</head>
<body>
    @include('donor.header')
    <section>
        <div class="container-fluid">
            <div class="row">
                @include('donor.sidebar')
                @include('donor.table')
            </div>
        </div>
    </section>

    @include('donor.footer')
</body>
</html>
