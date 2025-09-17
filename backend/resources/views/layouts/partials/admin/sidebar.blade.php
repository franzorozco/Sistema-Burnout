@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-circle-user', 
            'route' => 'admin.dashboard',
            'active' => request()->routeIs('admin.dashboard')
        ],
    ];
@endphp

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r border-gray-200 shadow-lg">

    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                <li>
                    <a href="{{ route($link['route']) }}" class="flex items-center p-2 text-gray-900 rounded-lg {{ $link['active'] ? 'bg-gray-100' : '' }}">
                        <span class="w-5 h-5 inline-flex justify-center items-center">
                            <i class="{{ $link['icon'] }} text-gray-500"></i>
                        </span>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ $link['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
