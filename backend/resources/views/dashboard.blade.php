<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <div class="bg-white bg-opacity-90 overflow-hidden shadow-lg rounded-2xl">
                <div class="p-6 text-gray-900">
                    <span class="font-semibold">¡Hola, {{ Auth::user()->name }}!</span>
                    {{ __("You're logged in!") }} Has iniciado sesión correctamente en el sistema.
                </div>
            </div>

            <div class="bg-white shadow-2xl overflow-hidden rounded-2xl p-8 sm:p-10">
                <div class="flex flex-col md:flex-row items-center md:space-x-8">
                    <div class="flex-shrink-0 mb-6 md:mb-0">
                        <svg class="w-24 h-24 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.056 3 12s4.03 8.25 9 8.25Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 11.033c.504 0 .952.122 1.357.34l.843-.843A4.5 4.5 0 0 0 7.5 9.75c-2.485 0-4.5 1.79-4.5 4s2.015 4 4.5 4c.673 0 1.316-.12 1.912-.338l-.843-.843a2.991 2.991 0 0 1-1.357-.34c-.504 0-.952-.122-1.357-.34a2.991 2.991 0 0 1-1.357-.34c-.504 0-.952-.122-1.357-.34Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.879 11.033c.504 0 .952.122 1.357.34l.843-.843A4.5 4.5 0 0 0 13.5 9.75c-2.485 0-4.5 1.79-4.5 4s2.015 4 4.5 4c.673 0 1.316-.12 1.912-.338l-.843-.843a2.991 2.991 0 0 1-1.357-.34c-.504 0-.952-.122-1.357-.34a2.991 2.991 0 0 1-1.357-.34c-.504 0-.952-.122-1.357-.34Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900">
                            Conoce a tu Asistente Virtual
                        </h3>
                        <p class="mt-4 text-lg text-gray-700">
                            Estoy aquí para ayudarte a gestionar el estrés, entender tus emociones y prevenir el burnout. ¡Tu bienestar es mi prioridad!
                        </p>
                        <div class="mt-8">
                            {{-- Botón con el estilo degradado de tu login --}}
                            {{-- Apunta a la URL del frontend donde corre el chat --}}
                            <a href="http://127.0.0.1:8081/chat" target="_blank" rel="noopener noreferrer"
                               class="w-full md:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent rounded-lg shadow-lg text-base font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105"
                            >
                                Iniciar Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="text-2xl font-bold text-white px-1 sm:px-0">
                Explora tus recursos
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white shadow-2xl rounded-2xl p-6 flex flex-col items-center text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-16 h-16 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18V7.875c0-.621.504-1.125 1.125-1.125H6.75M16.5 6.75h-3v3h3v-3Z" />
                    </svg>
                    <h5 class="text-xl font-bold text-gray-900 mt-4">Blog</h5>
                    <p class="text-gray-700 mt-2 text-sm flex-grow">
                        Lee las últimas entradas, consejos y reflexiones sobre salud mental y bienestar.
                    </p>
                    <a href="http://127.0.0.1:3000/blog" target="_blank" rel="noopener noreferrer" class="mt-6 text-sm font-semibold text-purple-600 hover:text-purple-800 transition-colors">
                        Ir al Blog &rarr;
                    </a>
                </div>

                <div class="bg-white shadow-2xl rounded-2xl p-6 flex flex-col items-center text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-16 h-16 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h5 class="text-xl font-bold text-gray-900 mt-4">Artículos</h5>
                    <p class="text-gray-700 mt-2 text-sm flex-grow">
                        Encuentra artículos de interés y recursos validados por profesionales.
                    </p>
                    <a href="http://127.0.0.1:3000/articulos" target="_blank" rel="noopener noreferrer" class="mt-6 text-sm font-semibold text-purple-600 hover:text-purple-800 transition-colors">
                        Ver Artículos &rarr;
                    </a>
                </div>

                <div class="bg-white shadow-2xl rounded-2xl p-6 flex flex-col items-center text-center transition-all duration-300 transform hover:scale-105">
                    <svg class="w-16 h-16 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h3.75" />
                    </svg>
                    <h5 class="text-xl font-bold text-gray-900 mt-4">Test Rápido</h5>
                    <p class="text-gray-700 mt-2 text-sm flex-grow">
                        Evalúa tu estado de ánimo y nivel de estrés actual con este breve cuestionario.
                    </p>
                    {{-- Este es un botón primario, igual que el de Iniciar Chat pero más pequeño --}}
                    <a href="http://127.0.0.1:3000/test-rapido" target="_blank" rel="noopener noreferrer" class="mt-6 inline-flex justify-center items-center px-6 py-2 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                        Comenzar Test
                    </a>
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
