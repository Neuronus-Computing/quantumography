<!DOCTYPE html>
<html> 
<head>
<meta charset="utf-8"> <title>Virtual Machine - Neuronus Computing</title> 
<style>
    /* Style for the buttons */
    .banner-section.two.inner {
        background: #F5F8FF !important;
        padding-top: 70px;
        padding-bottom: 70px;
    }
    img {
        max-width: 100%;
        height: auto;
    }

    .team-section {
        position: relative;
    }
    .ptb-70 {
        padding: 70px 45px;
    }
    h1, h2, h3, h4, h5, h6 {
        clear: both;
        line-height: 1.3em;
        color: #1C1C1C;
        font-weight: 600;
    }
    .footer-section {
        background-color: #ECF2FF;
        overflow: hidden;
        position: relative;
    }
    .ptb-70-45 {
        padding: 75px 44px;
    }
    article, aside, figcaption, figure, footer, header, hgroup, main, nav, section {
        display: block;
    }

    .footer-section .footer-element-two {
        position: absolute;
        bottom: 20%;
        right: 15%;
        opacity: 0.35;
    }
    .footer-section .footer-element-three {
        position: absolute;
        bottom: 8%;
        right: 12%;
        opacity: 0.35;
    }
    .footer-section .footer-element-four {
        position: absolute;
        top: 12%;
        right: 0;
        width: 1%;
        opacity: 0.25;
    }

    .footer-section .footer-element-five {
        position: absolute;
        top: 18%;
        right: 5%;
        opacity: 0.35;
    }
    .footer-section .footer-element-six {
        position: absolute;
        top: 40%;
        right: 10%;
        opacity: 0.35;
    }
    .footer-section .footer-element-seven {
        position: absolute;
        top: 47%;
        left: 13%;
        opacity: 0.35;
    }
    .default-text-color{
        color: #3248b3 !important
    }
    .btn-email-footer{
        background: #fff;
        padding: 10px 24px;
        border-radius: 5px;
        color: #495255;
    }
    @page {
        size: A4; /* Set the desired page size */
        margin: 0; /* Set all margins to zero */
    }
    body {
        margin: 0; /* Set body margin to zero */
    }

</style>
</head>

<body style="font-family: sans-serif;margin: 0; padding: 0;">
    <section class="banner-section two inner">
        <div style="text-align:center">
            <table width="100%" bgcolor="#f5f8ff">
                <tr>
                    <td align="center" style="padding: 20px;">
                        <h1 style="color: #333333;">Neuronus Computing</h1>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <section class="team-section ptb-70">
        <div class="last-padd">
            <h4 style="font-style: italic;margin-bottom: 0px;font-size: 18px;font-family: sans-serif;">Dear {{$user->name}}</h4>
            <p style="margin-bottom:20px;font-size: 16px;">
                Thank you for choosing <a href="{{ env('APP_URL') }}" class="default-text-color"><strong>  Neuronus.net</strong></a>! Your order <strong> {{ $payment_details->order_no }} </strong> is being processed.
                with the next email you will receive the files for your chosen Virtual Monitor within 24 hours
                on this email address.
                If you have any question regarding this order or need help you can reach us.
            </p>
            <p style="margin:0px;font-size: 16px;">
                Best regards,
            </p>
            <p style="margin:0px;font-size: 16px;">
                <a href="{{ env('APP_URL') }}" class="default-text-color"><strong>Neuronus.net Team</strong></a>
            </p>
        </div>
    </section>

    <footer class="footer-section ptb-70-45" style="text-align:center">
        <!-- <div class="footer-element-two">
            <img src="{{ asset('assets/images/element/element-39.png')}}" alt="element">
        </div>
        <div class="footer-element-three">
            <img src="{{ asset('assets/images/element/element-40.png')}}" alt="element">
        </div>
        <div class="footer-element-four">
            <img src="{{ asset('assets/images/element/element-7.png')}}" alt="element">
        </div>
        <div class="footer-element-five">
            <img src="{{ asset('assets/images/element/element-41.png')}}" alt="element">
        </div>
        <div class="footer-element-six">
            <img src="{{ asset('assets/images/element/element-42.png')}}" alt="element">
        </div>
        <div class="footer-element-seven">
            <img src="{{ asset('assets/images/element/element-39.png')}}" alt="element">
        </div> -->
        <div class="footer-widget">
            <!-- <div class="footer-logo">
                <button class="social-media-cls" style="margin-right:12px;margin-right: 12px;width: 50px;height: 50px;background: rgb(255, 255, 255);border-radius: 50%;color: rgb(73, 82, 85);border: 0px;">
                    <a href="http://" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('assets/icons/facebook-circle.png')}}" style="cursor: pointer;margin-bottom: -4px;cursor: pointer !important;margin-bottom:-4px !important;" alt="facebook">
                    </a>
                </button>
                <button class="social-media-cls" style="margin-right:12px;margin-right: 12px;width: 50px;height: 50px;background: rgb(255, 255, 255);border-radius: 50%;color: rgb(73, 82, 85);border: 0px;">
                    <a href="http://" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('assets/icons/instagram.png')}}" style="cursor: pointer;margin-bottom: -4px;cursor: pointer !important;margin-bottom:-4px !important;" alt="instagram">
                    </a>
                </button>
                <button class="social-media-cls" style="margin-right:12px;margin-right: 12px;width: 50px;height: 50px;background: rgb(255, 255, 255);border-radius: 50%;color: rgb(73, 82, 85);border: 0px;">
                    <a href="http://" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('assets/icons/twitter.png')}}" style="cursor: pointer;margin-bottom: -4px;cursor: pointer !important;margin-bottom:-4px !important;" alt="twitter">
                    </a>
                </button>
            </div> -->
            <p style="font-size: 16px;width: 74%;margin: 20px auto;">
                Neuronus Computing is a team of exceptionally talented people with a very simple goal. To aid
                you in growing the development of your business.
            </p>
            <div>
                <a href="http://" class="btn-email-footer" style="margin-right:12px;cursor: pointer;">
                    Subscribe
                </a>
                <a href="http://" class="btn-email-footer" style="margin-right:12px;cursor: pointer;">
                    Web version
                </a>
                <a href="{{ env('APP_URL') }}" class="btn-email-footer" style="cursor: pointer;">
                    Help
                </a>
            </div>
        </div>
    </footer>
</body>
</html>

