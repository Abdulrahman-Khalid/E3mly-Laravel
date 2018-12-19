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
      <td>Users</td>
      <td>{{$counts['users_count']}}</td>
    </tr>
    
    <tr class="bg-info">
      <th scope="row">B</th>
      <td>Moderators</td>
      <td>{{$counts['mod_count']}}</td>
    </tr>

    <tr class="bg-success">
      <th scope="row">C</th>
      <td>Posts</td>
      <td>{{$counts['posts_count']}}</td>
    </tr>

    <tr class="bg-info">
      <th scope="row">D</th>
      <td>Running Projects</td>
      <td>{{$counts['running_projects']}}</td>
    </tr>

    <tr class="bg-secondary">
      <th scope="row">E</th>
      <td>Pending Projects</td>
      <td>{{$counts['pending_projects']}}</td>
    </tr>

    <tr class="bg-success">
      <th scope="row">F</th>
      <td>Finished Projects</td>
      <td>{{$counts['finished_projects']}}</td>
    </tr>

    <tr class="bg-warning">
      <th scope="row">G</th>
      <td>Total Projects</td>
      <td>{{$counts['project_count']}}</td>
    </tr>
	<tr class="bg-danger">
      <th scope="row">H</th>
      <td>Feedbacks</td>
      <td>{{$counts['feeds']}}</td>
    </tr>

  </tbody>
</table>


@endsection