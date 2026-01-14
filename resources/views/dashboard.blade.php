<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard - <span class="text-blue-600">{{ strtoupper(auth()->user()->role ?? 'user') }}</span>
        </h2> {{-- Tadi di kode lu kurang penutup h2 ini brok --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-500 text-white p-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">

                {{-- --- 1. ADMIN --- --}}
                @if (auth()->user()->role == 'admin')
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-xl text-gray-700">Monitoring Log Pesan</h3>
                        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
                            <input type="text" name="search" placeholder="Cari nama..."
                                class="rounded-md border-gray-300 text-sm" value="{{ request('search') }}">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Cari</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto shadow-sm rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 border">Waktu</th>
                                    <th class="px-4 py-3 border">Pengirim</th>
                                    <th class="px-4 py-3 border">Penerima</th>
                                    <th class="px-4 py-3 border">Isi Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allMessages as $msg)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-mono text-xs text-gray-400 border">
                                            {{ $msg->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-4 py-3 border text-center">
                                            <span class="px-2 py-1 rounded {{ $msg->sender->role == 'guru' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }} font-semibold">
                                                {{ $msg->sender->name }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900 border">{{ $msg->receiver->name }}</td>
                                        <td class="px-4 py-3 italic text-gray-600 border">"{{ $msg->body }}"</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">Chat tidak ditemukan...</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $allMessages->appends(request()->query())->links() }}
                    </div>

                {{-- --- 2. GURU --- --}}
                @elseif(auth()->user()->role == 'guru')
                    <h3 class="font-bold text-lg mb-4 text-blue-800">Daftar Chat dari Siswa</h3>
                    <div class="space-y-4">
                        @forelse($messages as $msg)
                            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded shadow-sm">
                                <p class="text-sm font-bold text-blue-700">{{ $msg->sender->name }} mengatakan:</p>
                                <p class="text-gray-800 my-2">{{ $msg->body }}</p>
                                <form action="{{ route('chat.send') }}" method="POST" class="mt-4 flex gap-2">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $msg->sender_id }}">
                                    <input type="text" name="body" required placeholder="Tulis balasan..."
                                        class="flex-1 rounded-md border-gray-300 shadow-sm">
                                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded shadow">Balas</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Belum ada pesan masuk...</p>
                        @endforelse
                    </div>

                {{-- --- 3. MURID --- --}}
                @else
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-4 rounded border">
                            <h3 class="font-bold text-lg mb-4 text-green-700">Kirim Pesan ke Guru Wali</h3>
                            <form action="{{ route('chat.send') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm text-gray-700">Pilih Guru:</label>
                                    <select name="receiver_id" required class="w-full rounded border-gray-300 shadow-sm">
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach ($gurus as $guru)
                                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700">Isi Pesan:</label>
                                    <textarea name="body" required rows="3" class="w-full rounded border-gray-300 shadow-sm" placeholder="Tulis pesan..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded shadow">Kirim Pesan</button>
                            </form>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-4 text-gray-700">Riwayat Chat</h3>
                            <div class="space-y-3 max-h-[400px] overflow-y-auto">
                                @foreach ($myMessages as $msg)
                                    <div class="p-3 rounded-lg border {{ $msg->sender_id == auth()->id() ? 'bg-green-50 ml-6' : 'bg-gray-50 mr-6' }}">
                                        <p class="text-[10px] font-bold uppercase {{ $msg->sender_id == auth()->id() ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $msg->sender_id == auth()->id() ? 'Saya' : $msg->sender->name }}
                                            <span class="text-gray-400 font-normal ml-2">{{ $msg->created_at->diffForHumans() }}</span>
                                        </p>
                                        <p class="text-sm text-gray-800">{{ $msg->body }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>