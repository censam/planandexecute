@php
    $done_all = 0;
@endphp
@component('mail::message')
# Hello {{ucwords($objective->user->name)}}

@component('mail::panel')
### Name:
{{ucwords($objective->name)}}
@endcomponent
Objective due on **{{ucwords($due_date)}}**


@if ($objective->other_key_results->count())

As  {{(($objective->type==0)?'an **Individual**':'a **Team**')}} objetive , You have completed <span>
@if ($objective->completed_key_result_count==$objective->other_key_results->count())
@php
    $done_all = 1;
@endphp
<span class="button button-green"  style="font-size: 12px;box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #48bb78; border-bottom: 2px solid #48bb78; border-left: 6px solid #48bb78; border-right: 6px solid #48bb78; border-top: 2px solid #48bb78;">{{$objective->completed_key_result_count}} / {{$objective->other_key_results->count()}}</span> Key Results.Looks like you have completed all key results.Change The Status to 'Completed'.
@elseif ($objective->completed_key_result_count!=$objective->other_key_results->count())
<span class="button button-green"  style="font-size: 12px;box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #db20a3; border-bottom: 2px solid #db20a3; border-left: 6px solid #db20a3; border-right: 6px solid #db20a3; border-top: 2px solid #db20a3;">{{$objective->completed_key_result_count}} / {{$objective->other_key_results->count()}}</span> Key Results.
@else
<span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #222523; border-bottom: 2px solid #222523; border-left: 6px solid #222523; border-right: 6px solid #222523; border-top: 2px solid #222523;">0</span> Key Results.
@endif
</span>
 @else
 As  {{(($objective->type==0)?'an **Individual**':'a **Team**')}} objetive , You have not any key results. <span>
 @endif
 Objective status as <span>
    @if ($objective->completed==2)
    <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #b6602e; display: inline-block; overflow: hidden; text-decoration: none; background-color: #fef3c7; border-bottom: 2px solid #fef3c7; border-left: 6px solid #fef3c7; border-right: 6px solid #fef3c7; border-top: 2px solid #fef3c7;">In Progress</span>
    This is a kindly reminder to start it and complete the Objective.
    @elseif ($objective->completed==0)
    <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #3869ee; border-bottom: 2px solid #3869ee; border-left: 6px solid #3869ee; border-right: 6px solid #3869ee; border-top: 2px solid #3869ee;">Not Started</span>
    .This is a kindly reminder to start it and complete the Objective.
    @elseif ($objective->completed==3)
    <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #c02d13; border-bottom: 2px solid #c02d13; border-left: 6px solid #c02d13; border-right: 6px solid #c02d13; border-top: 2px solid #c02d13;">Missed</span>
    @endif
    </span>

@component('mail::button', ['url' => $url,'color'=>'red'])
View Objective
@endcomponent

@if ($objective->description)
@component('mail::panel')
### Content:
{{ Str::limit($objective->description ,550,'(....more)')}}
@endcomponent
@endif

@if ($objective->other_key_results->count()>0)

------------------------------------------------------
@component('mail::table')
| Key Result      | Status  |
| ------------- | --------:|
@foreach ($objective->other_key_results as $each_key_result)
| {{Str::limit($each_key_result->content,150,' ...')}}      | <h5>{{(($each_key_result->completed==1)?'Completed':'--')}}</h5>    |
@endforeach
---------------------------------------------------
@endcomponent

@endif
Thanks,<br>
{{ config('app.name') }}



@endcomponent
