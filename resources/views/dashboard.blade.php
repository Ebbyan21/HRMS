<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    
                    @php
                        $todayAttendance = \App\Models\Attendance::where('user_id', auth()->id())->where('date', now()->toDateString())->first();
                    @endphp

                    <div class="mt-6 p-6 border-t border-gray-200 text-center">
                        <h4 class="text-2xl font-bold mb-2">Absensi Hari Ini</h4>
                        <p class="text-gray-600 mb-4">{{ now()->format('l, d F Y') }}</p>

                        @if (session('success'))
                            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                             <div class="mb-4 font-medium text-sm text-red-600 bg-red-100 p-3 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex justify-center items-center space-x-4">
                            {{-- Tombol Clock In --}}
                            <form method="POST" action="{{ route('attendance.clock-in') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150" {{ $todayAttendance ? 'disabled' : '' }}>
                                    Clock In
                                </button>
                            </form>

                             {{-- Tombol Clock Out --}}
                            <form method="POST" action="{{ route('attendance.clock-out') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150" {{ !$todayAttendance || $todayAttendance->clock_out_time ? 'disabled' : '' }}>
                                    Clock Out
                                </button>
                            </form>
                        </div>

                        @if($todayAttendance)
                            <div class="mt-6 text-sm text-gray-700">
                                <p>Clocked In at: <span class="font-semibold">{{ $todayAttendance->clock_in_time->format('H:i:s') }}</span></p>
                                @if($todayAttendance->clock_out_time)
                                <p>Clocked Out at: <span class="font-semibold">{{ $todayAttendance->clock_out_time->format('H:i:s') }}</span></p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>