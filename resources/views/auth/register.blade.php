@extends('layouts.auth')
@section('title')
    Đăng ký thành viên
@endsection
@section('content')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <div class="h2 py-3"><span class="text-danger me-2">NZ</span>Fashion</div>
                                        <h4 class="mt-1 mb-5 pb-1">Thế giới thời trang</h4>
                                    </div>

                                    <form action="{{ route('register') }}" method="post">
                                        <div class="form-outline mt-4">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Nhập họ tên" value="{{ old('name') }}" />
                                            <label class="form-label" for="name">Họ tên</label>
                                        </div>
                                        @error('name')
                                            <div class="text-danger">
                                                * {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-outline mt-4">
                                            <input type="text" name="email" class="form-control"
                                                placeholder="Nhập địa chỉ Email" value="{{ old('email') }}" />
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        @error('email')
                                            <div class="text-danger">
                                                * {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-outline mt-4">
                                            <input type="password" name="password" class="form-control"
                                                value="{{ old('password') }}" />
                                            <label class="form-label" for="password">Mật khẩu</label>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">
                                                * {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-outline mt-4">
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Nhập số điện thoại" value="{{ old('phone') }}" />
                                            <label class="form-label" for="phone">Số điện thoại</label>
                                        </div>
                                        @error('phone')
                                            <div class="text-danger">
                                                * {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="form-outline mt-4">
                                            <textarea name="address" class="form-control"
                                                placeholder="Nhập địa chỉ" rows="4">{{ old('address') }}</textarea>
                                            <label class="form-label" for="address">Địa chỉ</label>
                                        </div>
                                        @error('address')
                                            <div class="text-danger">
                                                * {{ $message }}
                                            </div>
                                        @enderror
                                        @csrf
                                        <div class="text-center pt-1 mt-4 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="submit">Tạo tài khoản</button>
                                            @if (\Session::has('authErr'))
                                                <div class="alert alert-danger mt-2 rounded">
                                                    <li> {!! \Session::get('authErr') !!}</li>
                                                </div>
                                            @endif
                                            <a class="text-muted" href="{{ route('login') }}">Quay lại trang đăng nhập</a>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">We are more than just a company</h4>
                                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('style')
    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }

        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
@endsection
