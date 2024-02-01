@component('mail::message')
Hello {{ucwords($user)}}

{{$subject}}

@component('mail::table')
|       |   |
| ------------- | --------:|
@foreach ($objectives as $objective)
| <h2>{{Str::limit($objective->name,60,' ...')}} - ({{$objective->team->name??'--'}})</h2><span></span> <div style="border-radius:5px;border:1px solid rgb(192, 192, 192);padding:10px;margin-right:3px;"> <i>Due On :  {{(($objective->due_date)? date('d-M-y', strtotime($objective->due_date)) :'---')}} <br/>  Key Results : {{$objective->other_key_results->count()}} </i> <div>@foreach ($objective->other_key_results as $key_result) <br> <i>  ✱ . {{$key_result->content}} </i> @endforeach </div>  </div>| <h5>  <a target="_blank" href=" {{url('/objectives/'.$objective->id)}}"> <span class="button button-green"  style="font-size: 12px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; top:6px; -webkit-text-size-adjust: none; border-radius: 16px; color: white; display: inline-block; overflow: hidden; text-decoration: none; background-color: #6ee2bb; border-bottom: 2px solid #5fdf98; border-left: 6px solid #5fdf98; border-right: 6px solid #5fdf98; border-top: 2px solid #5fdf98;"> View </span></a></h5>    |
@endforeach

@endcomponent


@lang('Thank You'),<br>
{{ config('app.name') }}



@endcomponent
