<!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
<x-mainLayout>
    <div class="w-full h-full flex flex-cols lg:flex-cols-2 sm:flex-cols-1">
        <div class="w-1/5 bg-yellow-400">
                <div class="bg-gray-700 p-8">
                    <p class="text-center text-white">
                        CRM
                    </p>
                </div>
                <div class="flex-rows bg-gray-600">
                    <x-menuItem label="Dashboard" icon-path='fa fa-cloud' route-name='dashboard' class="hover:text-blue-500 text-white" />
                    <x-menuItem label="Users" icon-path='fa fa-cloud' route-name='users' class="hover:text-blue-500 text-white" />
                    <x-menuItem label="Clients" icon-path='fa fa-cloud' route-name='clients' class="hover:text-blue-500 text-white" />
                    <x-menuItem label="Projects" icon-path='fa fa-cloud' route-name='projects' class="hover:text-blue-500 text-white" />
                    <x-menuItem label="Tasks" icon-path='fa fa-cloud' route-name='tasks' class="hover:text-blue-500 text-white" />
                </div>
        </div>
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</x-mainLayout>