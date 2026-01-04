@extends('layouts.app')
@section('content')
<style>
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
    }

    /* Center the spinner */
    .spinner-border {
        display: inline-block;
        width: 3rem;
        height: 3rem;
        vertical-align: middle;
    }

    .btn--base:disabled,
    .btn--base[disabled] {
        background-color: #6f7ec5;
        border-color: #6f7ec5;
    }

    .os-icon {
        font-family: "Segoe MDL2 Assets";
        font-size: 40px;
        /* Adjust the font size as needed */
    }

    /* Switch styles */
    .switch {
        position: relative;
        display: inline-block;
        width: 54px;
        height: 34px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 8;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        height: 27.5px;
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        border-radius: 34px;
    }

    input:checked+.slider {
        background-color: #3249B3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #3249B3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .custom-select-flag {
        padding-right: 30px;
        /* Leave some space for the flag */
    }

    .custom-select-flag option::before {
        content: '';
        /* Hide the default select arrow in options */
    }

    .select-menu .select-btn {
        display: flex;
        height: 51px;
        background: #fff;
        padding: 0.375rem 0.75rem;
        border: 1px solid #E2E2E2;
        font-size: 15px;
        font-weight: 400;
        border-radius: 4px;
        align-items: center;
        cursor: pointer;
        justify-content: space-between;
    }

    .select-menu .options {
        position: absolute;
        width: 250px;
        overflow-y: auto;
        max-height: 295px;
        padding: 10px;
        margin-top: 5px;
        border-radius: 4px;
        background: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        animation-name: fadeInDown;
        -webkit-animation-name: fadeInDown;
        animation-duration: 0.35s;
        animation-fill-mode: both;
        -webkit-animation-duration: 0.35s;
        -webkit-animation-fill-mode: both;
        padding-bottom: 0px;
    }

    .select-menu .options .option {
        /* display: flex; */
        cursor: pointer;
        padding: 9px 6px;
        align-items: center;
        background: #fff;
        width: 100%;
        border-bottom: 1px solid #cfcfcf;
    }

    .select-menu .options .option:hover {
        background: #f2f2f2;
    }

    .select-menu .options .option i {
        font-size: 25px;
        margin-right: 12px;
    }

    .select-menu .options .option .option-text {
        font-size: 18px;
        color: #333;
    }

    .select-btn i {
        font-size: 14px;
        transition: 0.3s;
    }

    .select-menu.active .select-btn i {
        transform: rotate(-180deg);
    }

    .select-menu.active .options {
        display: block;
        opacity: 0;
        z-index: 10;
        animation-name: fadeInUp;
        -webkit-animation-name: fadeInUp;
        animation-duration: 0.4s;
        animation-fill-mode: both;
        -webkit-animation-duration: 0.4s;
        -webkit-animation-fill-mode: both;
    }
    .service-item.details .service-thumb img {
        width: 100%;
        height: 350px;
        -o-object-fit: cover;
        object-fit: contain;
    }
    @keyframes fadeInUp {
        from {
            transform: translate3d(0, 30px, 0);
        }

        to {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    @keyframes fadeInDown {
        from {
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }

        to {
            transform: translate3d(0, 20px, 0);
            opacity: 0;
        }
    }
</style>

<section class="team-section ptb-80">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 mt-3 mb-4">
                <form id="vmForm" class="vm-form-cls" action="{{ route('vm.buy') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-8 text-center">
                            <div class="section-header">
                                <h2 class="section-title">Pricing <span class="text--base">Plans</span></h2>
                                <div class="d-flex align-items-center justify-content-center">
                                    <h3 class="title mx-3 mb-0">VPN</h3>
                                    <label class="switch">
                                        <input type="checkbox" id="vpnSwitch" name="vpnSwitch" value="13">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-2 col-md-4 col-12 form-group" id="vp-location">
                            <label for="vpn_location">VPN Location <span class="text-danger">*</span></label>
                            <input id="vpn_location" type="text">
                        </div>
                        <input name="amount" id="amount" type="hidden" value="0">
                        <input name="vm" id="vm" type="hidden" >
                        <div class="col-lg-3 col-md-4 col-12 form-group">
                            <div class="select-menu">
                                <label for="vm">VM Tarrif <span class="text-danger">*</span></label>
                                <div class="select-btn">
                                    <span class="sBtn-text">Select your Machine</span>
                                    <i class="fa fa-chevron-down"></i>
                                </div>

                                <ul class="options">
                                    @forelse ($virtualMachienes as $machine)
                                    <li class="option" data-price="{{ $machine->price }}" data-id="{{ $machine->id }}">
                                        <div>
                                            <div>
                                                <label class="option-text"> {{ $machine->name }}</label>
                                            </div>
                                            <div>
                                                <div>
                                                    <small> 
                                                        <img src="{{ asset('assets/icons/cpu-blue.png') }}" alt="" srcset=""> &nbsp;
                                                        CPU: &nbsp; {{ $machine->cpu }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <img src="{{ asset('assets/icons/ram-blue.png') }}" alt="" srcset=""> &nbsp;
                                                        RAM: &nbsp; {{ $machine->ram }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <img src="{{ asset('assets/icons/storage-blue.png') }}" alt="" srcset=""> &nbsp;
                                                        Storage: &nbsp; {{ $machine->storage }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <img src="{{ asset('assets/icons/port-blue.png') }}" alt="" srcset=""> &nbsp;
                                                        Port: &nbsp; {{ $machine->port }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @empty
                                    <li class="option">
                                        <i class="fa fa-desktop" style="color: #E1306C;"></i>
                                        <span class="option-text" value="0">No Machine found.</span>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-12 form-group" id="vm-location">
                            <label for="vm-location">VM Location <span class="text-danger">*</span></label>
                            <input name="vm_location" id="vm_location" type="text">
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 form-group">
                            <label for="os">OS <span class="text-danger">*</span></label>
                            <select class="form--control" name="os" id="os">
                                @forelse ($operatingSystems as $os)
                                    <option value="{{ $os->id }}">{{ $os->name }}</option>
                                @empty
                                    <option disabled selected>No OS found.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 col-12 form-group">
                            <label for="os">Period <span class="text-danger">*</span></label>
                            <select class="form--control" name="period" id="period">
                                @forelse ($periods as $period)
                                    <option value="{{ $period->months }}" data-discount={{ $period->discount }}>
                                        {{ $period->months }} Month</option>
                                @empty
                                    <option disabled selected value="0">No period found.</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-12"></div>
                        <div class="col-lg-4 col-md-6 col-12 text-center">
                            <button type="submit" class="btn--base">
                                <span id="am" class="pr-5">€0.00 </span>
                                <span>Buy Now!</span>
                            </button>
                        </div>
                        <div class="col-lg-4 col-md-3 col-12"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="team-section ptb-80 pt-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-9 col-12 text-center mb-5">
                <h2 class="text--base">Virtual Machienes Installation Guides</h2>
                <p>
                    Check out, step by step how easy it is to setup and use software on your operationg system,
                    select your option to see the proper guide.
                </p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/window.svg') }}" class="w-25 h-25">
                            <h3 class="price-title">Windows</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn">
                            <a href="#" class="btn--base active w-100">Select</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/apple-blue.svg') }}" class="w-25 h-25">
                            <h3 class="price-title">IOS</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn">
                            <a href="#" class="btn--base active w-100">Select</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-30">
                <div class="plan-item">
                    <div class="plan-body">
                        <div class="plan-price-area">
                            <img src="{{ asset('assets/images/icon/linux.svg') }}" class="w-25 h-25">
                            <h3 class="price-title">Linux</h3>
                        </div>
                    </div>
                    <div class="plan-footer">
                        <div class="plan-btn">
                            <a href="#" class="btn--base active w-100">Select</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-section two ptb-80">
    <div class="container">
        <div class="row justify-content-center flex-row-reverse mb-30-none">
            <div class="col-xl-12 col-lg-12 mb-30">
                <div class="service-item three details">
                    <div class="service-thumb">
                        <img width="800" height="600" src="{{asset('/assets/images/software.gif')}}"
                            class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" decoding="async">
                    </div>
                    <div class="service-content two">
                        <h2 class="title">Virtual machines</h2>
                        <div class="service-bottom-content two">
                            <!--<h2 class="title">Service Description</h2>-->
                            <p>Experience the convenience of creating your computer in the cloud with us and break free
                                from limitations. Our solution allows you to work seamlessly, securely accessing your
                                accounts and continuing from where you left off in previous sessions. We provide the
                                perfect environment for your tasks with infinite computing resources available in
                                attractive locations worldwide. Reach out to us and elevate your productivity to new
                                heights.</p>
                            <p>Virtual machines operate as processes within application windows, just like any other
                                software, on the host machine's operating system. These machines consist of essential
                                files such as log files, NVRAM settings, virtual disk files, and configuration files.
                            </p>
                            <p>Leverage the scalability of Virtual Machine Scale Sets to build applications that can
                                grow with your needs. Optimize your cloud expenditure with Azure Spot Virtual Machines
                                and reserved instances. Establish your private cloud using Azure Dedicated Hosts. Run
                                your mission-critical applications on Azure to enhance resilience.</p>
                            <p>Discover the diverse range of computing options offered by Microsoft Azure and explore
                                the extensive portfolio of Azure virtual machines suitable for all workloads, including
                                your own applications. Watch our informative video to gain an overview of Azure's core
                                compute capabilities and gain confidence in the comprehensive security and management
                                features provided by Azure.</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/build/js/countrySelect.js') }}"></script>
<script>
    $(document).ready(function() {
        const vpnSwitch = $('#vpnSwitch');
        const statusText = $('#statusText');
        const vpnLocation = $('#vp-location'); // Added variable for the location div
        $('#vm_location').countrySelect({
            onlyCountries: ['de', 'au', 'at', 'ca', 'be', 'br', 'bg'], 
        });
        vpnLocation.hide(); // Initially hide the location div

        vpnSwitch.on('change', function() { // Fixed the change event handler
            if (vpnSwitch.is(':checked')) { // Use is(':checked') to check the checkbox state
                vpnLocation.show();
                $('#vpn_location').attr('name', 'vpn_location');
                statusText.text('on'); // Use .text() to set the text content
                $("#vpn_location").countrySelect({
                    onlyCountries: ['de', 'au', 'at', 'ca', 'be', 'br', 'bg'], 
                });
            } else {
                vpnLocation.hide();
                statusText.text('off');
                $('#vpn_location').removeAttr('name');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const vpnCheckbox = document.getElementById("vpnSwitch");
        const vmSelect = document.getElementById("vm");
        const periodSelect = document.getElementById("period");
        const amountInput = document.getElementById("amount");
        const buyNowButton = document.querySelector(".btn--base span:first-child");

        function calculateAmount() {
            const vpnCost = vpnCheckbox.checked ? parseFloat(vpnCheckbox.value) : 0;
            const vmPrice = parseFloat(vmSelect.getAttribute('data-price'));
            const period = parseInt(periodSelect.value);
            const discount = parseFloat(periodSelect.options[periodSelect.selectedIndex].getAttribute(
                'data-discount')) / 100; // Convert to decimal
            const baseAmount = vmPrice * period;
            const discountedAmount = baseAmount - (baseAmount * discount);
            const totalAmount = discountedAmount + vpnCost;
            return isNaN(totalAmount) ? 0.0 : totalAmount;  
        }

        function updateAmount() {
            const amount = calculateAmount();
            amountInput.value = amount;
            buyNowButton.textContent = `€${amount.toFixed(2)}`;
        }

        // Attach event listeners to relevant inputs
        vpnCheckbox.addEventListener("change", updateAmount);
        // vmSelect.addEventListener("change", updateAmount);
        periodSelect.addEventListener("change", updateAmount);

        const optionMenu = document.querySelector(".select-menu"),
        selectBtn = optionMenu.querySelector(".select-btn"),
        options = optionMenu.querySelectorAll(".option"),
        sBtn_text = optionMenu.querySelector(".sBtn-text");

    selectBtn.addEventListener("click", () =>
        optionMenu.classList.toggle("active")
    );
    options.forEach((option) => {
        option.addEventListener("click", () => {
            let selectedOption = option.querySelector(".option-text").innerText;
            let dataPrice = option.getAttribute("data-price");
            let dataId = option.getAttribute("data-id");
            const vmInput = document.getElementById('vm');
            // Set the data-price attribute on the input element
            vmInput.setAttribute('data-price', dataPrice);
            vmInput.value = dataId;

            sBtn_text.innerText = selectedOption;

            optionMenu.classList.remove("active");
            updateAmount();
        });
    });
    });
</script>
@endsection
