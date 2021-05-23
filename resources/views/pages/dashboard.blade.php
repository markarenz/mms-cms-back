@section('pageTitle', 'Dashboard')

@extends('layouts.app')

@section('content')

<h1>DASHBOARD</h1>

<a href="/projects-import" class="btn btn-outline-danger" onclick="return confirm('Importing projects will remove existing projects. Are you sure?');">Import Projects</a>
<br /><br />
<a href="/posts-import" class="btn btn-outline-danger" onclick="return confirm('Importing posts will remove existing posts. Are you sure?');">Import Posts</a>
<br /><br />
<a href="/create_sitemap" class="btn btn-outline-danger">Export Sitemap</a>

@endsection
