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
    <div class="w-full h-auto min-h-screen flex flex-col">
        <!-- Header Section -->
        @include('header')
        <!-- End Header Section -->

        <!-- Search wrapper -->
        <div class="w-full h-auto min-h-screen">
            <!-- Search input -->
            <div class="w-full pl-10 lg:pl-20 pr-10 lg:pr-0">
                <div class="relative w-full lg:w-80 mt-10 mb-5 bg-white drop-shadow-[0_0px_4px_rgba(0,0,0,0.25)]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 50 50">
                            <path
                                d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"
                                class="fill-black group-hover:fill-movie-500 duration-200">
                            </path>
                        </svg>
                    </div>
                    <input type="search" id="searchInput"
                        class="block w-full p-8 lg:p-4 pl-12 lg:pl-10 text-2xl lg:text-sm text-black focus:outline-none"
                        placeholder="Search..." required>
                </div>
            </div>

            <!-- Content section -->
            <div class="w-auto pl-28 pr-10 pt-6 pb-10 grid grid-cols-3 lg:grid-cols-5 gap-5" id="dataWrapper">
                <!-- Wait from AJAX -->
            </div>
            <!-- End Content section -->

            <!-- Data Loader -->
            <div class="w-full pl-28 pr-10 flex justify-center mb-5" id="autoLoad">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;"
                    width="50px" height="50px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="#020202" stroke-width="5"
                        r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                            dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
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
        </div>
        <!-- End Search wrapper -->

        <!-- Footer Section -->
        @include('footer')
        <!-- End Footer Section -->
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        let baseURL = "<?php echo $baseURL; ?>";
        let imageBaseURL = "<?php echo $imageBaseURL; ?>";
        let apiKey = "<?php echo $apiKey; ?>";
        let searchKeyword = "";

        // Hide loader
        $("#autoLoad").hide();

        // Hide notification
        $("#notification").hide();

        $('#searchInput').keypress(function(event) {
            var key = event.which;
            if (key == 13) { // 13 adalah kode untuk 'enter' atau ketika user menekan enter
                searchKeyword = $('#searchInput').val(); // cek apakah ada valuenya
                if (searchKeyword) {
                    search();
                }
                return false;
            }
        });

        function search() {
            $.ajax({
                    url: `${baseURL}/search/multi?page=1&api_key=${apiKey}&query=${searchKeyword}`,
                    type: "get",
                    beforeSend: function() {
                        // Show Loader
                        $("#autoLoad").show();

                        // Clear content
                        $("#dataWrapper").html("");
                    }
                })
                .done(function(response) {
                    // Hide loader
                    $("#autoLoad").hide();

                    if (response.results) {
                        var htmlData = [];
                        response.results.forEach(element => {
                            if (element.media_type == 'movie' || element.media_type == 'tv') {
                                let searchTitle = "";
                                let original_date = "";
                                let detailsURL = "";

                                if (element.media_type == 'movie') {
                                    detailsURL = `/movie/${element.id}`;
                                    original_date = element.release_date;
                                    searchTitle = element.title;
                                } else {
                                    detailsURL = `/tv/${element.id}`;
                                    original_date = element.first_air_date;
                                    searchTitle = element.name;
                                }

                                let date = new Date(original_date);
                                let searchYear = date.getFullYear();
                                let searchImage = element.poster_path ?
                                    `${imageBaseURL}/w500${element.poster_path}` :
                                    `https://via.placeholder.com/300x400`;
                                let searchRating = Math.floor(element.vote_average * 10);

                                htmlData.push(`<a href="${detailsURL}" class="group">
                <div
                    class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                    <div class="overflow-hidden rounded-[32px]">
                        <img src=${searchImage} alt=""
                            class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200">
                    </div>
                    <span
                        class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none"> ${searchTitle}</span>
                    <span class="font-inter text-sm mt-1">${searchYear}</span>
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
                        <span class="font-inter text-sm ml-1">${searchRating}%</span>
                    </div>
                </div>
            </a>`);
                            }
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
    </script>
</body>

</html>
