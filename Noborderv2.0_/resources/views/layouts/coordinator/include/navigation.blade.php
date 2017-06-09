<ul class="nav navbar-nav navbar-left text-white">
    <li>
        <a href="{{url('/coordinator/projects')}}">Projects</a>
    </li>
    <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Notifications
            <span class="badge btn-primary-nbc" id="notificationsBadge">{{count($notifications) > 0 ? count($notifications) : ''}}</span>
        </a>
        <ul class="dropdown-menu scrollable-menu" id ="notificationsMenu">
        @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
                <li >
                    <?php
                    $project = json_decode($notification->content);
                    ?>
                    @if ($notification->type == 1)
                    <a href="{{url('/coordinator/projects/published/'.HELPERDoubleEncrypt($project->id))}}" style="word-wrap: break-word; white-space: normal;">
                        <strong>New Project </strong>: {{$project->name}}
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
                    <a href="{{url('/coordinator/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>{{$message->name}}</strong><br>
                        {{$message->message}}
                    </a>
                    @else
                    <a href="{{url('/coordinator/projects/'.HELPERIdentifyStatus($message->type)['_status'].'/'.HELPERDoubleEncrypt($message->project_id))}}" style="word-wrap: break-word; white-space: normal;">
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
