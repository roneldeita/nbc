<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/client/projects')}}">Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications_unread) > 0 ? count($notifications_unread) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <li id="notif{{strtotime($notification->created_at)}}">
                    <?php
                    $project = json_decode($notification->content);
                    ?>
                    @if ($notification->type == 2)
                    <a href="{{url('/client/projects/'.HIS($notification->project->status).'/'.HELPERDoubleEncrypt($project->id) )}}" class="{{$notification->seen == 2 ? 'unseen' : ''}} notif{{$notification->project_id}}">
                        <strong>Project Status Updated</strong>
                        <br>{{$project->name}}
                    </a>
                    @elseif ($notification->type == 3)
                    <a href="{{url('/client/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}} notif{{$notification->project_id}}">
                        <strong>New Contract</strong>
                        <br> {{$project->name}}
                    </a>
                    @elseif ($notification->type == 11)
                    <a href="{{url('/client/projects/published/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}} notif{{$notification->project_id}}">
                        <strong>New Applicant</strong>
                        <br>{{$project->name}}
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
                <li id="{{$message->project_id}}">
                    <a href="{{url('/client/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" class="chat_message {{$message->seen == 2 ? 'unseen' : ''}}">
                        <strong>{{$message->name}}</strong><br>
                        <span>{{str_limit($message->message, 20)}}</span>
                    </a>
                </li>
            @endforeach
        @endif
        </ul>
    </li>
</ul>
