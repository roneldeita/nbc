<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/worker/works')}}">Find Work</a>
    </li>
    <li>
    	<a href="{{url('/worker/projects')}}">Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications) > 0 ? count($notifications) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <li >
                    @if ($notification->type == 1)
                    <a href="" style="word-wrap: break-word; white-space: normal;">
                        <strong>New Project </strong>: {{json_decode($notification->content)->name}}
                    </a>
                    @elseif ($notification->type == 2)
                        @if (json_decode($notification->content)->status == 5)
                        <a href="" style="word-wrap: break-word; white-space: normal;">
                            <strong>Project Development </strong>: {{json_decode($notification->content)->name}}
                        </a>
                        @endif
                    @elseif ($notification->type == 3)
                    <a href="" style="word-wrap: break-word; white-space: normal;">
                        <strong>New Contract </strong>: {{json_decode($notification->content)->name}}
                    </a>
                    @elseif ($notification->type == 4)
                    <a href="" style="word-wrap: break-word; white-space: normal;">
                        <strong>Contract Approval </strong>: {{json_decode($notification->content)->name}}
                    </a>
                    @endif
                </li>
            @endforeach
        @endif
        </ul>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Messages
            <span class="badge btn-primary-nbc" id="messagesBadge">{{count($messages) > 0 ? count($messages) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id="messagesMenu">
        @if (count($messages) > 0)
            @foreach ($messages as $message)
                <li >
                    @if ($message->seen == 2)
                    <a href="" style="word-wrap: break-word; white-space: normal;background-color: #eee">

                    </a>
                    @else
                    <a href="" style="word-wrap: break-word; white-space: normal;">

                    </a>
                    @endif
                </li>
            @endforeach
        @endif
        </ul>
    </li>
</ul>
