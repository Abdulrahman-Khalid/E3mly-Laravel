@extends('layouts.app')

@section('content')
<table class="table table-sm table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>  
      <th scope="col">How Many</th>
      <th scope="col">Do we Have</th>
    </tr>
  </thead>
<tbody>
    <tr class="bg-info">
      <th scope="row">A</th>
      <td>Admins</td>
      <td>{{$counts['admins_count']}}</td>
    </tr>
    <tr class="bg-info">
      <th scope="row">B</th>
      <td>Moderators</td>
      <td>{{$counts['mod_count']}}</td>
    </tr>
    <tr class="bg-info">
      <th scope="row">C</th>
      <td>Users</td>
      <td>{{$counts['users_count']}}</td>
    </tr>
    <tr class="bg-info">
      <th scope="row">D</th>
      <td>User with the max rating</td>
      <td>{{$counts['maxuser']}}</td>
    </tr>
    <tr class="bg-info">
      <th scope="row">E</th>
      <td>Max rating</td>
      <td>{{$counts['maxrate']}}</td>
    </tr>
</tbody>
</table>

<table class="table table-sm table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>  
      <th scope="col">How Many</th>
      <th scope="col">Do we Have</th>
    </tr>
  </thead>
<tbody>
  <tr class="bg-success">
      <th scope="row">A</th>
      <td>Posts</td>
      <td>{{$counts['posts_count']}}</td>
    </tr>
    
    <tr class="bg-success">
      <th scope="row">B</th>
      <td>Running Projects</td>
      <td>{{$counts['running_projects']}}</td>
    </tr>

    <tr class="bg-success">
      <th scope="row">C</th>
      <td>Pending Projects</td>
      <td>{{$counts['pending_projects']}}</td>
    </tr>
    <tr class="bg-success">
      <th scope="row">D</th>
      <td>Finished Projects</td>
      <td>{{$counts['finished_projects']}}</td>
    </tr>
     <tr class="bg-success">
      <th scope="row">E</th>
      <td>Projects</td>
      <td>{{$counts['project_count']}}</td>
    </tr>
</tbody>
</table>



<table class="table table-sm table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>	
      <th scope="col">How Many</th>
      <th scope="col">Do we Have</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-danger">
      <th scope="row">A</th>
      <td>Feedback against users</td>
      <td>{{$counts['feeds_users']}}</td>
    </tr>
    
    <tr class="bg-danger">
      <th scope="row">B</th>
      <td>Feedback against users</td>
      <td>{{$counts['feeds_posts']}}</td>
    </tr>

    <tr class="bg-danger">
      <th scope="row">C</th>
      <td>Feedback</td>
      <td>{{$counts['feeds']}}</td>
    </tr>

  
  </tbody>
</table>


@endsection