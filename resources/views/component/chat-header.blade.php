<div class="row align-items-center">

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
                        <div class="avatar d-none d-xl-inline-block">
                            @if ($conversation->type == 'group')                                                                
                                <span class="avatar-text">{{ substr($conversation->title, 0, 1) }}</span>
                            @else
                                @if ($conversation->users[0]->image)
                                    <img src="{{ asset('images/users/' . $conversation->users[0]->image) }}" alt="{{ $conversation->users[0]->name }}" class="avatar-img">
                                @else
                                    <span class="avatar-text">{{ substr($conversation->users[0]->name, 0, 1) }}</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="col overflow-hidden">
                        <h5 class="text-truncate">{{ $conversation->type == 'group' ? $conversation->title : $conversation->users[0]->name }}</h5>
                        <p class="text-truncate">{{ $conversation->type == 'group' ? $totalUsers.' members' : '' }} </p>
                    </div>
                </div>
            </div>
            <!-- Title -->

            <!-- Toolbar -->
            <div class="col-xl-6 d-none d-xl-block">
                <div class="row align-items-center justify-content-end gx-6">
                    {{-- <div class="col-auto">
                        <a href="#" class="icon icon-lg text-muted" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-more-group" aria-controls="offcanvas-more-group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                        </a>
                    </div> --}}

                    @if ($conversation->type == 'private')
                        <div class="col-auto">
                            <div class="avatar-group">
                            
                                <a href="javascript:void(0);" class="avatar avatar-sm">
                                    @if ($conversation->users[0]->image)
                                        <img src="{{ asset('images/users/' . $conversation->users[0]->image) }}" alt="{{ $conversation->users[0]->name }}" class="avatar-img">
                                    @else
                                        <span class="avatar-text">{{ substr($conversation->users[0]->name, 0, 1) }}</span>
                                    @endif
                                </a>
                                <a href="#" class="avatar avatar-sm" data-bs-toggle="modal" data-bs-target="#modal-profile">
                                    @if (file_exists(auth()->user()->image))
                                        <img src="{{ auth()->user()->image }}" alt="{{ auth()->user()->name }}" class="avatar-img">
                                    @else
                                        <span class="avatar-text">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                </a>
                                
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Toolbar -->
        </div>
    </div>
    <!-- Content -->

    <!-- Mobile: more -->
    <div class="col-2 d-xl-none text-end">
        <div class="dropdown">
            <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="icon icon-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                </div>
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-add-members" aria-controls="offcanvas-add-members">Add members</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-more-group" aria-controls="offcanvas-more-group">More</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Mobile: more -->

</div>