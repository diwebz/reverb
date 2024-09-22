<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  
            function app() {
                return {
                    showDatepicker: false,
                    datepickerValue: '',
  
                    month: '',
                    year: '',
                    no_of_days: [],
                    blankdays: [],
                    days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
  
                    initDate() {
                        let today = new Date();
                        this.month = today.getMonth();
                        this.year = today.getFullYear();
                        this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                    },
  
                    isToday(date) {
                        const today = new Date();
                        const d = new Date(this.year, this.month, date);
  
                        return today.toDateString() === d.toDateString() ? true : false;
                    },
  
                    getDateValue(date) {
                        let selectedDate = new Date(this.year, this.month, date);
                        this.datepickerValue = selectedDate.toDateString();
  
                        this.$refs.date.value = selectedDate.getFullYear() +"-"+ ('0'+ selectedDate.getMonth()).slice(-2) +"-"+ ('0' + selectedDate.getDate()).slice(-2);
  
                        console.log(this.$refs.date.value);
  
                        this.showDatepicker = false;
                    },
  
                    getNoOfDays() {
                        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
  
                        // find where to start calendar day of week
                        let dayOfWeek = new Date(this.year, this.month).getDay();
                        let blankdaysArray = [];
                        for ( var i=1; i <= dayOfWeek; i++) {
                            blankdaysArray.push(i);
                        }
  
                        let daysArray = [];
                        for ( var i=1; i <= daysInMonth; i++) {
                            daysArray.push(i);
                        }
  
                        this.blankdays = blankdaysArray;
                        this.no_of_days = daysArray;
                    }
                }
            }
        </script>

        {{-- <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('bookingNotification', () => ({
                    notifications: [],

                    init() {
                        Echo.private('reservations-channel')
                            .listen('ReservationCreated', (e) => {
                                this.notifications.push(`New booking created: ${e.reservations.res_name}`);
                            });
                    }
                }));
            });
        </script> --}}

        {{-- <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('bookingNotification', () => ({
                    notifications: [],

                    init() {
                        console.log("Listening to reservations-channel...");
                        Echo.private('reservations-channel')
                            .listen('ReservationCreated', (e) => {
                                console.log('ReservationCreated event received:', e);
                                this.notifications.push(`New booking created: ${e.reservations.res_no}`);
                            })
                            .error((error) => {
                                console.error("Error in Echo listening:", error);
                            });
                    }
                }));
            });
        </script> --}}

        {{-- <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('bookingNotification', () => ({
                    notifications: [],
                    receivedCount: 0, // Initialize the received count
        
                    init() {
                        console.log("Listening to reservations-channel...");
                        Echo.private('reservations-channel')
                            .listen('ReservationCreated', (e) => {
                                console.log('ReservationCreated event received:', e);
        
                                // Parse the reservation data
                                let reservationData = e.reservations;
        
                                // Add the new reservation notification
                                this.notifications.push(`New booking created: ${reservationData.res_no}`);
        
                                // Update the count of "Received" reservations
                                this.receivedCount = e.receivedCount;
                            })
                            .error((error) => {
                                console.error("Error in Echo listening:", error);
                            });
                    }
                }));
            });
        </script> --}}

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('bookingNotification', () => ({
                    notifications: [],
                    receivedCount: {{ $receivedCount }}, // Initialize with the passed count from Laravel
        
                    init() {
                        console.log("Listening to reservations-channel...");
        
                        // Listening to Laravel Echo for real-time updates
                        Echo.private('reservations-channel')
                            .listen('ReservationCreated', (e) => {
                                console.log('ReservationCreated event received:', e);
        
                                // Update the count of "Received" reservations with the real-time count
                                this.receivedCount = e.receivedCount; // Broadcast the updated count from server
        
                                // Add a notification for the new reservation
                                let reservationData = JSON.parse(e.reservations);
                                this.notifications.push(`New booking created: ${reservationData.res_no}`);
                            })
                            .error((error) => {
                                console.error("Error in Echo listening:", error);
                            });
                    }
                }));
            });
        </script>
        
        

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{-- {{ $slot }} --}}

                <div x-data="bookingNotification">
                    <span>Received Reservations: <span x-text="receivedCount"></span></span>

                    <template x-for="notification in notifications" :key="notification">
                        <div class="alert alert-success" x-text="notification"></div>
                    </template>
                </div>

                @yield('content')
            </main>
        </div>
    </body>
</html>
