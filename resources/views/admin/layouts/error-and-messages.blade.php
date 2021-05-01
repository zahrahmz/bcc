@if(session()->has('message'))
    <div class="box no-border">
        <div class="box-tools col-md-12">
            <p class="alert alert-success alert-dismissible">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
@elseif(session()->has('custom-error'))
    <div class="box no-border ">
        <div class="box-tools col-md-12">
            <p class="alert alert-danger alert-dismissible">
                {{ session()->get('custom-error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
@endif
