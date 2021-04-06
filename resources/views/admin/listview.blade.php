@extends('admin.base')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $title}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ $name }}</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">    
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <!--- <i class="fas fa-chart-pie mr-1"></i> #} -->
                            {{ $title }}
                        </h3>
                        @if($add)
                        <a href="{{ $add_url }}" class="btn btn-success btn-sm float-right"> <i class="fas fa-plus"></i> Tambah</a>
                        @endif
                    </div>
                    <div class="card-body table-responsive">
                        @include('admin.include.table')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection