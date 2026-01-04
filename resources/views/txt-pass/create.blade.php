@extends('layouts.layout')
@section('content')
      <section class="team-section pb-140 pt-80">
        <div class="container service-section-cls">
            <h1>{{$pageTitle}}</h1>
            <form id="custom-checkout-form" action="{{ route('txt.pass.store') }}" method="post">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                        <div class="row"> 
                            <div class="col-12">
                                <h3 class="text-dark mb-5"></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-12">
                                <textarea id="txt" name="text" class="form-control" rows="8" required placeholder="Type your message...">{{old('text') }}</textarea>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="form-group col-lg-4 col-md-4 col-12 d-flex align-items-center">
                                <input type="checkbox" id="check-pass" name="password_protected" style="width:20px;height:20px;" class="m-1 mt-0" value="1" onclick="togglePasswordFields()">
                                <label for="check-pass" class="text-white">Password Protection</label>
                            </div>
                        
                            <!-- Password Fields -->
                            <div id="password-fields" class="form-group col-lg-4 col-md-4 col-12" style="display: none;">
                                <div class="input-group">
                                    <input id="password" type="password" placeholder="Create password..."
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text border-white" id="show-password-toggle" onclick="togglePasswordVisibility('#password')" style="cursor: pointer;">
                                            <i class="fas fa-eye text-white" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="confirm-password-fields" class="form-group col-lg-4 col-md-4 col-12" style="display: none;">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        placeholder="Confirm password..." name="password_confirmation"
                                        autocomplete="new-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text border-white" id="show-password-toggle-confirm" onclick="togglePasswordVisibility('#password-confirm')" style="cursor: pointer;">
                                            <i class="fas fa-eye" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-12 text-center">
                                <input class="btn btn--base w-100" type="submit" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
