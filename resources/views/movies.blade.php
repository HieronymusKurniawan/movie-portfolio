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
    <!-- Header Section -->
    @include('header')
    <!-- End Header Section -->

    <!-- Sort Section -->
    <div class="ml-28 mt-8 flex flex-row items-center">
        <span class="font-inter font-bold text-xl">Sort</span>
        <div class="relative ml-4 ">
            <select onchange="changeSort(this)"
                class="block appearance-none bg-white drop-shadow-[0_0px_4px_rgba(0,0,0,0.25)] text-black font-inter py-3 pl-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white">
                <option value="popularity.desc">Popularity (Descending)</option>
                <option value="popularity.asc">Popularity (Ascending)</option>
                <option value="vote_average.desc">Top Rated (Descending)</option>
                <option value="vote_average.asc">Top Rated (Ascending)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg height="32" width="32"viewBox="0 0 32 50" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 20l10 10 10-10z" />
                    <path d="M0 0h48v48h-48z" fill="none" />
                </svg>
            </div>
        </div>
    </div>
    <!-- End Sort Section -->

    <!-- Content Section -->
    <div class="w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5" id="dataWrapper">
        @foreach ($movies as $movieItem)
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
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            fill="#38B6FF" stroke="#38B6FF">
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
    <!-- End Content Section -->

    <!-- Data Loader -->
    <div class="w-full pl-28 pr-10 flex justify-center mb-5" id="autoLoad">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="50px"
            height="50px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="50" cy="50" fill="none" stroke="#020202" stroke-width="5" r="35"
                stroke-dasharray="164.93361431346415 56.97787143782138">
                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s"
                    values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
            </circle>
        </svg>
    </div>
    <!-- End Data Loader -->

    <!-- Error Notification -->
    <div id="notification"
        class="min-w-[250px] p-4 bg-red-700 text-white text-center rounded-lg fixed z-index-10 top-0 right-0 mr-10 mt-5 drop-shadow-lg">
        <span id="notificationMessage"></span>
    </div>
    <!-- End Error Notification -->

    <!-- Load more -->
    <div class="w-full pl-28 pr-10" id="loadMore">
        <button
            class="w-full mb-10 bg-movie-500 text-white p-4 font-inter font-bold rounded-xl uppercase drop-shadow-lg"
            onclick="loadMore()">Load More</button>
    </div>
    <!-- End Load more -->

    <!-- Footer Section -->
    @include('footer')
    <!-- End Footer Section -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        let baseURL = "<?php echo $baseURL; ?>";
        let imageBaseURL = "<?php echo $imageBaseURL; ?>";
        let apiKey = "<?php echo $apiKey; ?>";
        let sortBy = "<?php echo $sortBy; ?>";
        let page = "<?php echo $page; ?>";
        let minimalVoter = "<?php echo $minimalVoter; ?>";

        // Hide loader
        $("#autoLoad").hide();

        // Hide notification
        $("#notification").hide();

        function loadMore() {
            $.ajax({
                    url: `${baseURL}/discover/movie?page=${++page}&sort_by=${sortBy}&api_key=${apiKey}&vote_count.gte=${minimalVoter}`,
                    type: "get",
                    beforeSend: function() {
                        // Show Loader
                        $("#autoLoad").show();
                    }
                })
                .done(function(response) {
                    // Hide loader
                    $("#autoLoad").hide();

                    // Get data
                    if (response.results) {
                        var htmlData = [];
                        response.results.forEach(element => {
                            let original_date = element.release_date;
                            let date = new Date(original_date);
                            let movieYear = date.getFullYear();
                            let movieID = element.id;
                            let movieTitle = element.title;
                            let movieImage = `${imageBaseURL}/w500${element.poster_path}`;
                            let movieRating = element.vote_average * 10;

                            htmlData.push(`<a href="movie/${movieID}" class="group">
                <div
                    class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                    <div class="overflow-hidden rounded-[32px]">
                        <img src=${movieImage} alt=""
                            class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                    </div>
                    <span
                        class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none"> ${movieTitle}</span>
                    <span class="font-inter text-sm mt-1">${movieYear}</span>
                    <div class="flex flex-row mt-1 items-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            fill="#38B6FF" stroke="#38B6FF">
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
                        <span class="font-inter text-sm ml-1">${movieRating}%</span>
                    </div>
                </div>
            </a>`);
                        });
                        $("#dataWrapper").append(htmlData.join(""));
                    }
                })
                .fail(function(jqHXR, ajaxOptions, thrownError) {
                    // Hide loader
                    $("#autoLoad").hide();

                    // Show notification
                    $("#notificationMessage").text("Terjadi kendala, coba beberapa saat lagi");
                    $("#notification").show();

                    // Set timeout
                    setTimeout(function() {
                        $("#notification").hide();
                    }, 3000);
                })

        }

        function changeSort(component) {
            if (component.value) {
                // Set new value
                sortBy = component.value;
                // Clear data
                $("#dataWrapper").html("");
                // Reset page value
                page = 0;

                // Get data
                loadMore();
            }
        }
    </script>
</body>

</html>
