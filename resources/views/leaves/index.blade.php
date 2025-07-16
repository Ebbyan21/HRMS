<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Cuti Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tampilkan Pengumuman --}}
            @if($announcements->isNotEmpty())
            <div class="p-4 sm:p-8 bg-blue-50 border-l-4 border-blue-400">
                <h2 class="text-lg font-medium text-gray-900 mb-2">
                    📢 Pengumuman Terbaru
                </h2>
                <div class="space-y-4">
                    @foreach($announcements as $announcement)
                        <div class="prose max-w-none text-sm text-gray-700">
                            <h3 class="text-md font-semibold">{{ $announcement->title }}</h3>
                            {!! $announcement->content !!}
                            <p class="text-xs text-gray-500 mt-1">Diposting pada {{ $announcement->created_at->format('d M Y') }}</p>
                        </div>
                        @if(!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Form Pengajuan Cuti --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        Buat Pengajuan Cuti Baru
                    </h2>

                    <form method="post" action="{{ route('leaves.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>
                        <div>
                            <x-input-label for="reason" :value="__('Alasan Cuti')" />
                            <textarea id="reason" name="reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('reason') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Ajukan') }}</x-primary-button>
                            @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ session('success') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Riwayat Cuti --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    Riwayat Pengajuan Cuti
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($leaveRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($request->reason, 30) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($request->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif ($request->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat pengajuan cuti.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-4">
                    {{ $leaveRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>