<aside class="main-sidebar sidebar-light-primary shadow-sm"> <a class="brand-link"> <img
         src="{{ asset('assets/img/logo.png') }}" alt="SIKKA BEM" class="brand-image"> <span
         class="brand-text font-weight-bolder">{{ config('app.name', 'Laravel') }}</span> </a>
   <div class="sidebar">
      <nav class="mt-3 pb-5">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header font-weight-bold text-uppercase">Menu Navigasi</li>
            <li class="nav-item">
               <a href="{{ route('home') }}" class="nav-link @if(request()->routeIs('home')) active @endif">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dasbor</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('upcoming_agenda') }}"
                  class="nav-link @if(request()->routeIs('upcoming_agenda')) active @endif">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>Kegiatan Mendatang</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('agenda') }}" class="nav-link @if(request()->routeIs('agenda')) active @endif">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Kegiatan Selesai</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('forum') }}" class="nav-link @if(request()->routeIs('forum')) active @endif">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Pertanyaan</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('contact') }}" class="nav-link @if(request()->routeIs('contact')) active @endif">
                  <i class="nav-icon fas fa-phone"></i>
                  <p>Hubungi KPPN</p>
               </a>
            </li>
            @if(Auth::user()->role == 'moderator' || Auth::user()->role == 'admin')
            <li class="nav-header font-weight-bold text-uppercase">Moderator</li>
            <li class="nav-item">
               <a href="{{ route('moderator.agenda') }}"
                  class="nav-link @if(request()->routeIs('moderator.agenda')) active @endif">
                  <i class="nav-icon fas fa-briefcase"></i>
                  <p>Administrasi Kegiatan</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('moderator.notification') }}"
                  class="nav-link @if(request()->routeIs('moderator.notification')) active @endif">
                  <i class="nav-icon fas fa-bell"></i>
                  <p>Notifikasi</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('moderator.user_list') }}"
                  class="nav-link @if(request()->routeIs('moderator.user_list')) active @endif">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Daftar User</p>
               </a>
            </li>
            {{--
            <li class="nav-item has-treeview">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-briefcase"></i>
                  <p>Kegiatan</p>
                  <i class="fas fa-angle-left right"></i>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Buat Kegiatan</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Kegiatan</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-folder"></i>
                  <p>Konten</p>
                  <i class="fas fa-angle-left right"></i>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Postingan</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pengumuman</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item has-treeview">
               <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Administrasi User</p>
                  <i class="fas fa-angle-left right"></i>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Aktif</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Nonaktif</p>
                     </a>
                  </li>
               </ul>
            </li> --}}
            @endif
            @if(Auth::user()->role == 'admin')
            <li class="nav-header font-weight-bold text-uppercase">Admin</li>
            <li class="nav-item has-treeview @if(request()->is('admin/master/*')) menu-open @endif">
               <a href="#" class="nav-link @if(request()->is('admin/master/*')) active @endif">
                  <i class="nav-icon fas fa-database"></i>
                  <p>Data Master</p>
                  <i class="fas fa-angle-left right"></i>
               </a>
               <ul class="nav nav-treeview">
                  <li class="nav-item">
                     <a href="{{ route('master_position') }}"
                        class="nav-link @if(request()->routeIs('master_position')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Jabatan</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('master_workunit') }}"
                        class="nav-link @if(request()->routeIs('master_workunit')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Satker</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('master_status_agenda') }}"
                        class="nav-link @if(request()->routeIs('master_status_agenda')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Status Kegiatan</p>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('master_contact') }}"
                        class="nav-link @if(request()->routeIs('master_contact')) active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Daftar Kontak</p>
                     </a>
                  </li>
               </ul>
            </li>
            <li class="nav-item">
               <a href="{{ route('moderator_list') }}"
                  class="nav-link @if(request()->routeIs('moderator_list')) active @endif">
                  <i class="nav-icon fas fa-user-friends"></i>
                  <p>Daftar Moderator</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{ route('admin_list') }}" class="nav-link @if(request()->routeIs('admin_list')) active @endif">
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p>Daftar Admin</p>
               </a>
            </li>
            {{-- <li class="nav-item">
               <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Backup & Restore</p>
            </a>
            </li>
            --}}
            <li class="nav-item">
               <a href="{{ route('application_info') }}"
                  class="nav-link @if(request()->routeIs('application_info')) active @endif">
                  <i class="nav-icon fas fa-exclamation-circle"></i>
                  <p>Info Aplikasi</p>
               </a>
            </li>
            @endif
         </ul>
      </nav>
   </div>
</aside>