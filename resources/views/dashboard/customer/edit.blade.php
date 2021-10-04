@extends('dashboard.layouts.app')
@section('title', 'Create a new customer')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit customer: {{ $customer->name }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v3</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

      <h2>Section title</h2>
      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <div>
            Input has errors, please see below !!
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
        <form method="post" enctype="multipart/form-data" action="{{ route('admin.customers.edit.update', $customer->id) }}">
          @csrf
          @method('PUT')
            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="title" name="name" value="{{ old('name',$customer->name)}}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="parent" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                    id="phone" name="phone" value="{{ old('phone',$customer->phone)}}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="parent" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email',$customer->email)}}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="note" class="col-sm-2 col-form-label">Note</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('note') is-invalid @enderror"
                    id="note" name="note" value="{{ old('address',$customer->note)}}">
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                    id="address" name="address" value="{{ old('address',$customer->address)}}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
              <label for="customer_group_id" class="col-sm-2 col-form-label">Nhóm KH</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control @error('customer_group_id') is-invalid @enderror"
                  id="customer_group_id" name="customer_group_id" value="{{ old('customer_group_id',$customer->customer_group_id)}}">
                  @error('customer_group_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
            </div>  

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </main>
</div>
@endsection

