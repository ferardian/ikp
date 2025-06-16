@php
    use App\Models\User;

    // Konversi state menjadi array ID user
    if (is_string($state)) {
        $memberIds = explode(',', $state);
    } elseif (is_array($state)) {
        $memberIds = $state;
    } elseif (is_string($state) && json_decode($state)) {
        $memberIds = json_decode($state);
    } else {
        $memberIds = [];
    }

    // Ambil data user berdasarkan ID
    $users = User::whereIn('id', $memberIds)->get();
@endphp

@if($users->isEmpty())
    <span class="text-gray-500">Tidak ada anggota</span>
@else
    <ul class="list-disc pl-5">
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
@endif
