<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - <span class="text-blue-600">{{ strtoupper(auth()->user()->role) }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-500 text-white p-4 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- --- TAMPILAN ADMIN --- --}}
                @if(auth()->user()->role == 'admin')
                    <h3 class="text-lg font-bold mb-4">Monitoring Seluruh Pesan</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="p-3 border">Waktu</th>
                                    <th class="p-3 border">Pengirim</th>
                                    <th class="p-3 border">Penerima</th>
                                    <th class="p-3 border">Isi Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allMessages as $msg)
                                <tr class="border-b">
                                    <td class="p-3 border text-sm">{{ $msg->created_at->format('d/m H:i') }}</td>
                                    <td class="p-3 border font-semibold text-blue-600">{{ $msg->sender->name }}</td>
                                    <td class="p-3 border font-semibold text-green-600">{{ $msg->receiver->name }}</td>
                                    <td class="p-3 border">{{ $msg->body }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                {{-- --- TAMPILAN GURU --- --}}
                @elseif(auth()->user()->role == 'guru')
                    <h3 class="text-lg font-bold mb-4">Pesan Masuk dari Siswa</h3>
                    <div class="grid gap-4">
                        @forelse($messages as $msg)
                            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded shadow">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-blue-800">{{ $msg->sender->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 mb-3">{{ $msg->body }}</p>
                                
                                <form action="{{ route('chat.send') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $msg->sender_id }}">
                                    <input type="text" name="body" required placeholder="Balas pesan..." class="flex-1 border-gray-300 rounded-md text-sm">
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">Balas</button>
                                </form>
                            </div>
                        @empty
                            <p class="italic text-gray-500">Belum ada pesan dari siswa.</p>
                        @endforelse
                    </div>

                {{-- --- TAMPILAN MURID --- --}}
                @else
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Hubungi Guru Wali</h3>
                            <form action="{{ route('chat.send') }}" method="POST" class="bg-gray-50 p-4 rounded-lg border">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Guru:</label>
                                    <select name="receiver_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach($gurus as $guru)
                                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pesan:</label>
                                    <textarea name="body" required rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Tulis sesuatu..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded-md hover:bg-green-700 transition">Kirim Pesan</button>
                            </form>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-4">Riwayat Chat</h3>
                            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2">
                                @foreach($myMessages as $msg)
                                    <div class="p-3 rounded-lg border {{ $msg->sender_id == auth()->id() ? 'bg-green-50 ml-8' : 'bg-white mr-8' }}">
                                        <div class="flex justify-between text-[10px] mb-1">
                                            <span class="font-bold">{{ $msg->sender_id == auth()->id() ? 'Saya' : $msg->sender->name }}</span>
                                            <span class="text-gray-400">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <p class="text-sm">{{ $msg->body }}</p>
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