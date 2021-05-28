@extends('layouts.usernav')
@section('content')
<div class="order-detail-header">
    <div class="welcome-message">
        <h2 class="az-dashboard-title">Hi! {{ Auth::user()->name }}</h2>
        <p class="az-dashboard-text">Feature request liked by you</p>
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
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($likes as $like)
                                <tr id="disliked_request{{$like->id}}" >
                                    <td>{{ $like->title }}</td>
                                    <td>{{ $like->description }}</td>
                                    <td>
                                        <button class="like-btn" data-request-id="{{$like->id}}"><i
                                                class="material-icons thumbsup" id="thumbsup{{$like->id}}"
                                                data-value-id="{{1}}">thumb_up_off_alt</i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="center-pagination">
            {{ $likes->links() }}
        </div>
    </div>
</div>
@endsection
