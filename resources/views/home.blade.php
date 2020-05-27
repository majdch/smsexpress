@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">


    <ul class="navbar-nav mr-auto">

    @foreach($data as $d)
      <li class="nav-item active">
        <a class="nav-link" href="/categorie/{{$d->id}}">{{$d->nom}} <span class="sr-only">(current)</span></a>
      </li>

      @endforeach

    </ul>
    <form action="/search" method="post" class="form-inline my-2 my-lg-0">
    {{ csrf_field() }}
      <input class="form-control mr-sm-2" type="search" placeholder="Chercher" name="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">chercher</button>
    </form>
  </div>
</nav>
        <div class="col-md-12">
            @if(Auth::check())
            @foreach(Auth()->user()->item as $item)
            @foreach($item->post as $post)
            @foreach($post->order as $order)
@if($order->accepted == 0)
<div class="alert alert-danger" role="alert">
Nouvelles demandes de location
</div>
@break
  @endif
            @endforeach
            @endforeach
            @endforeach
            @endif
            <div class="card">


                <div class="card-body">
                <div class="row pt-6">

@foreach($posts as $post)

@if($post->date_fin_dispo > date('Y-m-d'))
@if($post->premium==1)
<div class="col-4 pb-5">
<div class="card">
            <div class="card-header" style="background-color:#FFD700;"><a href="/post/{{$post->id}}"><strong style="color:black;">{{$post->item->titre}}</strong></a></div>

            <div class="card-body">
<a href="/post/{{$post->id}}"><img src="/storage/{{ $post->item->image }}" class="w-100" alt="photo"></a>
<h6><a href="/profile/{{$post->item->user->id}}">{{$post->item->user->name.' '.$post->item->user->prenom}}</a></h6>

<h6><a href="/categorie/{{$post->item->categorie->id}}">{{$post->item->categorie->nom}}</a></h6>
<p>Date début du post:{{$post->date_dispo}}<br>
Date fin du post:{{$post->date_fin_dispo}}</p>


<p>{{$post->item->description}}</p>

</div>
        </div>
    </div>
    @endif
@endif
@endforeach
@foreach($posts as $post)

@if($post->date_fin_dispo > date('Y-m-d'))
@if($post->premium==0)
<div class="col-4 pb-5">
<div class="card">
            <div class="card-header"><a href="/post/{{$post->id}}">{{$post->item->titre}}</a></div>

            <div class="card-body">
<a href="/post/{{$post->id}}"><img src="/storage/{{ $post->item->image }}" class="w-100" alt="photo"></a>
<h6><a href="/profile/{{$post->item->user->id}}">{{$post->item->user->name.' '.$post->item->user->prenom}}</a></h6>

<h6><a href="/categorie/{{$post->item->categorie->id}}">{{$post->item->categorie->nom}}</a></h6>
<p>Date début du post:{{$post->date_dispo}}<br>
Date fin du post:{{$post->date_fin_dispo}}</p>


<p>{{$post->item->description}}</p>

</div>
        </div>
    </div>
    @endif
@endif
@endforeach

</div>

                </div>
            </div>
        </div>
        {{ $posts->links() }}
    </div>
</div>
@endsection
