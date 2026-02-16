@include('layouts.header', ['title' => $title ?? 'Message | NF Garage'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('dashboard') }}">Home</a> /
                <h1 class="m-0 ms-2">Message</h1>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12"> <!-- Ganti col-md-6 dengan col-md-12 untuk tabel lebih lebar -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive"> <!-- Menambahkan table-responsive -->
                                <table class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                            <th style="width: 180px">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chat as $index => $message)
                                        <tr>
                                            <td>{{ $loop->iteration + ($chat->currentPage() - 1) * $chat->perPage() }}</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $chat->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

    <!-- /.content-wrapper -->
</div>
</div>
<!-- ./wrapper -->

@include('layouts.footer')