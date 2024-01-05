<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
    <script type="text/javascript" src="{{ asset('js/trix.umd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/trix.custom.js') }}"></script>

    {{--  --}}

    {{-- google fonts icons --}}

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        /* Google Material Icons */
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 800,
                'GRAD' 0,
                'opsz' 24
        }

        .material-symbols-filled {
            font-variation-settings:
                'FILL' 1,
                'wght' 500,
                'GRAD' 0,
                'opsz' 24
        }

        .material-symbols-outlined-thin {
            font-variation-settings:
                'FILL' 0,
                'wght' 300,
                'GRAD' 0,
                'opsz' 24
        }

        /* trix editor */
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;

        }

        trix-toolbar .trix-button-group-spacer {

            flex-grow: initial !important;
        }

        trix-toolbar .trix-button-row {
            justify-content: flex-start;
        }

        trix-toolbar .trix-button-group {
            background-color: rgb(219, 223, 223)
        }

        trix-editor div {
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        spoiler:hover {
            background-color: initial !important;
            color: white !important;
        }

        /* pagination */
        .pagination-container nav div div p.text-sm.text-gray-700.leading-5 {
            margin: 0 0.5rem;
        }

        .scrolled {
            transform: translateY(-16px);
            transition: transform 300ms;
        }

        .scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 20px;
        }

        .scrollbar::-webkit-scrollbar-track {
            /* border-radius: 100vh; */
            /* background: #f7f4ed; */
            border: 2px solid #fc0b53;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background: #fc0b53;
            /* border-radius: 100vh; */
            /* border: 3px solid #f6f7ed; */
        }

        .scrollbar::-webkit-scrollbar-thumb:hover {
            background: #f7b80a;
        }

        option {
            padding: 1rem;
            font-size: 1.5rem;
            background-color: red;


        }
    </style>

    
    <title>{{ config('app.name', 'LaraZone') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased scrollbar" id="content-container">
    <div>
        {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900"> --}}
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class=" shadow">
                <div class="max-w-7xl mx-auto p-4">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            
            {{ $slot }}
        </main>
    </div>

  
    <footer class=" footer footer-center p-4 bg-neutral text-base-content mt-auto">
        <aside>
            <p>Copyright © 2023 - {{ date('Y') }} by <a href="{{ route('dashboard') }}"  class="hover:underline">{{ config('app.name', 'LaraZone') }}</a> </p>
        </aside>
    </footer>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentContainer = document.getElementById('content-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Handle AJAX request for links
            const links = document.querySelectorAll('.ajax-link');
            links.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    handleAjaxRequest(link.getAttribute('href'), 'GET');
                });
            });

            // Handle AJAX request for forms
            const forms = document.querySelectorAll('.ajax-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const action = form.getAttribute('action');
                    const method = 'POST';
                    const formData = new FormData(form);

                    fetch(action, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: formData,
                        })
                        .then(response => response.text())
                        .then(html => {
                            contentContainer.innerHTML = html;
                            // window.history.pushState(null, null, action);
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                        });
                });
            });


            // Common function to handle AJAX requests
            function handleAjaxRequest(url, method) {
                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                    .then(response => response.text())
                    .then(html => {
                        contentContainer.innerHTML = html;
                        // window.history.pushState(null, null, url);
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            }
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentContainer = document.getElementById('content-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function handleAjaxRequest(url, method) {
                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                    .then(response => response.text())
                    .then(html => {
                        contentContainer.innerHTML = html;
                        // window.history.pushState(null, null, url);
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            }

            document.body.addEventListener('click', function(event) {
                const target = event.target.closest('a.ajax-link');
                if (target) {
                    event.preventDefault();
                    handleAjaxRequest(target.getAttribute('href'), 'GET');
                }
            });

            document.body.addEventListener('submit', function(event) {
                if (event.target.classList.contains('ajax-form')) {
                    event.preventDefault();
                    const form = event.target;
                    const action = form.getAttribute('action');
                    const method = 'POST';
                    const formData = new FormData(form);

                    fetch(action, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: formData,
                        })
                        .then(response => response.text())
                        .then(html => {
                            contentContainer.innerHTML = html;
                            // window.history.pushState(null, null, action);
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                        });
                }
            });
        });
    </script>


    <script>
        // window.addEventListener('scroll', function() {
        //     var nav = document.querySelector('nav');
        //     nav.classList.toggle('scrolled', window.scrollY > 0);
        // });

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            let prevScrollPos = window.scrollY;
            const handleScroll = function() {
                const currentScrollPos = window.scrollY;
                if (prevScrollPos > currentScrollPos) {
                    nav.style.transform = "translateY(0)";
                } else {
                    nav.style.transform = "translateY(-80px)";
                }
                prevScrollPos = currentScrollPos;
            };

            window.addEventListener('scroll', handleScroll);

            return function() {
                window.removeEventListener('scroll', handleScroll);
            };
        });
    </script>

</body>

</html>
