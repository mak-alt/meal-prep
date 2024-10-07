@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Edit Post
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Post</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Post title</label>
                                                <input type="text" class="form-control" id="" placeholder="Post title" value="Lorem ipsum dolor sit amet">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Post URL</label>
                                                <input type="text" class="form-control" id="" placeholder="Post URL" value="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1000&q=80">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Post Main Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile"></label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <a class="input-group-text" id=""
                                                           style="cursor: pointer;">Upload</a>
                                                    </div>
                                                </div>
                                                <div class="input_product_img_wrpr">
                                                    <img src="https://via.placeholder.com/150

C/O https://placeholder.com/" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Post Category</label>
                                                <div class="form-group_inner">
                                                    <select name="Country" class="select2 form-control" multiple="multiple">
                                                        <option value="Lorem Ipsum1">Lorem Ipsum1</option>
                                                        <option value="Lorem Ipsum2">Lorem Ipsum2</option>
                                                        <option value="Lorem Ipsum3">Lorem Ipsum3</option>
                                                        <option value="Lorem Ipsum4">Lorem Ipsum4</option>
                                                    </select>
                                                    <a href="#" class="btn btn-block btn-primary">Add Categories</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea class="textarea" placeholder="Place some text here"
                                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
												Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro ea, repellat totam doloremque nemo, minima inventore libero suscipit soluta qui et. Ipsa ratione totam voluptates sit quae eligendi delectus iure.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro ea, repellat totam doloremque nemo, minima inventore libero suscipit soluta qui et. Ipsa ratione totam voluptates sit quae eligendi delectus iure.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro ea, repellat totam doloremque nemo, minima inventore libero suscipit soluta qui et. Ipsa ratione totam voluptates sit quae eligendi delectus iure.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro ea, repellat totam doloremque nemo, minima inventore libero suscipit soluta qui et. Ipsa ratione totam voluptates sit quae eligendi delectus iure.
											</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
