<html>

<head>
    <title>MOVIE PORTFOLIO</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-auto min-h-screen flex flex-col">
        <!-- Header Section -->
        @include('header')
        <!-- End Header Section -->

        <!-- Banner Section -->
        @include('banner')
        <!-- End Banner Section -->

        <!-- Top 10 Movies Section -->
        <div class="mt-12">
            <span class="ml-28 font-inter font-bold text-xl">
                Top 10 Movies
            </span>
            <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
                @foreach ($topMovies as $movieItem)
                    @php
                        $original_date = $movieItem->release_date;
                        $timestamp = strtotime($original_date);
                        $movieYear = date('Y', $timestamp);

                        $movieID = $movieItem->id;
                        $movieTitle = $movieItem->title;
                        $movieRating = $movieItem->vote_average * 10;
                        $movieImage = "{$imageBaseURL}/w500{$movieItem->poster_path}";
                    @endphp
                    <a href="movie/{{ $movieID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                            <div class="overflow-hidden rounded-[32px]">
                                <img src={{ $movieImage }} alt=""
                                    class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                            </div>
                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $movieTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $movieYear }}</span>
                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" fill="#38B6FF" stroke="#38B6FF">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title></title>
                                        <g id="Complete">
                                            <g id="thumbs-up">
                                                <path
                                                    d="M7.3,11.4,10.1,3a.6.6,0,0,1,.8-.3l1,.5a2.6,2.6,0,0,1,1.4,2.3V9.4h6.4a2,2,0,0,1,1.9,2.5l-2,8a2,2,0,0,1-1.9,1.5H4.3a2,2,0,0,1-2-2v-6a2,2,0,0,1,2-2h3v10"
                                                    fill="none" stroke="#38B6FF" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="font-inter text-sm ml-1">{{ $movieRating }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <!-- End Top 10 Movies Section -->

        <!-- Top 10 TV Shows Section -->
        <div class="mt-12">
            <span class="ml-28 font-inter font-bold text-xl">
                Top 10 TV Shows
            </span>
            <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
                @foreach ($topTVShows as $tvShowsItem)
                    @php
                        $original_date = $tvShowsItem->first_air_date;
                        $timestamp = strtotime($original_date);
                        $tvShowsYear = date("Y", $timestamp);

                        $tvShowsID = $tvShowsItem->id;
                        $tvShowsTitle = $tvShowsItem->name;
                        $tvShowsRating = $tvShowsItem->vote_average * 10;
                        $tvShowsImage = "{$imageBaseURL}/w500{$tvShowsItem->poster_path}";
                    @endphp

                    <a href="tv/{{ $tvShowsID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                            <div class="overflow-hidden rounded-[32px]">
                                <img src={{ $tvShowsImage }} alt=""
                                    class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                            </div>
                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $tvShowsTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $tvShowsYear }}</span>
                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" fill="#38B6FF" stroke="#38B6FF">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title></title>
                                        <g id="Complete">
                                            <g id="thumbs-up">
                                                <path
                                                    d="M7.3,11.4,10.1,3a.6.6,0,0,1,.8-.3l1,.5a2.6,2.6,0,0,1,1.4,2.3V9.4h6.4a2,2,0,0,1,1.9,2.5l-2,8a2,2,0,0,1-1.9,1.5H4.3a2,2,0,0,1-2-2v-6a2,2,0,0,1,2-2h3v10"
                                                    fill="none" stroke="#38B6FF" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="font-inter text-sm ml-1">{{ $tvShowsRating }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <!-- End Top 10 TV Shows Section -->
    </div>

    <script>
        // Default active slide
        let slideIndex = 1;
        showSlide(slideIndex);

        function showSlide(position) {
            let index;
            const slidesArray = document.getElementsByClassName("slide");
            const dotsArray = document.getElementsByClassName("dot");

            // Looping effect
            if (position > slidesArray.length) {
                slideIndex = 1;
            }
            if (position < 1) {
                slideIndex = slidesArray.length;
            }

            // Hide active slide
            for (index = 0; index < slidesArray.length; index++) {
                slidesArray[index].classList.add('hidden');
            }

            // Show active slide
            slidesArray[slideIndex - 1].classList.remove('hidden');

            // Remove active status
            for (index = 0; index < dotsArray.length; index++) {
                dotsArray[index].classList.remove('bg-movie-500');
                dotsArray[index].classList.add('bg-white');
            }

            // Set active status
            dotsArray[slideIndex - 1].classList.remove('bg-white');
            dotsArray[slideIndex - 1].classList.add('bg-movie-500');
        }

        function moveSlide(moveStep) {
            showSlide(slideIndex += moveStep);
        }

        function currentSlide(position) {
            showSlide(slideIndex = position);
        }
    </script>

</body>

</html>
