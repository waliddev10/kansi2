@extends('layouts.panel')

@section('title', 'Pertanyaan')

@section('content')
<div class="row">
    <div class="col-md-4 order-md-2">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="form-group mt-0">
                    <label class="font-weight-bold">Ada Pertanyaan?</label>
                    <input class="form-control" placeholder="Tulis judul pertanyaan..." />
                </div>
                <div class="form-group mb-0">
                    <label class="font-weight-bold">Isi Pertanyaan</label>
                    <textarea class="form-control" rows="2" placeholder="Tulis isi pertanyaan..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Pertanyaan
                </button>
            </div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">
                    Kategori Topik
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/folder.jpg') }}" alt="Pelatihan Pengadministrasian Siwanda"
                                class="img-size-50 img-circle">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">Layanan</a>
                            <span class="product-description">
                                Luana adalah moderator dalam kegiatan ini. Siapapun yang bertemu dengan Luana maka ia
                                akan segera jatuh cinta.
                            </span>
                            <a href="http://127.0.0.1:1000/agenda/1618994558-pelatihan-pengadministrasian-siwanda"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/folder.jpg') }}" alt="Pelatihan Pengadministrasian Siwanda"
                                class="img-size-50 img-circle">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">Aplikasi dan Peraturan</a>
                            <span class="product-description">
                                Luana adalah moderator dalam kegiatan ini. Siapapun yang bertemu dengan Luana maka ia
                                akan segera jatuh cinta.
                            </span>
                            <a href="http://127.0.0.1:1000/agenda/1618994558-pelatihan-pengadministrasian-siwanda"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/folder.jpg') }}" alt="Pelatihan Pengadministrasian Siwanda"
                                class="img-size-50 img-circle">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">Perbendaharaan</a>
                            <span class="product-description">
                                Luana adalah moderator dalam kegiatan ini. Siapapun yang bertemu dengan Luana maka ia
                                akan segera jatuh cinta.
                            </span>
                            <a href="http://127.0.0.1:1000/agenda/1618994558-pelatihan-pengadministrasian-siwanda"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h3 class="card-title">
                    Sering Ditanyakan
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card p-2">
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/question.jpg') }}" alt="Pelatihan Pengadministrasian Siwanda"
                                class="img-size-50 img-circle">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">Pelatihan Pengadministrasian Siwanda</a>
                        </div>
                        <div class="product-info">
                            <a href="http://127.0.0.1:1000/agenda/1618994558-pelatihan-pengadministrasian-siwanda"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                    <li class="item mx-3">
                        <div class="product-img">
                            <img src="{{ asset('assets/img/question.jpg') }}" alt="Pelatihan Pengadministrasian Siwanda"
                                class="img-size-50 img-circle">
                        </div>
                        <div class="product-info">
                            <a class="text-dark product-title">Pelatihan Pengadministrasian Siwanda</a>
                        </div>
                        <div class="product-info">
                            <a href="http://127.0.0.1:1000/agenda/1618994558-pelatihan-pengadministrasian-siwanda"><span
                                    class="badge badge-primary"><i class="far fa-eye"></i> Detail</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 order-md-1">
        <div class="my-3">
            <form class="form-inline" method="get">
                <div class="input-group"> <input name="q" class="form-control" type="search"
                        placeholder="Cari topik pertanyaan..." aria-label="Search" value="">
                    <div class="input-group-append"
                        style="background-color: #ffffff;background-clip: padding-box;border-top: 1px solid #ced4da;border-bottom: 1px solid #ced4da;border-right: 1px solid #ced4da;border-radius: 0 1rem 1rem 0 ;border-left: none;height: calc(2.25rem + 2px);">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search"></i> </button> </div>
                </div>
            </form>
        </div>
        @forelse($questions as $question)
        <div class="card shadow-sm mb-3">
            <div class="card-header border-bottom">
                <h3 class="card-title">
                    {{ $question->title }}
                </h3>
            </div>
            <div class="card-body">
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ $question->user->name }}</span>
                        <span
                            class="direct-chat-timestamp float-right">{{ \Carbon\Carbon::parse($question->created_at)->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset('assets/img/user.jpg') }}" alt="message user image">
                    <div class="direct-chat-text">
                        {{ $question->content }}
                    </div>
                </div>
                @foreach($question->answers as $answer)
                <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-right">{{ $answer->user->name }}</span>
                        <span
                            class="direct-chat-timestamp float-left">{{ \Carbon\Carbon::parse($answer->created_at)->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset('assets/img/user.jpg') }}" alt="message user image">
                    <div class="direct-chat-text">
                        {{ $answer->content }}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
                <form action="#" method="post">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Tulis jawaban..." class="form-control">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="card shadow-sm mb-3">
            <div class="card-body pt-0">
                <span class="text-muted">Belum ada pertanyaan yang diajukan.</span>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection