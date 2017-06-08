<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/client/projects')}}">Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications) > 0 ? count($notifications) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <li >
                    @if ($notification->type == 2)
                    <a href="{{url('/client/projects/'.HELPERIdentifyStatus(json_decode($notification->content)->status)['_status'].'/'.HELPERDoubleEncrypt($notification->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>Project Status Updated</strong> : {{json_decode($notification->content)->name}}
                    </a>
                    @elseif ($notification->type == 3)
                    <a href="{{url('/client/projects/contract_signing/'.HELPERDoubleEncrypt($notification->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>New Contract</strong> : {{json_decode($notification->content)->name}}
                    </a>
                    @elseif ($notification->type == 4)
                    <a href="{{url('/client/projects/contract_signing/'.HELPERDoubleEncrypt($notification->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>Contract Approval</strong> : {{json_decode($notification->content)->name}}
                    </a>
                    @elseif ($notification->type == 11)
                    <a href="{{url('/client/projects/published/'.HELPERDoubleEncrypt($notification->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>New Applicant</strong> : {{json_decode($notification->content)->name}}
                    </a>
                    @endif
                </li>
            @endforeach
        @endif
        </ul>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Messages
            <span class="badge btn-primary-nbc" id="messagesBadge">{{count($unseen) > 0 ? count($unseen) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id="messagesMenu">
        @if (count($messages) > 0)
            @foreach ($messages as $message)
                <li id="{{$message->id}}">

                    @if ($message->seen == 2)
                    <a href="{{url('/client/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>{{$message->name}}</strong><br>
                        {{$message->message}}
                    </a>
                    @else
                    <a href="{{url('/client/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" style="word-wrap: break-word; white-space: normal;">
                        <strong>{{$message->name}}</strong><br>
                        {{$message->message}}
                    </a>
                    @endif
                </li>
            @endforeach
        @endif
        </ul>
    </li>
</ul>
