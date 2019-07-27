@extends('layouts.app')

@section('content')
    <div class="container">
      
      <div class="row">
        
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>
            <div class="panel-body">
              @auth
                     <h4 class="text-right">        {{auth()->user()->name}} سلام</h4>
              @endauth
            </div>
          </div>
        </div>
      </div>
      
      
    </div>
@endsection