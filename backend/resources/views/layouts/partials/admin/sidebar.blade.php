@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-circle-user',
            'route' => 'dashboard',
            'active' => request()->routeIs('dashboard')
        ],
        [
            'name' => 'Users',
            'icon' => 'fa-solid fa-users',
            'route' => 'admin.users.index',
            'active' => request()->routeIs('admin.users.*')
        ],
        [
            'name' => 'Permissions',
            'icon' => 'fa-solid fa-key',
            'route' => 'admin.permissions.index',
            'active' => request()->routeIs('admin.permissions.*')
        ],
        [
            'name' => 'Roles',
            'icon' => 'fa-solid fa-user-shield',
            'route' => 'admin.roles.index',
            'active' => request()->routeIs('admin.roles.*')
        ],
        [
            'name' => 'Student Profiles',
            'icon' => 'fa-solid fa-id-card',
            'route' => 'admin.student-profiles.index',
            'active' => request()->routeIs('admin.student-profiles.*')
        ],
        [
            'name' => 'Rotations',
            'icon' => 'fa-solid fa-repeat',
            'route' => 'admin.rotations.index',
            'active' => request()->routeIs('admin.rotations.*')
        ],
        [
            'name' => 'Student Rotations',
            'icon' => 'fa-solid fa-people-arrows',
            'route' => 'admin.student-rotations.index',
            'active' => request()->routeIs('admin.student-rotations.*')
        ],
        [
            'name' => 'Questionnaires',
            'icon' => 'fa-solid fa-file-circle-question',
            'route' => 'admin.questionnaires.index',
            'active' => request()->routeIs('admin.questionnaires.*')
        ],
        [
            'name' => 'Questionnaire Items',
            'icon' => 'fa-solid fa-list',
            'route' => 'admin.questionnaire-items.index',
            'active' => request()->routeIs('admin.questionnaire-items.*')
        ],
        [
            'name' => 'Questionnaire Choices',
            'icon' => 'fa-solid fa-check-double',
            'route' => 'admin.questionnaire-choices.index',
            'active' => request()->routeIs('admin.questionnaire-choices.*')
        ],
        [
            'name' => 'Questionnaire Responses',
            'icon' => 'fa-solid fa-clipboard-check',
            'route' => 'admin.questionnaire-responses.index',
            'active' => request()->routeIs('admin.questionnaire-responses.*')
        ],
        [
            'name' => 'State Reports',
            'icon' => 'fa-solid fa-flag',
            'route' => 'admin.state-reports.index',
            'active' => request()->routeIs('admin.state-reports.*')
        ],
        [
            'name' => 'Chatbot Interactions',
            'icon' => 'fa-solid fa-robot',
            'route' => 'admin.chatbot-interactions.index',
            'active' => request()->routeIs('admin.chatbot-interactions.*')
        ],
        [
            'name' => 'Chatbot Alerts',
            'icon' => 'fa-solid fa-bell',
            'route' => 'admin.chatbot-alerts.index',
            'active' => request()->routeIs('admin.chatbot-alerts.*')
        ],
        [
            'name' => 'Professionals',
            'icon' => 'fa-solid fa-user-tie',
            'route' => 'admin.professionals.index',
            'active' => request()->routeIs('admin.professionals.*')
        ],
        [
            'name' => 'Appointments',
            'icon' => 'fa-solid fa-calendar-check',
            'route' => 'admin.appointments.index',
            'active' => request()->routeIs('admin.appointments.*')
        ],
        [
            'name' => 'Resources',
            'icon' => 'fa-solid fa-folder-open',
            'route' => 'admin.resources.index',
            'active' => request()->routeIs('admin.resources.*')
        ],
        [
            'name' => 'Posts',
            'icon' => 'fa-solid fa-newspaper',
            'route' => 'admin.posts.index',
            'active' => request()->routeIs('admin.posts.*')
        ],
        [
            'name' => 'Comments',
            'icon' => 'fa-solid fa-comments',
            'route' => 'admin.comments.index',
            'active' => request()->routeIs('admin.comments.*')
        ],
        [
            'name' => 'Post Votes',
            'icon' => 'fa-solid fa-thumbs-up',
            'route' => 'admin.post-votes.index',
            'active' => request()->routeIs('admin.post-votes.*')
        ],
        [
            'name' => 'Post Tags',
            'icon' => 'fa-solid fa-tags',
            'route' => 'admin.post-tags.index',
            'active' => request()->routeIs('admin.post-tags.*')
        ],
        [
            'name' => 'Files',
            'icon' => 'fa-solid fa-file',
            'route' => 'admin.files.index',
            'active' => request()->routeIs('admin.files.*')
        ],
        [
            'name' => 'Notifications',
            'icon' => 'fa-solid fa-bell',
            'route' => 'admin.notifications.index',
            'active' => request()->routeIs('admin.notifications.*')
        ],
        [
            'name' => 'Audit Logs',
            'icon' => 'fa-solid fa-clipboard-list',
            'route' => 'admin.audit-logs.index',
            'active' => request()->routeIs('admin.audit-logs.*')
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
