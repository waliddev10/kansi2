@extends('layouts.panel')

@section('title', 'Hubungi KPPN')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                @forelse($contacts as $contact)
                <div class="direct-chat-msg py-2">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ $contact->name }}</span>
                        <span class="direct-chat-timestamp float-right">{{ $contact->position }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset('assets/img/user.jpg') }}" alt="message user image">
                    <a href="https://wa.me/62{{ ltrim($contact->handphone, '0') }}">
                        <div class="direct-chat-text font-weight-bold">
                            <span class="badge badge-success badge-pill"><i class="fab fa-whatsapp"></i></span>
                            {{ $contact->handphone }}
                        </div>
                    </a>
                </div>
                @empty
                Belum ada kontak yang ditampilkan.
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection