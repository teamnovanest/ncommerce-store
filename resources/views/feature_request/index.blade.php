@extends('layouts.usernav')
@section('content')
<div class="order-detail-header">
    <div class="welcome-message">
        <h2 class="az-dashboard-title">Hi! {{ Auth::user()->name }}</h2>
        <p class="az-dashboard-text">Feature Requests</p>
    </div>
    <div class="sec-center">
        <div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
            <div class="container">
                <div class="az-content-body pd-lg-l-40 d-flex flex-column">
                    <div class="table-responsive">
                        <table class="table mg-b-0">
                            <thead>
                                <tr>
                                    <th>Feature title</th>
                                    <th>Feature Description</th>
                                    <th>Likes</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($requests as $request)
                                <tr>
                                    <td class="pro-name">{{ $request->title }}</td>
                                    <td class="pro-name">{{ $request->description }}</td>
                                    <td id="likes{{$request->id}}">{{$request->likes}}</td>
                                    <td>
                                        @if ($request->user_id === Auth::id())
                                            <a href="{{route('feature.edit',['id'=>$request->id])}}"
                                            class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{route('feature.delete',['id'=>$request->id])}}"
                                            class="btn btn-sm btn-danger">Delete</a>
                                        @else
                                            <button class="like-btn" data-request-id="{{$request->id}}"><i
                                                class="material-icons" id="thumbsup{{$request->id}}"
                                                data-value-id="{{0}}">thumb_up_off_alt</i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="cols-lg-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
