@section('pageTitle', 'Pages')

@extends('layouts.app')

@section('content')
@php $status_labels=array('Draft','Published'); @endphp

<div class="row">
  <div class="col-md-6">
    <h1>Pages</h1>
  </div>
  <div class="col-md-6 text-right">
    <a href="/page-new" class="btn btn-outline-success my-2 my-sm-0">New Page</a>
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
            <th class="header">Slug </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pages as $page)
            <tr>
              <td>{{$page->id}}</td>
              <td>{{$page->title}}</td>
              <td>{{$status_labels[$page->status]}}</td>
              <td>{{$page->slug}}</td>
              <td>
                <a class="btn btn-outline-primary" href="/page-edit/{{$page->id}}" role="button">Edit Page</a>
                <a class="btn btn-outline-danger" href="#" role="button" onclick="$('#form_del_{{$page->id}}').submit(); return false;">Delete Page</a>
                <form id="form_del_{{$page->id}}" action="/page-delete/{{$page->id}}" method="POST">
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
