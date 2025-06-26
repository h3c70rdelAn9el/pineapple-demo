<?php
$seenIcon = (!!$seen ? 'check-double' : 'check');
$timeAndSeen = "<span data-time='$created_at' class='message-time'>
        ".($isSender ? "<span class='fas fa-$seenIcon' seen'></span>" : '' )." <span class='time'>$timeAgo</span>
    </span>";

// Check if the sender is an admin
$isAdminSender = false;
if (isset($from_id)) {
    $senderUser = \App\Models\User::find($from_id);
    $isAdminSender = $senderUser && $senderUser->admin == 1;
}
?>

<div class="message-card @if($isSender) mc-sender @endif @if($isAdminSender && !$isSender) admin-message @endif" data-id="{{ $id }}">
    {{-- Delete Message Button --}}
    @if ($isSender)
        <div class="actions">
            <i class="fas fa-trash delete-btn" data-id="{{ $id }}"></i>
        </div>
    @endif
    {{-- Card --}}
    <div class="message-card-content">
        {{-- Admin Badge --}}
        @if($isAdminSender && !$isSender)
            <div class="admin-badge">
                <span class="admin-label">Admin</span>
            </div>
        @endif
        
        @if (@$attachment->type != 'image' || $message)
            <div class="message">
                {!! ($message == null && $attachment != null && @$attachment->type != 'file') ? $attachment->title : nl2br($message) !!}
                {!! $timeAndSeen !!}
                {{-- If attachment is a file --}}
                @if(@$attachment->type == 'file')
                <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName'=>$attachment->file]) }}" class="file-download">
                    <span class="fas fa-file"></span> {{$attachment->title}}</a>
                @endif
            </div>
        @endif
        @if(@$attachment->type == 'image')
        <div class="image-wrapper" style="text-align: {{$isSender ? 'end' : 'start'}}">
            <div class="image-file chat-image" style="background-image: url('{{ Chatify::getAttachmentUrl($attachment->file) }}')">
                <div>{{ $attachment->title }}</div>
            </div>
            <div style="margin-bottom:5px">
                {!! $timeAndSeen !!}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Admin message styling */
.admin-message {
    position: relative;
}

.admin-badge {
    margin-bottom: 4px;
}

.admin-label {
    display: inline-block;
    background-color: #3B82F6;
    color: white;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.admin-message .message {
    border-left: 3px solid #3B82F6;
    padding-left: 8px;
}
</style>
