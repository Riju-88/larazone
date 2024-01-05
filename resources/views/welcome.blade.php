<x-app-layout>
 
    {{--  --}}
    <div class="hero min-h-screen" style="background-image: url({{ asset('storage/images/hero_bg.jpg') }});">
        <div class="hero-overlay bg-opacity-80 "></div>
        <div class="hero-content text-center backdrop-blur-sm">
          <div class="max-w-full">
            <h1 class="text-5xl font-bold">Welcome to {{ config('app.name', 'LaraZone') }} Forum</h1>
           
            <p class="text-2xl md:text-4xl my-4">Discover a vibrant community of knowledge seekers and enthusiasts in this Laravel-powered discussion platform.
        Explore a wide range of categories covering diverse topics, where users can engage in meaningful discussions and exchange valuable insights.</p>
        @if(!auth()->check())
       
        <div class="flex items-center justify-center space-x-4">
            <a href="{{ route('register') }}" class="btn btn-secondary rounded-full">Join the Community</a>
            <a href="{{ route('login') }}" class="btn btn-primary font-[1100] rounded-full">Login</a>
        </div>
        @endif
          </div>
        </div>
      </div>

      {{--  --}}
     
</x-app-layout>