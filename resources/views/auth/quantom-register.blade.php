@extends('layouts.vangography')
@php 
    $pageTitle = "Register"; 
@endphp
@section('content')
<style>
    .main-section-auth h2,
    .main-section-auth .main-login-quantum label {
        color: #fff;
    }
    .main-section-auth .main-login-quantum input{
        background: transparent;
        border: 0;
        margin-top: 0 !important;
        color: #fff;
    }
    .btn--base.quantum-bg-btn{
        background-color: #2CB1EF;
        border-color: #2CB1EF;
    }

    .text-white{
        color: #fff;
    }

    .text-light-grey{
        color: #C8C8C8
    }

    .color-link{
        color: #03bff1;
    }

    @media only screen and (max-width: 881px) {
        .main-login-quantum .main-block-div{
            display: block !important;
        }
    }
</style>
<section class="main-section-auth mt-3 mb-3 ptb-30">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-2 col-12"></div>
            <div class="col-xl-8 col-12 contact-form">
                <div class="section-header text-center">
                    <img src="{{ asset('assets/images/quantumography/icon-auth.svg') }}" class="mb-3" style="width: 110px;">
                    <h2 class="section-title mb-3">Your Seed</h2>
                </div>
                <form method="POST" class="mx-auto" action="{{ route('quantom.user.register') }}" id="registerForm">
                    @csrf
                    <x-seed-input :seed="$seed" :removable="false" :showButtons="true" />

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn--base quantum-bg-btn w-100">
                                {{ __('Next') }} 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-2 col-12"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const seedInput = document.getElementById('seedInput');
        const seedTagsContainer = document.getElementById('seedTagsContainer');

        // Function to update the hidden seed input
        const updateSeedInput = () => {
            const tags = Array.from(seedTagsContainer.querySelectorAll('.tag')).map(tag => 
                tag.textContent.trim().replace(/\s×$/, '') // Remove the close icon text
            );
            seedInput.value = tags.join(' ');
        };

        // Remove a tag on clicking the close icon
        seedTagsContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-tag')) {
                const tagElement = event.target.parentElement;
                seedTagsContainer.removeChild(tagElement);
                updateSeedInput();
            }
        });

        // Update the seed input on form submission
        const registerForm = document.getElementById('registerForm');
        registerForm.addEventListener('submit', updateSeedInput);
    });
</script>

<style>
    .tags-container {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        padding: 8px;
        border-radius: 8px;
    }

    .tags-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 8px;
        background: linear-gradient(161.72deg, #002E59 31.7%, #0061BF 92.51%);
        z-index: -1;
    }

    .tag {
        background-color: #f0f0f0;
        border-radius: 20px;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        font-size: 14px;
    }
    .tag .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        color: #ff0000;
    }
</style>
@endsection
