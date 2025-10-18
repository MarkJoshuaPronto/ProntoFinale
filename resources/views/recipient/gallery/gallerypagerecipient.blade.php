<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <title>Gallery</title>
</head>
@include('recipient.gallery.gallerypagecss')
<body>
@include('recipient.gallery.gallerypageheader')

    <section>
        <div class="container mt-5">
            <h4 class="gallery-title">Gallery</h4>
            <div class="row justify-content-start mt-5">
                @foreach ($gallery as $index => $items)
                    <div class="col-md-3 mb-5 gallery-card">
                        <div class="card p-3" onclick="openGallery({{ $index }})" data-images="{{ json_encode($items->images) }}">
                            <div class="card-body">
                                <!-- Display only the first image -->
                                <img src="{{ asset('storage/' . $items->images[0]) }}" class="img-fluid fixed-img" alt="Image">
                                <p class="fw-bold mt-3">{{ $items->description }}</p>
                                <p class="gallery-description"><strong>Location:</strong> {{ $items->location }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Floating Card for Swipeable Gallery -->
    <div class="overlay" onclick="closeGallery()"></div>
    <div class="floating-card">
        <div class="swiper-container">
            <div class="swiper-wrapper"></div>
            <!-- Add Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

@include('recipient.gallery.gallerypagefooter')

@include('recipient.gallery.gallerypagejs')
</body>
</html>
