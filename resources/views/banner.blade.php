<!-- Banner Screen -->
<div class="w-full h-[512px] flex flex-col relative bg-black">
    <!-- Banner Data -->
    @foreach ($banner as $bannerItem)
        @php
            $bannerImage = "{$imageBaseURL}/original{$bannerItem->backdrop_path}";
        @endphp
        <div class="flex flex-row items-center w-full h-full relative slide">
            <!-- Image -->
            <img src="{{ $bannerImage }}" class="absolute w-full h-full object-cover" alt="">
            <!-- Overlay-->
            <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

            <div class="w-10/12 flex flex-col ml-28 z-10">
                <span class="font-bold font-inter text-4xl text-white">{{ $bannerItem->title }}</span>
                <span class="font-inter text-xl text-white w-1/2 line-clamp-2">{{ $bannerItem->overview }}</span>
                <a href="/movie/{{ $bannerItem->id }}"
                    class="w-fit bg-movie-500 text-white pl-2 py-2 pr-4 mt-5 font-inter text-sm flex flex-row rounded-full items-center hover:shadow-lg duration-200">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M15 12.3301L9 16.6603L9 8L15 12.3301Z" fill="#ffff"></path>
                        </g>
                    </svg>
                    <span>Detail</span>
                </a>
            </div>
        </div>
    @endforeach


    <!-- Prev Button -->
    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">
        <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
        </button>
    </div>

    <!-- Next Button -->
    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">
        <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200 rotate-180">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
        </button>
    </div>

    <!-- Indicator -->
    <div class="absolute bottom-0 w-full mb-8">
        <div class="w-full flex flex-row items-center justify-center">
            @for ($pos = 1; $pos <= count($banner); $pos++)
                <div class="w-2 5 h-2.5 rounded-full mx-1 cursor-pointer dot" onclick="currentSlide({{ $pos }})"></div>
            @endfor

        </div>
    </div>
</div>
