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
                    <?php
                    $project = json_decode($notification->content);
                    ?>
                    @if ($notification->type == 2)
                        @if (json_decode($notification->content)->status == 5)
                        <a href="{{url('worker/projects/in_progress/'.HELPERDoubleEncrypt($project->id))}}" style="word-wrap: break-word; white-space: normal;">
                            <strong>Project Development </strong>: {{$project->name}}
                        </a>
                        @endif
                    @elseif ($notification->type == 3)
                    <a href="{{url('worker/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" style="word-wrap: break-word; white-space: normal;">
                        <strong>New Contract </strong>: {{$project->name}}
                    </a>
                    @elseif ($notification->type == 4)
                    <a href="{{url('worker/projects/contract_signing/'.HELPERDoubleEncrypt($project->id))}}" style="word-wrap: break-word; white-space: normal;">
                        <strong>New Contract </strong>: {{$project->name}}
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
                    <a href="" style="word-wrap: break-word; white-space: normal;background-color: #eee">
                        <strong>{{$message->name}}</strong><br>
                        {{$message->message}}
                    </a>
                    @else
                    <a href="" style="word-wrap: break-word; white-space: normal;">
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
