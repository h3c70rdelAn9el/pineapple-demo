@include('Chatify::layouts.headLinks')
<x-app-layout>
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="mt-2 m-header md:mt-4">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    {{-- <a href="#"><i class="fas fa-cog settings-btn"></i></a> --}}
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Filter buttons --}}
            <div class="messenger-filter-tabs">
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-comments"></i> All Messages
                    </button>
                    <button class="filter-btn" data-filter="unread">
                        <i class="fas fa-envelope"></i> Unread Only
                    </button>
                </div>
            </div>
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <div class="saved-messages-section">
                   <p class="messenger-title"><span>Your Space</span></p>
                   {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               </div>
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="-mt-2 m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    {{-- <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div> --}}
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                    <a href="#" class="hidden show-infoSide md:block"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>
</x-app-layout>

<style>
    @media (max-width: 980px) {
    .messenger-listView {
        margin-top: 95px !important;
    }
}

@media (max-width: 1060px) {
    .messenger-infoView {
        margin-top: 95px !important;
    }
}

/* Unread Messages Filter Styles */
.messenger-filter-tabs {
    padding: 10px 15px;
    margin-bottom: 10px;
    position: relative;
    z-index: 10;
    background: white;
}

.filter-buttons {
    display: flex;
    gap: 5px;
}

.filter-btn {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #e0e0e0;
    background-color: #f8f9fa;
    color: #495057;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    position: relative;
    z-index: 11;
}

.filter-btn:hover {
    background-color: #e9ecef;
    border-color: #d0d3d6;
}

.filter-btn.active {
    background-color: var(--primary-color, #2196F3);
    color: white;
    border-color: var(--primary-color, #2196F3);
}

.filter-btn i {
    font-size: 10px;
}

/* Hide sections when showing unread only */
.messenger-filter-unread .favorites-section,
.messenger-filter-unread .saved-messages-section,
.messenger-filter-unread .messenger-title {
    display: none !important;
}

/* Adjust height calculation to account for filter buttons */
.messenger-filter-unread .listOfContacts {
    height: calc(100% - 50px) !important;
}

@media (max-width: 480px) {
    .filter-btn {
        font-size: 10px;
        padding: 6px 8px;
    }
    
    .filter-btn i {
        font-size: 9px;
    }
}
</style>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
