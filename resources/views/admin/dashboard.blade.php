@extends('layouttemp.apps')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <a href="{{ route('admin.create') }}" class="btn btn-md btn-success mb-3">TAMBAH USER</a>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Level</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">AKSI</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td class="text-center">
                                    <img src="{{ Storage::url('public/pp/').$user->image }}" class="rounded" style="width: 150px">
                                    
                                </td>
                                <td>{{ $user->level }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin.destroy', $user->id) }}" method="POST">
                                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                          @empty
                              <div class="alert alert-danger">
                                  Data Blog belum Tersedia.
                              </div>
                          @endforelse
                        </tbody>
                      </table>  
                      {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>Laravel 8 CRUD with Image Upload</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-success" href="{{ route('admin.create') }}"> Create New Users</a>
                            </div>
                            <br>
                        </div>
                    </div>
                
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>level</th>
                            <th>Image</th>
                            <th width="280px">Action</th>
                        </tr>
                
                        @foreach ($users as $user)
                
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->level }}</td>
                            <td><img src="/pp/{{ $user->image }}" width="100px"></td>
                            <td>
                                <form action="{{ route('admin.destroy',$user->id) }}" method="POST">
                                    <a class="btn btn-info" href="{{ route('admin.show',$user->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('admin.edit',$user->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin.destroy', $user->id) }}" method="POST">
                                    <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                
                        @endforeach
                
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    {!! $users->links() !!} --}}
@endsection
@push('after-script')
    <script>
        //message with toastr
        @if(session()->has('success'))
        
            toastr.success('{{ session('success') }}', 'BERHASIL!'); 

        @elseif(session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!'); 
            
        @endif
    </script>
@endpush