<div class="modal fade" id="address_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="order_new_address_form address-container" >
                    @csrf
                    @auth
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @endauth
                    <input type="hidden" name="address_id" value="" class="address_id">

                    <div class="row">
                        <div class="col-md-6 col-xs-12 mt-3">
                            <div class="form-group">
                                <label class="form-label">First Name<span class="required-field">*</span></label>
                                <input type="text" name="first_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Last Name<span class="required-field">*</span></label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 mt-3">
                            <div class="form-group">
                                <label class="form-label">Email<span class="required-field">*</span></label>
                                <input type="email" name="email" class="form-control">
                                <div class="invalid-feedback">
                                    Please enter valid email.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12 mt-3">
                            <div class="form-group">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 mt-3">
                            <div class="form-group">
                                <label class="form-label">Phone<span class="required-field">*</span></label>
                                <input type="tel" name="phone" class="form-control phone" id="order_new_address_form_phone">
                                <div class="invalid-feedback error-msg">
                                    Please enter valid phone number.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-3">
                            <div class="form-group">
                                <label class="form-label">Address<span class="required-field">*</span></label>
                                <input type="text" name="address" class="form-control address" id="address" autocomplete="false">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="form-label">Unit/Apartment/Suite</label>
                                <input type="text" name="unit" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="form-label">ZIP<span class="required-field">*</span></label>
                                <input type="text" name="zip" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="form-label">City<span class="required-field">*</span></label>
                                <input type="text" name="city" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label class="form-label">State<span class="required-field">*</span></label>
                                <input type="text" name="state"  class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="default" id="default_address">
                                <label class="form-check-label" for="default_address">
                                    Set as my preferred address
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3 d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>