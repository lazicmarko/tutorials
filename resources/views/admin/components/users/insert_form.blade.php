<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <p class="lead">Add new user</p>
            @empty(!session('message'))
              <div class="alert alert-success">{{ session('message') }}</div>
            @endempty

            @isset($errors)
              @if($errors->any())
                @foreach($errors->all() as $error)
                  <div class="alert alert-danger"> {{ $error }} </div>
                @endforeach
              @endif
            @endisset
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
              
              {{ csrf_field() }}
              
              <div class="form-group">
                <label>Korisnicko ime:</label>
                <input type="text" name="korisnickoIme" class="form-control" value="{{ old('korisnickoIme') }}"/>
              </div>
                <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}"/>
              </div>
            <div class="form-group">
                <p><i>Uloga:</i></p>
                @foreach($roles as $role)
                    <input id="role{{$role->id}}" name="role_id" class="chk-col-deep-purple" value="{{ $role->id }}" type="radio">
                    <label for="role{{$role->id}}"> {{ $role->naziv }} </label>
                @endforeach              
              <div class="form-group">
                <label>Lozinka:</label>
                <input type="password" name="lozinka" class="form-control" value="{{ (isset($korisnik))? $korisnik->lozinka : old('lozinka') }}"/>
              </div> 
               <div class="form-group">
                <input type="submit" value="Add" class="btn btn-default" />
                <a href="{{ route("users.index") }}" class="btn btn-warning waves-effect">Cancel</a>
              </div> 
            </form>
    </div>
</div>
