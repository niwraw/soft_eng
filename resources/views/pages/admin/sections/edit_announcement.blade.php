<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="antialiased">
        <div class="flex items-center justify-center w-screen h-screen">
            <div class="w-9/12 px-8 py-4 bg-gray-300 h-3/5 rounded-xl">
                <form method="POST" action="{{ route('admin.update.announcement', ['currentRoute' => $currentRoute, 'announcementId' => $announcement->id]) }}">
                    @csrf
                    <h1 class="mb-8 text-2xl">Edit Announcement</h1>

                    <div class="flex gap-4 mb-4">
                        <span class="font-bold">Date of the Announcement:</span>
                        <span>{{ $announcement->date }}</span>
                    </div>
                    
                    <div class="mb-10">
                        <x-input-label for="date" :value="__('Edit Date of Announcement')" />
                        <x-text-input id="date" class="block w-full mt-1" type="date" name="date" autofocus value=""/>
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                    <div class="flex gap-4 mb-4">
                        <span class="font-bold">Announcement:</span>
                        <span>{{ $announcement->announcement }}</span>
                    </div>

                    <div class="mb-10">
                        <x-input-label for="announcement" :value="__('Edit Announcement')" />
                        <x-text-input id="announcement" class="w-full" type="text" name="announcement" value="" autofocus/>
                        <x-input-error :messages="$errors->get('announcement')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-4 px-4">
                        <div>
                            <button onclick="history.back()" class="px-4 py-1 text-white bg-red-600 rounded-lg">
                                Back
                            </button>
                        </div>

                        <div>
                            <button type="submit" onclick="confirmChange()" class="px-4 py-1 text-white bg-gray-700 rounded-lg">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script>
        function confirmChange() {
            return confirm('Are you sure you want to change the dates?');
        }
    </script>

</html>