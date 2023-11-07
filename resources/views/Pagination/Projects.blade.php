@if(isset($projects_paginate))
    <!-- resources/views/custom-pagination.blade.php -->

    @if ($projects_paginate->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between bg-gray-100">
            <ul class="pagination flex space-x-4 px-4 w-[100%] justify-center items-center">
                {{-- Previous Page Link --}}
                @if ($projects_paginate->onFirstPage())
                    <li class="absolute left-0 inline-flex items-center p-2 text-sm font-medium text-rose-500 border-t-2 border-rose-600 cursor-default">
                        <span class="flex items-center text-[18px]">
                            <i class='bx bx-left-arrow-alt text-[18px]'></i>ก่อนหน้า
                        </span>
                    </li>
                @else
                    <a href="{{ $projects_paginate->previousPageUrl() }}" rel="prev" class="absolute left-0 inline-flex items-center p-2 text-sm font-medium text-gray-500 border-t-2 border-gray-300 hover:bg-rose-100 hover:border-rose-600 hover:text-rose-600 focus:outline-none focus:ring ring-rose-300 focus:border-rose-300 active:text-rose-700 transition ease-in-out duration-150" aria-label="@lang('pagination.previous')">
                        <span class="flex items-center text-[18px]">
                            <i class='bx bx-left-arrow-alt text-[18px]'></i>ก่อนหน้า
                        </span>
                    </a>
                @endif

                {{-- Page Number Links --}}
                @php
                    $currentPage = $projects_paginate->currentPage();
                    $lastPage = $projects_paginate->lastPage();
                    $maxLinks = 7; // Maximum number of links to display in pagination
                    $halfMaxLinks = ceil($maxLinks / 2);
                    $start = max(1, min($currentPage - $halfMaxLinks, $lastPage - $maxLinks + 1));
                    $end = min($start + $maxLinks - 1, $lastPage);
                    $middleEllipsis = false;
                @endphp

                <div class="flex inline">
                    @if ($start > 1)
                        <li>
                            <a href="{{ $projects_paginate->url(1) }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 border-t-2 border-gray-300 hover:text-rose-600 hover:border-rose-600 focus:outline-none focus:ring ring-rose-300 focus:border-rose-300 active:border-rose-100 active:text-rose-700 transition ease-in-out duration-150">
                                1
                            </a>
                        </li>
                        @if ($start > 2)
                            <li>
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 cursor-default leading-5">
                                    ...
                                </span>
                            </li>
                        @endif
                    @endif

                    @foreach (range($start, $end) as $page)
                        @if ($page == $currentPage)
                            <li>
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-rose-600 border-t-2 border-rose-600">
                                    <p class="text-[18px]">{{ $page }}</p>
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $projects_paginate->url($page) }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 border-t-2 border-gray-300 hover:text-rose-600 hover:border-rose-600 focus:outline-none focus:ring ring-rose-300 focus:border-rose-300 active:border-rose-100 active:text-rose-700 transition ease-in-out duration-150">
                                    <p class="text-[18px]">{{ $page }}</p>
                                </a>
                            </li>
                        @endif

                        @if ($page == $start + $maxLinks - 1 && $page < $lastPage - 1)
                            <li>
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 cursor-default leading-5">
                                    <p class="text-[18px]">...</p>
                                </span>
                            </li>
                        @endif
                    @endforeach

                    @if ($end < $lastPage)
                        <li>
                            <a href="{{ $projects_paginate->url($lastPage) }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 border-t-2 border-gray-300 hover:text-rose-600 hover:border-rose-600 focus:outline-none focus:ring ring-rose-300 focus:border-rose-300 active:bg-rose-100 active:text-rose-700 transition ease-in-out duration-150">
                                {{ $lastPage }}
                            </a>
                        </li>
                    @endif
                </div>

                {{-- Next Page Link --}}
                @if ($projects_paginate->hasMorePages())
                    <a href="{{ $projects_paginate->nextPageUrl() }}" rel="next" class="absolute right-0 inline justify-center items-center w-[104.48px] px-2 py-2 text-sm font-medium text-gray-500 border-t-2 border-gray-300 hover:bg-rose-100 hover:border-rose-600 hover:text-rose-600 focus:outline-none focus:ring ring-rose-300 focus:border-rose-300 active:text-rose-700 transition ease-in-out duration-150" aria-label="@lang('pagination.next')">
                        <span class="flex items-center text-[18px]">
                            ถัดไป<i class='bx bx-right-arrow-alt text-[18px]'></i>
                        </span>
                    </a>
                @else
                    <li class="absolute right-0 inline justify-center items-center w-[104.48px] px-2 py-2 text-sm font-medium text-rose-500 border-t-2 border-rose-600 cursor-default ">
                        <span class="flex items-center text-[18px]">
                            ถัดไป<i class='bx bx-right-arrow-alt text-[18px]'></i>
                        </span>
                    </li>
                @endif

                <!-- <div class="text-sm text-gray-500 leading-5">
                    Showing {{ $projects_paginate->firstItem() }} to {{ $projects_paginate->lastItem() }} of {{ $projects_paginate->total() }} results
                </div> -->
            </ul>
        </nav>
    @endif

@endif