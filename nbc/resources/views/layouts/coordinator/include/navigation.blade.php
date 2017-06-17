<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/coordinator/projects')}}" id="projectsMainMenu">My Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" id="notificationsMainMenu" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications_unread) > 0 ? count($notifications_unread) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)

                    <?php
                    $project = json_decode($notification->content);
                    ?>
                    @if ($notification->type == 1)
                    <li id="notification{{$notification->id}}">
                        <a href="{{url('/coordinator/projects/published/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}}">
                            <strong>New Project </strong> <br>
                            <span>{{$project->name}}</span>
                        </a>
                    </li>
                    @elseif ($notification->type == 11)
                    <li id="notification{{$notification->id}}">
                        <a href="{{url('/coordinator/projects/published/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}}">
                            <strong>New Applicant </strong> <br>
                            <span>{{$project->name}}</span>
                        </a>
                    </li>
                    @elseif ($notification->type == 4)
                    <li id="notification{{$notification->id}}">
                        <a href="{{url('/coordinator/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" class="notification {{$notification->seen == 2 ? 'unseen' : ''}}">
                            <strong>Contract Approve </strong> <br>
                            <span>{{$project->name}}</span>
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
        <a href="" class="dropdown-toggle" id="messagesMainMenu" data-toggle="dropdown">Messages
            <span class="badge btn-primary-nbc" id="messagesBadge">{{count($unseen) > 0 ? count($unseen) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id="messagesMenu">
        @if (count($messages) > 0)
            @foreach ($messages as $message)
                <li id="{{$message->project_id}}">
                    <a href="{{url('/coordinator/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" class="chat_message {{$message->seen == 2 ? 'unseen' : ''}}">
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
