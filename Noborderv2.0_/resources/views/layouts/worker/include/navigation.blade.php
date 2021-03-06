<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/worker/works')}}">Find Work</a>
    </li>
    <li>
    	<a href="{{url('/worker/projects')}}">My Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications_unread) > 0 ? count($notifications_unread) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)

                    <?php
                    $project = json_decode($notification->content);
                    ?>
                    @if ($notification->type == 2)
                    <li id="notification{{$notification->id}}">
                        @if (json_decode($notification->content)->status == 5)
                        <a href="{{url('worker/projects/in_progress/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}} {{$notification->project_id}}">
                            <strong>Project Development </strong>
                            <br> {{$project->name}}
                        </a>
                        @endif
                    </li>
                    @elseif ($notification->type == 3)
                    <li id="notification{{$notification->id}}">
                        <a href="{{url('worker/contract_signing/'.HELPERDoubleEncrypt($notification->project->contract->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}} {{$notification->project_id}}">
                            <strong>New Contract </strong>
                            <br>{{$project->name}}
                        </a>
                    </li>
                    @elseif ($notification->type == 4)
                    <li id="notification{{$notification->id}}">
                        <a href="{{url('worker/contract_signing/'.HELPERDoubleEncrypt($notification->project->contract->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}} {{$notification->project_id}}">
                            <strong>Contract Approve </strong>
                            <br>{{$project->name}}
                        </a>
                    </li>
                    @endif

            @endforeach
        @else
            <li>
                <a>
                    <strong>No Notifications Yet</strong>
                </a>
            </li>
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
                    <a href="" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>{{$message->name}}</strong><br>
                        <span>{{str_limit($message->message, 20)}}</span>
                    </a>
                </li>
            @endforeach
        @else
        <li>
            <a>
                <strong>No Messages Yet</strong>
            </a>
        </li>
        @endif
        </ul>
    </li>
</ul>
