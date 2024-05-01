<div class="flex flex-col items-center w-3/4 h-auto gap-4 px-12 py-8 border-r-2 border-yellow-400">
    <span class="text-4xl font-bold text-yellow-500">Welcome to PLM Online Admission</span>

    <img src="{{ asset('assets/image/plm.png') }}" class="w-3/4 h-auto">

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            About PLM Admission
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            Who May Apply
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            How To Apply
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
        </div>
    </div>

    <div x-data="{ open: false }" class="flex flex-col w-5/6 h-auto px-6 py-4 bg-gray-200 rounded shadow-l gap-7">
        <button @click="open = !open" class="flex flex-row justify-between text-2xl focus:outline-none">
            Available Programs
            <div>
                <span x-show="!open">+</span>
                <span x-show="open">&ndash;</span>
            </div>
        </button>
        
        <div x-show="open" x-collapse>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos aut hic excepturi possimus, et commodi nisi dolores rem quidem fuga eveniet, quibusdam eligendi vero odit voluptates dolorem aliquam illo velit maxime voluptatem, illum corrupti amet! Suscipit ducimus sapiente voluptate eum dolorum debitis sed cum, aspernatur quaerat optio. Possimus ratione adipisci corporis, temporibus, itaque hic ad officia similique sit nemo est nam unde numquam laborum animi repudiandae. Id illo autem sunt dignissimos ducimus consequatur quo nemo, adipisci temporibus. Ipsum dolores dolorum nemo saepe nulla fugit omnis necessitatibus itaque, cum voluptate eaque ad quas quam, impedit ex maxime qui laboriosam alias animi?</span>
        </div>
    </div>
</div>

<div class="flex flex-col items-center w-1/4 h-auto gap-10 px-2 py-8">
    <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">PLM Online Admission</span>
        </div>

        <div class="px-5 py-3">
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-2">
                        <label class="block text-gray-700 text-m">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="block text-gray-700 text-m">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-500">
                        </div>
                    </div>

                    <a href="#" class="text-gray-700">Forgot your password?</a>

                    <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-11/12 h-auto overflow-hidden bg-gray-100 border-2 border-yellow-400 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">Important Dates</span>
        </div>
        
        <div class="flex flex-col gap-3 px-5 py-3">
            <div class="flex flex-row gap-3">
                <span class="font-bold">{{ $start->date }}:</span>
                <span>Start of Application</span>
            </div>
            
            <div class="flex flex-row gap-3">
                <span class="font-bold">{{ $end->date }}:</span>
                <span>End of Application</span>
            </div>
        </div>
    </div>

    <div class="w-11/12 overflow-hidden bg-gray-100 border-2 border-yellow-400 h-96 rounded-xl">
        <div class="h-auto px-5 py-3 bg-blue-800 border-b-2 border-yellow-400">
            <span class="text-2xl font-bold text-white ">Advisory</span>
        </div>
        
        <div class="flex flex-col gap-3 px-5 py-3 overflow-x-hidden overflow-y-scroll h-5/6 ">
            @foreach($announcements as $announcement)
                <div class="flex flex-col gap-2 pb-3 border-b-2 border-yellow-400">
                        <h3 class="font-bold">{{ $announcement->date }}</h3>
                        
                        <p>{{ $announcement->announcement }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>