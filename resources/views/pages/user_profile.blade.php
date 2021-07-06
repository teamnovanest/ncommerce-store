@extends('layouts.usernav')
@section('content')


<div class="order-detail-header">
    <div class="welcome-message">
        <h2 class="az-dashboard-title">Profile Settings</h2>
    </div>
</div>

<div class="section-center section-center__profile">
    <form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row pd-20 pd-sm-40">
            <div class="col-md-5">
                <h3 class="form__label">Upload profile image</h3>
                <div class="form-group">
                    <div class="image__container">
                        @if ($user->profile_secure_url)
                        <img src="{{$user->profile_secure_url}}" width=130px>
                        @else
                        <img src="{{asset('frontend_new/images/user/user_image.svg')}}" width=130px>
                        @endif
                    </div>
                    <label class="custom-file">
                        <input type="file" id="file" class="custom-file-input" name="image" onchange="readURL(this);">
                        <span class="custom-file-control"></span>

                        <img class="image-preview__container" src="" id="one">


                    </label>
                </div>
            </div>

            <!-- Second column for editing bio -->
            <div class="col-md-6 bio__column">
                <div class="form-group form__field">
                    <label class="form-control-label name__label">Full Name</label>
                    <input class="form-control" type="text" name="full_name" value="{{$user->name}}">
                </div>
                <div class="form-group form__field">
                    <label class="form-control-label">Email</label>
                    <input class="form-control" type="text" name="email" value="{{$user->email}}">
                </div>
                <div class="form-group form__field">
                    <label class="form-control-label">Phone Number</label>
                    <input class="form-control" type="text" name="phone_number" value="{{$user->phone}}">
                </div>
                <div class="form-layout-footer">
                    <button class="btn btn-info mg-r-5">Update Profile</button>
                    <span class="float-right mt-2 del-account"><a href="" id="account-delete-btn" user_id={{$user->id}}>Delete my account ?</a></span>
                </div><!-- form-layout-footer -->
            </div>
            <!-- End of second column -->
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#one')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>

@endsection
