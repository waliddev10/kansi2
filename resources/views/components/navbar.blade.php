<nav class="main-header navbar navbar-expand navbar-dark navbar-primary border-bottom-0 elevation-1">
   <ul class="navbar-nav">
      <li class="nav-item"> <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
               class="fas fa-bars"></i></a> </li>
      <li class="nav-item d-lg-none"> <a class="brand-link">
            <span class=" brand-text text-white font-weight-bolder">@yield('title', config('app.name'))</span></a>
      </li>
   </ul>
   <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
         <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            @php
            $num = \App\Notification::leftJoin('read_notifications', function($join) {
            $join->on('notifications.id', '=', 'read_notifications.notification_id')
            ->where('read_notifications.user_id', Auth::user()->id);
            })->whereNotNull('read_notifications.deleted_at')->orWhereNull('read_notifications.user_id')->select('*',
            'notifications.created_at
            AS date')->orderBy('notifications.created_at',
            'desc');
            @endphp

            @if($num->count())
            <span class="badge badge-warning navbar-badge">{{ $num->count() }}</span>
            @endif
         </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @php
            $unread_notif = $num->get();
            @endphp

            @foreach($unread_notif as $notif)
            <a href="{{ route('notification.detail', [$notif->slug]) }}" class="dropdown-item">
               <div class="text-truncate">
                  <i class="fas fa-envelope mr-2"></i> {{ $notif->title }}
                  <span
                     class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($notif->date)->isoFormat('DD MMMM YYYY') }}</span>
               </div>
            </a>
            @endforeach
            <a href="{{ route('notification') }}" class="dropdown-item dropdown-footer">Lihat Semua</a>
         </div>
      </li>
      <li class="nav-item dropdown">
         <a class="nav-link" data-toggle="dropdown" href="#">
            {{-- <img height="20" src="{{ asset('assets/img/user.jpg') }}" class="img img-circle " alt=""> --}}
            <i class="fas fa-user-circle"></i>
         </a>
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
            <a class="dropdown-item text-truncate">
               <span class="font-weight-bold">{{ Auth::user()->name }}</span>
               <br>
               <small class="text-muted">
                  {{ Auth::user()->workunit->code }} - {{ Auth::user()->workunit->name }}
                  <br>
                  {{ Auth::user()->position->name }}
               </small>
            </a>
            <a href="{{ route('profile_settings') }}" class="dropdown-item dropdown-footer text-left">
               <i class="fas fa-cog mr-2"></i>Pengaturan Akun</a>
            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="dropdown-item dropdown-footer text-left font-weight-bold">
                  <i class="fas fa-power-off mr-2 text-danger"></i>Logout
               </button>
            </form>
         </div>
      </li>
   </ul>
</nav>