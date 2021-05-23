@section('pageTitle', 'Projects')

@extends('layouts.app')

@section('content')
@php $status_labels=array('Draft','Published'); @endphp

<div class="row">
  <div class="col-md-6">
    <h1>Projects</h1>
  </div>
  <div class="col-md-6 text-right">
    <a href="/project-new" class="btn btn-outline-success my-2 my-sm-0">New Project</a>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter">
        <thead>
          <tr>
            <th class="header">ID </th>
            <th class="header">Title </th>
            <th class="header">Status </th>
            <th class="header">Date Published</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
            <tr>
              <td>{{$project->id}}</td>
              <td>{{$project->title}}</td>
              <td>{{$status_labels[$project->status]}}</td>
              <td>{{ date ("m/d/Y", strtotime($project->pub_date)) }}</td>
              <td>
                <a class="btn btn-outline-primary" href="/project-edit/{{$project->id}}" role="button">Edit Project</a>
                <a class="btn btn-outline-danger" href="#" role="button" onclick="$('#form_del_{{$project->id}}').submit(); return false;">Delete Project</a>
                <form id="form_del_{{$project->id}}" action="/project-delete/{{$project->id}}" method="POST">
                  {{ csrf_field() }}
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>


@endsection
