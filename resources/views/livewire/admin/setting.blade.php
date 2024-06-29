@section('title', 'Setting')
<div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting Aplikasi</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <form method="POST" wire:submit.prevent="store()">
                                    <div class="form-group">
                                        <label for="emailAdmin">Email Admin</label>
                                        <input type="email" wire:model.defer="email" class="form-control"
                                            id="emailAdmin" placeholder="Enter Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword">Password Admin <small>(Optional)</small></label>
                                        <input type="password" wire:model.defer="password" class="form-control"
                                            id="newPassword" placeholder="Enter New Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="whatsApp">No Whatsapp</label>
                                        <input type="text" wire:model.defer="whatsapp" class="form-control"
                                            id="whatsApp" placeholder="Nomor Whatsapp" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
