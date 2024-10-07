@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            Posts
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Posts</li>
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
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Description</th>
                                        <th>Category Tag</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>123</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>
                                            <a href="https://images.unsplash.com/photo-1607082349566-187342175e2f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1050&amp;q=80">https://images.unsplash.com/photo-1607082349...</a>
                                        </td>
                                        <td>Lorem ipsum dolor sit amet consectetur adipisicing el...</td>
                                        <td>
                                            Category Tag
                                        </td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.blog.posts.edit', 1) }}" class="btn btn-block btn-primary">Edit</a>
                                                <a href="" class="btn btn-block btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>
                                            <a href="https://images.unsplash.com/photo-1607082349566-187342175e2f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1050&amp;q=80">https://images.unsplash.com/photo-1607082349...</a>
                                        </td>
                                        <td>Lorem ipsum dolor sit amet consectetur adipisicing el...</td>
                                        <td>
                                            Category Tag
                                        </td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.blog.posts.edit', 1) }}" class="btn btn-block btn-primary">Edit</a>
                                                <a href="" class="btn btn-block btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>
                                            <a href="https://images.unsplash.com/photo-1607082349566-187342175e2f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1050&amp;q=80">https://images.unsplash.com/photo-1607082349...</a>
                                        </td>
                                        <td>Lorem ipsum dolor sit amet consectetur adipisicing el...</td>
                                        <td>
                                            Category Tag
                                        </td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.blog.posts.edit', 1) }}" class="btn btn-block btn-primary">Edit</a>
                                                <a href="" class="btn btn-block btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>123</td>
                                        <td>Lorem ipsum dolor sit amet</td>
                                        <td>
                                            <a href="https://images.unsplash.com/photo-1607082349566-187342175e2f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1050&amp;q=80">https://images.unsplash.com/photo-1607082349...</a>
                                        </td>
                                        <td>Lorem ipsum dolor sit amet consectetur adipisicing el...</td>
                                        <td>
                                            Category Tag
                                        </td>
                                        <td>
                                            <div class="table_actions_btns">
                                                <a href="{{ route('backend.blog.posts.edit', 1) }}" class="btn btn-block btn-primary">Edit</a>
                                                <a href="" class="btn btn-block btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection
