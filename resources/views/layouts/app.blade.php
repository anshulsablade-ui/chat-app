<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat App</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700" rel="stylesheet">

    <!-- Template CSS -->
    <link class="css-lt" rel="stylesheet" href="{{ asset('assets/css/template.bundle.css') }}" media="(prefers-color-scheme: light)">
    <link class="css-dk" rel="stylesheet" href="{{ asset('assets/css/template.dark.bundle.css') }}" media="(prefers-color-scheme: dark)">

    <!-- Script -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Theme mode -->
    <script>
            if (localStorage.getItem('color-scheme')) {
                let scheme = localStorage.getItem('color-scheme');

                const LTCSS = document.querySelectorAll('link[class=css-lt]');
                const DKCSS = document.querySelectorAll('link[class=css-dk]');

                [...LTCSS].forEach((link) => {
                    link.media = (scheme === 'light') ? 'all' : 'not all';
                });

                [...DKCSS].forEach((link) => {
                    link.media = (scheme === 'dark') ? 'all' : 'not all';
                });
            }
    </script>
</head>

    <body>
        <!-- Layout -->
        <div class="layout overflow-hidden">
            <!-- Navigation -->
            <nav class="navigation d-flex flex-column text-center navbar navbar-light hide-scrollbar">
                <!-- Brand -->
                <a href="{{ route('chat.index') }}" title="Messenger" class="d-none d-xl-block mb-6">
                    <svg version="1.1" width="46px" height="46px" fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 46 46" enable-background="new 0 0 46 46" xml:space="preserve">
                        <polygon opacity="0.7" points="45,11 36,11 35.5,1 "/>
                        <polygon points="35.5,1 25.4,14.1 39,21 "/>
                        <polygon opacity="0.4" points="17,9.8 39,21 17,26 "/>
                        <polygon opacity="0.7" points="2,12 17,26 17,9.8 "/>
                        <polygon opacity="0.7" points="17,26 39,21 28,36 "/>
                        <polygon points="28,36 4.5,44 17,26 "/>
                        <polygon points="17,26 1,26 10.8,20.1 "/>
                    </svg>

                </a>

                <!-- Nav items -->
                <ul class="d-flex nav navbar-nav flex-row flex-xl-column flex-grow-1 justify-content-between justify-content-xl-center align-items-center w-100 py-4 py-lg-2 px-lg-3" role="tablist">
                    <!-- Invisible item to center nav vertically -->
                    <li class="nav-item d-none d-xl-block invisible flex-xl-grow-1">
                        <a class="nav-link py-0 py-lg-8" href="#" title="">
                            <div class="icon icon-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div>
                        </a>
                    </li>

                    <!-- New chat -->
                    <li class="nav-item">
                        <a class="nav-link py-0 py-lg-8" id="tab-create-chat" href="#tab-content-create-chat" title="Create chat" data-bs-toggle="tab" role="tab">
                            <div class="icon icon-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </div>
                        </a>
                    </li>

                    <!-- Friends -->
                    <li class="nav-item">
                        <a class="nav-link py-0 py-lg-8" id="tab-friends" href="#tab-content-friends" title="Friends" data-bs-toggle="tab" role="tab">
                            <div class="icon icon-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </a>
                    </li>

                    <!-- Chats -->
                    <li class="nav-item flex-xl-grow-1">
                        <a class="nav-link active py-0 py-lg-8" id="tab-chats" href="#tab-content-chats" title="Chats" data-bs-toggle="tab" role="tab">
                            <div class="icon icon-xl icon-badged1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                {{-- <div class="badge badge-circle bg-primary">
                                    <span>4</span>
                                </div> --}}
                            </div>
                        </a>
                    </li>

                    <!-- Switcher -->
                    <li class="nav-item">
                        <a class="switcher-btn nav-link py-0 py-lg-8" href="javascript:void(0)" title="Themes">
                            <div class="switcher-icon switcher-icon-dark icon icon-xl d-none" data-theme-mode="dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                            </div>
                            <div class="switcher-icon switcher-icon-light icon icon-xl d-none" data-theme-mode="light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                            </div>
                        </a>
                    </li>

                    <!-- logout -->
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link py-0 py-lg-8" title="Logout">
                            <div class="icon icon-xl icon-badged1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            </div>
                        </a>
                    </li>

                    <!-- Profile -->
                    <li class="nav-item d-none d-xl-block">
                        <a href="#" class="nav-link p-0 mt-lg-2" data-bs-toggle="modal" data-bs-target="#modal-profile">
                            <div class="avatar avatar-online1 mx-auto">
                                @if (file_exists(auth()->user()->image))
                                    <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}" class="avatar-img">
                                @else
                                    <span class="avatar-text">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Navigation -->

            <!-- Sidebar -->
            <aside class="sidebar bg-light">
                <div class="tab-content h-100" role="tablist">
                    <!-- Create -->
                    <div class="tab-pane fade h-100" id="tab-content-create-chat" role="tabpanel">
                        <div class="d-flex flex-column h-100">
                            <div class="hide-scrollbar">

                                <div class="container py-8">

                                    <!-- Title -->
                                    <div class="mb-8">
                                        <h2 class="fw-bold m-0">Create Group chat</h2>
                                    </div>
                                    <div class="mb-8" id="groupFormError"></div>
                                    <div class="mb-6">
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="pill" href="#create-chat-info" role="tab" aria-controls="create-chat-info" aria-selected="true">
                                                    Details
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" id="getMember" data-bs-toggle="pill" href="#create-chat-members" role="tab" aria-controls="create-chat-members" aria-selected="true">
                                                    People
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Tabs content -->
                                    <div class="tab-content" role="tablist">
                                        <div class="tab-pane fade show active" id="create-chat-info" role="tabpanel">

                                            <div class="card border-0">
                                                <div class="profile">
                                                    <div class="profile-img text-primary rounded-top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 400 140.74"><defs><style>.cls-2{fill:#fff;opacity:0.1;}</style></defs><g><g><path d="M400,125A1278.49,1278.49,0,0,1,0,125V0H400Z"/><path class="cls-2" d="M361.13,128c.07.83.15,1.65.27,2.46h0Q380.73,128,400,125V87l-1,0a38,38,0,0,0-38,38c0,.86,0,1.71.09,2.55C361.11,127.72,361.12,127.88,361.13,128Z"/><path class="cls-2" d="M12.14,119.53c.07.79.15,1.57.26,2.34v0c.13.84.28,1.66.46,2.48l.07.3c.18.8.39,1.59.62,2.37h0q33.09,4.88,66.36,8,.58-1,1.09-2l.09-.18a36.35,36.35,0,0,0,1.81-4.24l.08-.24q.33-.94.6-1.9l.12-.41a36.26,36.26,0,0,0,.91-4.42c0-.19,0-.37.07-.56q.11-.86.18-1.73c0-.21,0-.42,0-.63,0-.75.08-1.51.08-2.28a36.5,36.5,0,0,0-73,0c0,.83,0,1.64.09,2.45C12.1,119.15,12.12,119.34,12.14,119.53Z"/><circle class="cls-2" cx="94.5" cy="57.5" r="22.5"/><path class="cls-2" d="M276,0a43,43,0,0,0,43,43A43,43,0,0,0,362,0Z"/></g></g></svg>
                                                    </div>

                                                    <div class="profile-body p-0">
                                                        <div class="avatar avatar-lg">
                                                            <span class="avatar-text bg-primary" id="group-image-preview">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                                            </span>

                                                            <div class="badge badge-lg badge-circle bg-primary border-outline position-absolute bottom-0 end-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                            </div>

                                                            <input id="upload-chat-img" class="d-none" type="file" name="group_image">
                                                            <label class="stretched-label mb-0" for="upload-chat-img"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <form autocomplete="off">
                                                        <div class="row gy-6">
                                                            <div class="col-12">
                                                                <div class="form-floating">
                                                                    <input type="text" name="group_name" id="group_name" class="form-control" id="floatingInput" placeholder="Enter a chat name">
                                                                    <label for="floatingInput">Enter group name</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Members -->
                                        <div class="tab-pane fade" id="create-chat-members" role="tabpanel">
                                            <nav></nav>
                                        </div>
                                    </div>
                                    <!-- Tabs content -->
                                </div>

                            </div>

                            <!-- Button -->
                            <div class="container mt-n4 mb-8 position-relative">
                                <button class="btn btn-lg btn-primary w-100 d-flex align-items-center" id="groupCreate" type="button">
                                    Start chat
                                    <span class="icon ms-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                    </span>
                                </button>
                            </div>
                            <!-- Button -->
                        </div>
                    </div>

                    <!-- Friends -->
                    <div class="tab-pane fade h-100" id="tab-content-friends" role="tabpanel">
                        <div class="d-flex flex-column h-100">
                            <div class="hide-scrollbar">
                                <div class="container py-8">

                                    <!-- Title -->
                                    <div class="mb-8">
                                        <h2 class="fw-bold m-0">Friends</h2>
                                    </div>

                                    <!-- List -->
                                    <div class="card-list" id="tab-content-friends-list"></div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chats -->
                    <div class="tab-pane fade h-100 show active" id="tab-content-chats" role="tabpanel">
                        <div class="d-flex flex-column h-100 position-relative">
                            <div class="hide-scrollbar">

                                <div class="container py-8">
                                    <!-- Title -->
                                    <div class="mb-8">
                                        <h2 class="fw-bold m-0">Chats</h2>
                                    </div>

                                    <!-- Chats -->
                                    <div class="card-list">
                                        @foreach ($participants as $participant)    
                                        <!-- Card -->
                                        <a href="{{ route('chat', $participant->conversation->id) }}" data-conversation-id="" class="card border-0 text-reset conversationChat">
                                            <div class="card-body" id="conversation-{{ $participant->conversation->id }}">
                                                <div class="row gx-5" id="user-{{ $participant->conversation->type == 'private' ? $participant->conversation->users[0]->id : '' }}">
                                                    <div class="col-auto">
                                                        <div class="avatar {{ $participant->conversation->type == 'private' ? 'status avatar-offline' : '' }}">
                                                            @if ($participant->conversation->type == 'group')                                                                
                                                                <span class="avatar-text">{{ substr($participant->conversation->title, 0, 1) }}</span>
                                                            @else
                                                                @if ($participant->conversation->users[0]->image)
                                                                    <img src="{{ asset('images/users/' . $participant->conversation->users[0]->image) }}" alt="{{ $participant->conversation->users[0]->name }}" class="avatar-img">
                                                                @else
                                                                    <span class="avatar-text">{{ substr($participant->conversation->users[0]->name, 0, 1) }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="d-flex align-items-center">
                                                            <h5 class="me-auto mb-0">{{ $participant->conversation->type == 'group' ? $participant->conversation->title : $participant->conversation->users[0]->name }}</h5>
                                                            {{-- <span class="text-muted extra-small ms-2">{{ $participant->conversation->type == 'private' ? $participant->conversation->users[0]->last_seen?->format('H:i A') : '' }}</span> --}}
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                            <div class="line-clamp me-auto">
                                                                {{ $participant->conversation->type == 'group' ? $participant->conversation->users->count() + 1 . ' members' : $participant->conversation->users[0]->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .card-body -->
                                        </a>
                                        <!-- Card -->
                                        @endforeach

                                    </div>
                                    <!-- Chats -->
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </aside>
            <!-- Sidebar -->

            <!-- Chat -->
            <main class="main" id="mainRemove">
                <div class="container h-100">

                    <div class="d-flex flex-column h-100 justify-content-center text-center">
                        <div class="mb-6">
                            <span class="icon icon-xl text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            </span>
                        </div>
                        <p class="text-muted">Pick a person from left menu, <br> and start your conversation.</p>
                    </div>
                </div>
            </main>
            <main class="main is-visible d-none">
                <div class="container h-100">

                    <div class="d-flex flex-column h-100 position-relative">
                        <!-- Chat: Header -->
                        <div class="chat-header border-bottom py-4 py-lg-7">
                            <div class="row align-items-center" id="chat-header">

                                <!-- Mobile: close -->
                                <div class="col-2 d-xl-none">
                                    <a class="icon icon-lg text-muted" href="#" data-toggle-chat="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    </a>
                                </div>
                                <!-- Mobile: close -->

                                <!-- Content -->
                                <div class="col-8 col-xl-12">
                                    <div class="row align-items-center text-center text-xl-start">
                                        <!-- Title -->
                                        <div class="col-12 col-xl-6">
                                            <div class="row align-items-center gx-5">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-offline d-none user-status d-xl-inline-block conversation-avatar"></div>
                                                </div>

                                                <div class="col overflow-hidden">
                                                    <h5 class="text-truncate conversation-name"></h5>
                                                    <p class="text-truncate conversation-email"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Title -->
                                    </div>
                                </div>
                                <!-- Content -->

                            </div>
                        </div>
                        <!-- Chat: Header -->

                        <!-- Chat: Content -->
                        <div class="chat-body hide-scrollbar flex-1 h-100">
                            <div class="chat-body-inner">
                                <div style="height: 500px;" class="py-6 py-lg-12 overflow-auto hide-scrollbar" id="messages-content"></div>
                            </div>
                        </div>
                        <!-- Chat: Content -->

                        <!-- Chat: Footer -->
                        <div class="chat-footer pb-3 pb-lg-7 position-absolute bottom-0 start-0">
                            <!-- Chat: Files -->
                            <div class="dz-preview bg-dark" id="dz-preview-row" data-horizontal-scroll="">
                            </div>
                            <!-- Chat: Files -->

                            <!-- Chat: Form -->
                            <form id="messageSendForm" class="chat-form rounded-pill bg-dark" data-emoji-form="">
                                <input type="hidden" name="conversation_id" id="conversation_id">
                                <div class="row align-items-center gx-0">

                                    <div class="col ms-7">
                                        <div class="input-group">
                                            <textarea id="message" class="form-control px-0" placeholder="Type your message..." name="message" rows="1" data-emoji-input="" data-autosize="true"></textarea>

                                            <a href="#" class="input-group-text text-body pe-0" data-emoji-btn="">
                                                <span class="icon icon-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                                                </span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <button class="btn btn-icon btn-primary rounded-circle ms-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- Chat: Form -->
                        </div>
                        <!-- Chat: Footer -->
                    </div>

                </div>
            </main>
            <!-- Chat -->

        </div>
        <!-- Layout -->

        <!-- Modal: Profile -->
        <div class="modal fade" id="modal-profile" tabindex="-1" aria-labelledby="modal-profile" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body py-0">
                        <!-- Header -->
                        <div class="profile modal-gx-n">
                            <div class="profile-img text-primary rounded-top-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 400 140.74"><defs><style>.cls-2{fill:#fff;opacity:0.1;}</style></defs><g><g><path d="M400,125A1278.49,1278.49,0,0,1,0,125V0H400Z"/><path class="cls-2" d="M361.13,128c.07.83.15,1.65.27,2.46h0Q380.73,128,400,125V87l-1,0a38,38,0,0,0-38,38c0,.86,0,1.71.09,2.55C361.11,127.72,361.12,127.88,361.13,128Z"/><path class="cls-2" d="M12.14,119.53c.07.79.15,1.57.26,2.34v0c.13.84.28,1.66.46,2.48l.07.3c.18.8.39,1.59.62,2.37h0q33.09,4.88,66.36,8,.58-1,1.09-2l.09-.18a36.35,36.35,0,0,0,1.81-4.24l.08-.24q.33-.94.6-1.9l.12-.41a36.26,36.26,0,0,0,.91-4.42c0-.19,0-.37.07-.56q.11-.86.18-1.73c0-.21,0-.42,0-.63,0-.75.08-1.51.08-2.28a36.5,36.5,0,0,0-73,0c0,.83,0,1.64.09,2.45C12.1,119.15,12.12,119.34,12.14,119.53Z"/><circle class="cls-2" cx="94.5" cy="57.5" r="22.5"/><path class="cls-2" d="M276,0a43,43,0,0,0,43,43A43,43,0,0,0,362,0Z"/></g></g></svg>

                                <div class="position-absolute top-0 start-0 py-6 px-5">
                                    <button type="button" class="btn-close btn-close-white btn-close-arrow opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>

                            <div class="profile-body">
                                <div class="avatar avatar-xl">
                                    @if (file_exists(auth()->user()->image))
                                        <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}" class="avatar-img">
                                    @else
                                        <span class="avatar-text">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </div>

                                <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                {{-- <p>last seen 5 minutes ago</p> --}}
                            </div>
                        </div>
                        <!-- Header -->

                        <hr class="hr-bold modal-gx-n my-0">

                        <!-- List -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row align-items-center gx-6">
                                    <div class="col">
                                        <h5>E-mail</h5>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>

                                    <div class="col-auto">
                                        <div class="btn btn-sm btn-icon btn-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="row align-items-center gx-6">
                                    <div class="col">
                                        <h5>Phone</h5>
                                        <p>{{ auth()->user()->phone ?? '-' }}</p>
                                    </div>

                                    <div class="col-auto">
                                        <div class="btn btn-sm btn-icon btn-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- List  -->

                        <hr class="hr-bold modal-gx-n my-0">

                        <!-- List -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{ route('logout') }}" class="text-danger">Logout</a>
                            </li>
                        </ul>
                        <!-- List -->
                    </div>
                    <!-- Modal body -->

                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('assets/js/vendor.js') }}"></script>
        <script src="{{ asset('assets/js/template.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/ajax.js') }}"></script>

        <script>
            $(document).ready(function () {

                $("#tab-friends").click(function (e) { 
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('get-users') }}",
                        dataType: "json",
                        success: function (response) {
                            var content = '';
                            $.each(response, function (index, user) {
                                content += `<div class="card border-0">
                                                <div class="card-body">
                                                    <div class="row align-items-center gx-5">
                                                        <div class="col-auto">
                                                            <a href="#" class="avatar ">
                                                             ${user.image
                                                                 ? `<img src="${user.image}" alt="${user.name}" class="avatar-img">`
                                                                 : `<span class="avatar-text">${user.name?.charAt(0) ?? '?'}</span>`
                                                             }
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <h5><a href="javascript:void(0);">${user.name}</a></h5>
                                                            <p>${user.email}</p>
                                                        </div>
                                                        ${user.has_conversation == false ? 
                                                        `<div class="col-auto">
                                                            <!-- Dropdown -->
                                                            <div class="dropdown">
                                                                <a class="icon text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                                </a>

                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item createConversation" data-id="${user.id}" href="javascript:void(0);">Add Chat</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>` : ''
                                                        }
                                                    </div>
                                                </div>
                                            </div>`;
                            });
                            $("#tab-content-friends-list").html(content);
                        }
                    });
                });

                $("#getMember").click(function (e) { 
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('get-users') }}",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            var content = '';
                            $.each(response, function (index, user) {
                                content += `<div class="card border-0 mt-5">
                                                <div class="card-body">
                                                    <div class="row align-items-center gx-5">
                                                        <div class="col-auto">
                                                            <div class="avatar ">
                                                             ${user.image
                                                                 ? `<img src="${user.image}" alt="${user.name}" class="avatar-img">`
                                                                 : `<span class="avatar-text">${user.name?.charAt(0) ?? '?'}</span>`
                                                             }
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h5>${user.name}</h5>
                                                            <p>${user.email}</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="form-check">
                                                                <input class="form-check-input userMember" type="checkbox" name="users[]" value="${user.id}" id="id-member-${user.id}">
                                                                <label class="form-check-label" for="id-member-${user.id}"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="stretched-label" for="id-member-${user.id}"></label>
                                                </div>
                                            </div>`;
                            });
                            $("#create-chat-members nav").html(content);
                        }
                    });
                });

                $("#upload-chat-img").change(function (e) { 
                    e.preventDefault();
                    // image Preview
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#group-image-preview').html('<img src="' + e.target.result + '" alt="your image" />');
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                $("#groupCreate").click(function (e) { 
                    e.preventDefault();
                    let formData = new FormData();

                    formData.append('group_name', $("#group_name").val());

                    $(".userMember:checked").each(function () {
                        formData.append('users[]', $(this).val());
                    });
                
                    let fileInput = $("#upload-chat-img")[0];
                
                    if (fileInput.files.length > 0) {
                        formData.append('group_image', fileInput.files[0]);
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ route('create-group') }}",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            window.location.href = "{{ route('chat.index') }}";
                        },
                        error: function (error) {
                            let errors = JSON.parse(error.responseText);
                            let showError = "";
                            $.each(errors.message, function (key, value) {
                                showError += `<p class="text-danger">${value}</p>`;
                            });
                            $("#groupFormError").html(showError);
                        }
                    });
                });

            });
        </script>
        <script>
            $(document).ready(function () {
                let conversationId = null;
                let USER_ID = null;
                let USER_NAME = null;
                const userId = "{{ auth()->user()->id }}";

                $('body').on('click', '.conversationChat', function (e) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    ajaxCall(url, 'post', null, function (response) {
                        $("#mainRemove").remove();
                        $("#messages-content").empty();
                        conversationId = JSON.stringify(response.conversationId);
                        $('#messageSendForm').find('#conversation_id').val(conversationId);
                        joinConversation(conversationId);
                        
                        var conversation = response.conversation;

                        if (conversation.type == 'group') {
                            var avatar = `<span class="avatar-text">${conversation?.title?.charAt(0) ?? '?'}</span>`;
                            var title = conversation.title;
                            $(".conversation-email").text(`${response.totalUsers} Members`);
                        } else {
                            var avatar = conversation.users[0].image
                                ? `<img src="${conversation.users[0].image}" alt="${conversation.users[0].name}" class="avatar-img">`
                                : `<span class="avatar-text">${conversation.users[0]?.name?.charAt(0) ?? '?'}</span>`;
                                
                            var title = conversation.users[0].name;
                            $(".conversation-email").text(conversation.users[0].email);
                        }
                        $(".conversation-avatar").html(avatar);
                        $(".conversation-name").text(title);

                        $('.main').removeClass('d-none');
                        $.each(response.messages, function (indexInArray, message) {
                            showMessage(message);
                        });
                    }, function (response) {
                        alert('Error:' + response);
                    });
                });

                // create conversation
                $("body").on('click', '.createConversation', function () {
                    createConversation($(this).data('id'));
                });
                function createConversation(id) {
                    var formData = new FormData();
                    formData.append('users[]', id);
                    formData.append('users[]', userId);
                    ajaxCall("{{ route('create-conversation') }}", 'post', formData, function (response) {
                        window.location.href = "{{ route('chat.index') }}";
                    }, function (response) {
                        alert('Error:' + response);
                    })
                }

                // message send
                $("#messageSendForm").submit(function (e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    hideTyping();
                    $(this).find('#message').val('');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('chat.send') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            showMessage(response.message);
                        }
                    });
                });


                Echo.join('online')
                    .here((users) => {
                        users.forEach(user => setOnline(user.id));
                    })
                    .joining((user) => {
                        setOnline(user.id);
                    })
                    .leaving((user) => {
                        setOffline(user.id);
                    });

                function setOnline(user_id) {
                    $(`#user-${user_id} .status`).removeClass('avatar-offline');
                    $(`#user-${user_id} .status`).addClass('avatar-online');
                }

                function setOffline(user_id) {
                    $(`#user-${user_id} .status`).removeClass('avatar-online');
                    $(`#user-${user_id} .status`).addClass('avatar-offline');
                }

                // real time message show
                let currentConversationId = null;

                function joinConversation(conversationId) {

                    if (currentConversationId) {
                        Echo.leave(`chat.${currentConversationId}`);
                    }

                    currentConversationId = conversationId;

                    Echo.private(`chat.${conversationId}`)
                        .listen('.message.sent', (e) => {
                            showMessage(e);
                        });
                }

                function showMessage(message) {
                    let content = `<div class="message ${message.sender_id == userId ? 'message-out' : ''}">
                                        <a href="#" class="avatar avatar-responsive">
                                            ${message.sender && message.sender.image
                                                ? `<img src="${message.sender.image}" alt="${message.sender.name}" class="avatar-img">`
                                                : `<span class="avatar-text">${message.sender?.name?.charAt(0) ?? '?'}</span>`}
                                        </a>
                                        <div class="message-inner">
                                            <div class="message-body">
                                                <div class="message-content">
                                                    <div class="message-text"><p>${message.message}</p></div>
                                                </div>
                                            </div>
                                            <div class="message-footer">
                                                <span class="extra-small text-muted">${formatTime(message.created_at)}</span>
                                            </div>
                                        </div>
                                    </div>`;
                    const shouldScroll = isUserAtBottom();

                    $("#messages-content").append(content);
                    if (shouldScroll) {
                        scrollToBottomSmooth();
                    }
                }

                function formatTime(datetime) {
                    if (!datetime) return '';

                    const date = new Date(datetime.replace(' ', 'T'));

                    return date.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                }

                scrollToBottom();

                $("#messages-content").on("scroll", function () {
                    if ($(this).scrollTop() === 0) {
                        loadOlderMessages();
                    }
                });

            });

                function scrollToBottom() {
                    const $chat = $("#messages-content");
                    $chat.scrollTop($chat[0].scrollHeight);
                }

                function scrollToBottomSmooth() {
                    const $chat = $("#messages-content");
                    $chat.animate(
                        { scrollTop: $chat[0].scrollHeight },
                        300
                    );
                }

                function isUserAtBottom() {
                    const $chat = $("#messages-content");
                    return (
                        $chat[0].scrollHeight -
                        $chat.scrollTop() -
                        $chat.outerHeight()
                    ) < 50;
                }

        </script>
    </body>
</html>