<h1>{{date('Y-m-d H:i:s',time())}}</h1>
@if(auth()->user())
  <h1>User</h1>
  <p> id:{{$user->id}}</p>
@endif
<h1>Request URI</h1>
<h1>{{$_SERVER['REQUEST_URI']}}</h1>
<h1>$_SERVER</h1>
<p>
  {{json_encode($_SERVER)}}
</p>

<h1>Exception Message</h1>
<p>
  {{$e->getMessage()}}
</p>
<h1>Detailed Information</h1>
<p>
  {{$e}}
</p>
