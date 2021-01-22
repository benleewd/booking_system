<div class="container">
    <div class="row">
        <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Register</h3>
                <hr>
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <form action="/addfacility" method="post">
                    <div class="form-group">
                        <label for="Facility Name">Facility Name</label>
                        <input type="text" class="form-control" name="fname" id="Facility Name">
                    </div>
                    <div class="form-group">
                        <label for="qty">Number of Facilities</label>
                        <input type="qty" class="form-control" name="qty" id="qty" value="">
                    </div>
                    <hr>
                    <?php if (isset($validation)): ?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Add Facilities</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>