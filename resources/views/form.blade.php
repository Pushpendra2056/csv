<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <div class="container  p-4">
      
      <form method="POST" action="{{ url('/form-submit') }}">
        @csrf
        <label for="name" class="col-sm-2 col-form-label">Enter Your Name</label><br>
        <div class="mb-3 row">
          <div class="col-sm-10">
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ session('username') }}"> 
          </div>
          <span class="text-danger">
            @error('name')
               {{ $message }}
            @enderror
          </span>
        </div>
        <label for="email" class="col-sm-2 col-form-label">Enter Your Gmail</label><br>
        <div class="mb-3 row">
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email" value="{{session('useremail')}}" name="email">
          </div>
          <span class="text-danger">
            @error('email')
               {{ $message }}
            @enderror
          </span>
        </div>
        <label for="number" class="col-sm-2 col-form-label">Enter Your Number</label><br>
        <div class="mb-3 row">
          <div class="col-sm-10">
            <input type="number" class="form-control" value="{{session('count')}}" id="number" name="number">
          </div>
          <span class="text-danger">
            @error('number')
               {{ $message }}
            @enderror
          </span>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </form>
    </div>
  </body>
</html>