<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MOVIE PORTFOLIO</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen flex flex-col relative">
        <!-- Background Screen -->
        @php
            $backdropPath = $tvData ? "{$imageBaseURL}/original/{$tvData->backdrop_path}" : '';
        @endphp
        <img class="w-full h-screen absolute object-cover lg:object-fill" src="{{ $backdropPath }}" alt="">
        <div class="w-full h-screen absolute bg-black bg-opacity-60 z-10"></div>

        <!-- Menu Section -->
        <div class="w-full bg-transparent h-[96px] drop-shadow-lg flex flex-row items-center z-10">
            <div class="w-1/3 pl-5">
                <a href="/movies"
                    class="uppercase text-base mx-5 text-white hover:text-movie-500 duration-200 font-inter">Movies</a>
                <a href="/tv-shows"
                    class="uppercase text-base mx-5 text-white hover:text-movie-500 duration-200 font-inter">TV
                    Shows</a>
            </div>
            <div class="w-1/3 flex items-center justify-center"><a href="/"
                    class="font-bold text-4xl font-quicksand text-white hover:text-movie-500 duration-200">MOVIES
                    PORTFOLIO</a></div>
            <div class="w-1/3 flex flex-row justify-end pr-10">
                <a href="/search" class="group">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32"
                        viewBox="0 0 50 50">
                        <path
                            d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"
                            class="fill-white group-hover:fill-movie-500 duration-200">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
        @php
            $title = '';
            $tagline = '';
            $year = '';
            $duration = '';
            $rating = 0;
            
            if ($tvData) {
                $title = $tvData->name;
                $originalDate = $tvData->first_air_date;
                $timestamp = strtotime($originalDate);
                $year = date('Y', $timestamp);
                $rating = (int) ($tvData->vote_average * 10);
            
                if ($tvData->tagline) {
                    $tagline = $tvData->tagline;
                } else {
                    $tagline = $tvData->overview;
                }
            
                if ($tvData->episode_run_time) {
                    $runtime= $tvData->episode_run_time[0];
                    $duration = "{$runtime}m / episode";
                }
            }
            // 2 * phi * r. r = 32 px (membentuk lingkaran)
            $circumference = ((2 * 22) / 7) * 32;
            $progressRating = $circumference - ($rating / 100) * $circumference;
            
            $trailerID = '';
            if (isset($tvData->videos->results)) {
                foreach ($tvData->videos->results as $item) {
                    if (strtolower($item->type) == 'trailer') {
                        $trailerID = $item->key;
                    }
                }
            }
        @endphp
        <!-- Content Section -->
        <div class="w-full h-full z-10 flex flex-col justify-center px-20">
            {{-- title --}}
            <span class="font-quicksand font-bold text-6xl mt-4 text-white">{{ $title }}</span>
            {{-- tagline --}}
            <span
                class="font-inter font-italic text-2xl mt-4 max-w-3xl line-clamp-5 text-white">{{ $tagline }}</span>

            <div class="flex flex-row mt-4 items-center">
                {{-- Rating --}}
                <div class="w-20 h-20 rounded-full flex items-center justify-center mr-4" style="background: #00304D">
                    <svg class="-rotate-90 w-20 h-20">
                        <circle style="color:#004F80;" stroke-width="8" stroke="currentColor" fill="transparent"
                            r="32" cx="40" cy="40" />
                        <circle style="color:#6FCF97;" stroke-width="8" stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $progressRating }}" stroke-linecap="round" stroke="currentColor"
                            fill="transparent" r="32" cx="40" cy="40" />
                    </svg>

                    <span class="absolute font-inter font-bold text-xl text-white">{{ $rating }}%</span>
                </div>
                {{-- Year --}}
                <span
                    class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2 mr-4">{{ $year }}</span>
                {{-- Duration --}}
                @if ($duration)
                    <span
                        class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2">{{ $duration }}</span>
                @endif
            </div>
            {{-- Play Trailer --}}
            @if ($trailerID)
                <button
                    class="w-fit bg-movie-500 text-white pl-4 pr-6 py-3 mt-5 font-inter text-xl flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200"
                    onclick="showTrailer(true)">
                    <svg fill="#ffffff" height="20" width="20" version="1.1" id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 210 210" xml:space="preserve">
                        <path d="M179.07,105L30.93,210V0L179.07,105z" />
                    </svg>
                    <span>Play Trailer</span>
                </button>
            @endif
        </div>

        <!-- Trailer Section -->
        <div id="trailerWrapper" class="absolute z-10 w-full h-screen p-20 bg-black flex flex-col">
            <button class="ml-auto group mb-4" onclick="showTrailer(false)">
                <svg xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                    <path
                        d="M 9.15625 6.3125 L 6.3125 9.15625 L 22.15625 25 L 6.21875 40.96875 L 9.03125 43.78125 L 25 27.84375 L 40.9375 43.78125 L 43.78125 40.9375 L 27.84375 25 L 43.6875 9.15625 L 40.84375 6.3125 L 25 22.15625 Z"
                        class="fill-white group-hover:fill-movie-500 duration-200" />

                </svg>
            </button>

            <iframe id="youtubeVideo" class="w-full h-full"
                src="https://www.youtube.com/embed/{{ $trailerID }}?enablejsapi=1" frameborder="0"
                title="{{ $tvData->name }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscrope; picture-in-picture; web-share;"></iframe>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // Hide trailer
        $("#trailerWrapper").hide();

        function showTrailer(isVisible) {
            if (isVisible) {
                $("#trailerWrapper").show();
            } else {
                // Stop youtube video
                $("#youtubeVideo")[0].contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');

                // Hide trailer
                $("#trailerWrapper").hide();
            }
        }
    </script>
</body>

</html>
