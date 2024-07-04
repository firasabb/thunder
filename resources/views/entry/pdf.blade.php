<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    
    <style>

        .blue-700 {
            color: #3b82f6;
        }

        .horizontal-center {
            margin-left: auto;
            margin-right: auto;
        }

        .flex-horizontal-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-center{
            text-align: center;
        }

        .w-100{
            width: 100%;
        }
    </style>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="py-5 px-5">
                <div class="mb-5 flex-horizontal-center">
                    <a href="{{ url('/') }}" target="_blank" class="text-center">
                        <img src="{{ asset('images/logo.png') }}" class="w-32 h-auto">
                    </a>
                </div>
                <span class="text-2xl mb-3 block blue-700">Entry Summary:</span>
                <span class="text-xs block mb-5">Confirmation Code: {{ $entry->confirmation_code }}</span>
                
                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                    @php
                        $entryTeams = $entry->teams()->get();
                        $otherIndex = 1;
                    @endphp
                    @foreach($entryTeams as $entryTeam)
                        @if(isset($entryTeam->team) && $entryTeam->team)
                            <li class="pt-2 pb-3 sm:pb-4">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    <div class="flex-shrink-0">
                                        <img class="w-8 h-8 rounded-full" src="{{ $entryTeam->team->featured_url }}" alt="{{ $entryTeam->team->name }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white pb-2">
                                            {{ $entryTeam->team->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400 pb-2">

                                            @if($entryTeam->conference == 'winner')
                                                <span class="text-blue-400 font-bold">Winner</span>
                                            @elseif($entryTeam->conference == 'all')
                                                <span class="text-indigo-400">{{ $otherIndex++ }} of 7</span>
                                            @elseif($entryTeam->conference == 'other')
                                                <span class="text-gray-500">All Other Conferences</span>
                                            @else
                                                {{ $entryTeam->conference }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <script>

            window.onload = function() {
                function generatePDF() {
                    html2pdf(document.body, {
                        margin: 1,
                        filename: 'entry-summary.pdf',
                        image: { type: 'jpeg', quality: 1 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                    });
                }

                generatePDF();
            }
		</script>

    </body>
</html>
