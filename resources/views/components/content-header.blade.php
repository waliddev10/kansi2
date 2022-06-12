<div class="content-header">
   <div class="container-fluid d-none d-lg-block">
      <div class="row">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('title', config('app.name'))</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
               <li class="breadcrumb-item active">@yield('title', config('app.name'))</li>
            </ol>
         </div>
      </div>
   </div>
</div>