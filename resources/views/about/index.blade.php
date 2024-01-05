<x-app-layout>
    <x-slot name="header" class="mt-20">
           {{-- success message --}}
           @if (session('success'))
           <div class="alert alert-success">
               {{ session('success') }}
           </div>
       @endif
        <h2 class="font-semibold text-xl leading-tight mt-16 text-gray-400 mx-4">
            {{ __('About') }}
        </h2>
    </x-slot>

    <div class="min-h-screen">
        <div class="bg-gray-800 text-white p-8">
            <h1 class="text-4xl font-bold mb-4">🚀 Welcome to {{ config('app.name') }} - Where Curiosity Meets Connection! 🚀</h1>
            <p class="text-lg mb-6">Hello world! {{ config('app.name') }} is not just another forum; it's a digital haven for all curious minds, regardless of your background or interests.</p>
        </div>
        
        <div class="bg-gray-900 text-white p-8">
            <h2 class="text-2xl font-semibold mb-4">Why Choose {{ config('app.name') }}?</h2>
            <ul class="list-disc pl-6 mb-6">
                <li class="mb-2">⚡ <strong>Laravel-Powered Excellence:</strong> Harness the power of Laravel with {{ config('app.name') }}. Navigate a sleek interface, experience swift interactions, and immerse yourself in a forum crafted for the curious.</li>
                <li class="mb-2">✨ <strong>Diverse Community:</strong> Join a community that celebrates diversity, where everyone is welcome to share and explore their passions.</li>
                <li class="mb-2">🌐 <strong>Connecting Curious Minds:</strong> Dive into discussions about a variety of topics, from tech to art, science to gaming—whatever sparks your curiosity!</li>
                <li class="mb-2">🎮 <strong>Limitless Exploration:</strong> Beyond traditional forums, explore a space where boundaries are meant to be pushed. Connect, collaborate, and learn across various interests.</li>
                <li class="mb-2">🎨 <strong>Creative Expressions:</strong> Whether you're into design, coding, or any other form of creativity, {{ config('app.name') }} is the canvas for you to express yourself without limitations.</li>
                <li class="mb-2">📚 <strong>Learning Hub:</strong> Engage in conversations that foster growth, innovation, and learning. Share your knowledge and gain insights from others across diverse fields.</li>
                <li>🤝 <strong>Inclusive Connections:</strong> {{ config('app.name') }} unites individuals from all walks of life. Whether you're a tech enthusiast, an artist, or simply someone curious about the world, there's a place for you here!</li>
            </ul>
            <p class="text-lg mb-6">Ready to embark on a journey of exploration and connection? Sign up now and become part of a forum that embraces the diversity of interests and celebrates the uniqueness of every individual!</p>

            <h2 class="text-2xl font-semibold mb-4">About {{ config('app.name') }}</h2>
            <p class="text-lg">
                I created this project as a way to build my Laravel skills. I'm currently learning Laravel and its ecosystem.</p>

                <p class="text-lg">For any questions or feedback, contact me via <a href="https://www.facebook.com/rij88" class="text-primary link" target="_blank">facebook</a> or email  <a href="mailto:rijumistri4@gmail.com" class="text-primary underline">rijumistri4@gmail.com</a>.
                    <p class="text-lg"> Additionally, check out my <a href="https://exoticweb.vercel.app/" class="text-primary underline" target="_blank">portfolio</a> to explore more of my work. My resume can be found there too.</p>
            </p>
        </div>
        
    </div>
</x-app-layout>
