<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entry Confirmation</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-image: url('/images/home-1.jpg');
                background-size: cover;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>Entry Summary:</h1>
            <p><strong>Entry ID:</strong> {{ $entry->confirmation_code }}</p>
            <div class="row">
                @php
                    $entryTeams = $entry->teams()->get();
                @endphp
                @foreach($entryTeams as $entryTeam)
                    @if(isset($entryTeam->team) && $entryTeam->team)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="{{ $entryTeam->team->featured_url }}" class="card-img-top" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $entryTeam->conference }}</h5>
                                    <p class="card-text">{{ $entryTeam->team->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </body>
</html>