@include('viw_header')
<div class="d-flex vh-100 align-items-center justify-content-center bg-light"> 
             <div class="card shadow p-4" style="width: 22rem;">
                 <h4 class="text-center mb-3">Create an account</h4>
                 <form action="{{route('admin_register')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Name</label>
                        <input type="name" class="form-control" id="exampleInputName" name="name" value="{{ old('name') }}" placeholder="Full name">
                    </div> 
                    <div class="mb-3">
                         <label for="exampleInputEmail1" class="form-label">Email address</label>
                         <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ old('email') }}" placeholder="Enter email">
                     </div>
                     <div class="mb-3">
                         <label for="exampleInputPassword1" class="form-label">Password</label>
                         <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                     </div>

                     <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm password">
                    </div>

                     <button type="submit" class="btn btn-primary w-100">Register</button>
                 </form>
             </div>
        </div>   
    {{-- @include('viw_footer') --}}