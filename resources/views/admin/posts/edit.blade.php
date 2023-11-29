@extends('layouts.admin')
@section('title')
    Chỉnh sửa bài viết
@endsection
@section('content')
    <section class="p-5">
        <form action="{{ route('quan-ly-bai-viet.update', ['quan_ly_bai_viet' => $post]) }}" method="post" enctype="multipart/form-data">
            <div class="col-lg-12">
                <div class="card">
                    @csrf
                    @method('PUT')
                    <div class="card-header">Quản lý bài viết</div>
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">CHỈNH SỬA BÀI VIẾT</h3>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="title" class="control-label mb-1">Tên bài viết</label>
                            <input name="title" type="text" class="form-control" value="{{ $post->title }}">
                            @error('title')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tag" class="control-label mb-1">Hashtag</label>
                            <input name="tag" type="text" class="form-control" value="{{ $post->tag }}">
                            @error('tag')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="control-label mb-1">Nội dung</label>
                            <textarea name="content" id="content" type="text" class="form-control">{{ $post->content }}</textarea>
                            @error('content')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <script>
                                CKEDITOR.replace('content');
                            </script>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="control-label mb-1">Hình ảnh</label>
                            <input name="photo" type="file" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ old('photo') }}">
                            @error('photo')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info btn-block mt-3 text-white">
                                <span>Cập nhật</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
