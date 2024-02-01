@component('mail::message')
Hello {{ucwords($user)}}

{{$subject}}

@component('mail::table')
|       |   |
| ------------- | --------:|
@foreach ($chat->toUser->chat_messages as $message)
@if ($message->objectives)
| <h2>{{Str::limit(($message->objectives->name??'--'),150,' ...')}} - ({{($message->objectives->team->name??'--')}})</h2><span></span> <br> <div style="border-radius:50%;display:inline-flex"> <img src="{{$message->fromUser->profile_photo_url}}" border="1" style="border-radius:50%;display:block;object-fit:cover"  width="30" height="30">  </span> <span style="border-radius:10px; border-bottom-left-radius:0px; color: white; margin-left: 10px;padding:6px;background-color: rgba(56, 60, 70, 0.5)">{!! $message->chatbox->content !!}</span>     | <h5>  <a target="_blank" href=" {{url('/objectives/'.$message->objectives->id)}}"> <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: white; display: inline-block; overflow: hidden; text-decoration: none; background-color: #6ee2bb; border-bottom: 2px solid #5fdf98; border-left: 6px solid #5fdf98; border-right: 6px solid #5fdf98; border-top: 2px solid #5fdf98;"> View </span></a></h5>
@endif
@endforeach

    @endcomponent


@lang('Thank You'),<br>
{{ config('app.name') }}



@endcomponent
