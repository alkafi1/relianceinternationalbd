@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mt-5">Post Create</h2>
                <a href="{{ route('post.list') }}" class="btn btn-primary"><span><i class="fas fa-list"></i></span>All
                    Post</a>
            </div>
            <div class="card-body">
                <form action="/submit-form" id="postForm" method="POST" enctype="multipart/form-data">
                    

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Title -->
                            <div class="form-group mt-3">
                                <label for="title" class="required">Title</label>
                                <input type="text" id="title" name="title" class="form-control mt-3" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="slug" class="required">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control mt-3" required>
                            </div>
                        </div>
                    </div>


                    <!-- Image -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <label for="banner" class="required">Image</label>
                                <input type="file" id="banner" name="banner" class="form-control mt-3" required
                                    oninput="pp.src=window.URL.createObjectURL(this.files[0])">
                                <p class="text-danger">Banner must be 800px by 450px</p>
                                <img id="pp" width="200" class="float-start mt-3" src="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <button type="submit" id="submit" class="btn btn-primary mt-4">
                                    <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none"
                                        role="status" aria-hidden="true"></span>
                                    <i class="fas fa-upload"></i> Submit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
