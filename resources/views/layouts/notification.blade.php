@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp
<li>
    <h6 class="dropdown-header">Notification Center</h6>
</li>
<li>
    @foreach(Auth::user()->notifications->take(3) as $notification)
    <a class="dropdown-item d-flex align-items-center" href="{{$notification->data['url']}}" data-id="{{$notification->id}}" onclick="return markRead($(this))" id="dropdown-item">
        <div class="me-3">
            @switch($notification->data['type'])
            @case('verification_accept')
            <!-- NAVBAR CENTANG DITERIMA SUKSES-->
            <div class="icon-circle bg-success">
                <i class="fas fas fa-check text-white"></i>
            </div>
            @break
            @case('verification_reject')
            <!-- NAVBAR DITOLAK GAGAL SILANG TETOT-->
            <div class="icon-circle bg-danger">
                <i class="fas fa-times text-white"></i>
            </div>
            @break
            @case('transaction_income')
            <!-- NAVBAR GAMBAR UANG-->
            <div class="icon-circle bg-success">
                <i class="fas fa-money-bill-wave text-white"></i>
            </div>
            @break
            @case('transaction_outcome')
            <!-- NAVBAR GAMBAR UANG-->
            <div class="icon-circle bg-default-primary">
                <i class="fas fa-money-bill-wave text-white"></i>
            </div>
            @break
            @case('investnak_start')
            <!-- NAVBAR GAMBAR INVESTNAK UDAH MULAI-->
            <div class="icon-circle bg-success">
                <i class="fas fa-play text-white"></i>
            </div>
            @break
            @case('investnak_stop')
            <!-- NAVBAR GAMBAR INVESTNAK STOP SELESAI-->
            <div class="icon-circle bg-default-secondary">
                <i class="fas fa-stop text-white"></i>
            </div>
            @break
            @case('pasarnak_sending')
            <!-- NAVBAR GAMBAR KIRIM BARANG PAKE TRUCK-->
            <div class="icon-circle bg-default-primary">
                <i class="fas fa-truck text-white"></i>
            </div>
            @break
            @default
             <!-- NAVBAR GAMBAR LONCENG-->
             <div class="icon-circle bg-warning">
                <i class="fas fa-bell text-white"></i>
            </div>
            @endswitch
        </div>
        <div style="word-wrap:break-word;">
            <div class="small text-gray-500">{{ Carbon::parse($notification->created_at)->diffForHumans()}}</div>
            <span class="@empty($notification->read_at) fw-bold @endempty text-wrap">{{$notification->data['message']}}</span>
        </div>
    </a>
    @endforeach
</li>
<a class="dropdown-item text-secondary small text-center" href="{{route('profile.notification')}}">Show All Alerts</a>
@push('js')
    <script>
        function markRead(el){
            $.ajax({
                url: "{{ route('markNotification')}}",
                method: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': el.data('id'),
                },
                success: function (response) {
                    return true;
                },
                error: function (response){
                    alert(response);
                    return false;
                }
            });
        }
    </script>
@endpush