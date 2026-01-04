@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/go.min.js"></script>
<section class="team-section two ptb-30">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <h2>Image Enlarge API</h2>
                <p> Our image enlarger uses sophisticated AI to increase image resolution, optimized to
                     deliver amazing quality for product images, AI images, and images of people. Our proprietary AI technology is 
                     engineered to maintain detail and color accuracy, resulting in images that are free from typical upscaling artifacts.              
                .</p>
                <p><strong>Endpoint:</strong> <small class="text-success">(POST)</small> <span class="text-primary">{{ env('APP_URL') }}/api/image-enlarger</span></p>
                <h4>Request Parameters</h4>
                <ul>
                    <li>
                        <h6>image (file) <small>required</small> </h6> 
                        <p>The image file to be enlarged (JPEG, PNG, or JPG, max 3MB) .</p>
                    </li>
                    <li>
                        <h6>noise (enum) <small>required</small> </h6> 
                        <p>Level of noise reduction where -1 no noise reduction (must be from -1, 0, 1, 2, 3).</p>
                    </li>
                    <li>
                        <h6>scale (enum) <small>required</small> </h6> 
                        <p>Scaling factor for image enlargement (must be from 1, 2, 3, 4, 8).
                        </p>
                    </li>
                    <li>
                        <h6>format (enum) <small>required</small> </h6> 
                        <p>Output format for the enlarged image (must be from PNG, WebP, JPG, JPEG).</p>
                    </li>
                </ul>
                <h4 class="mt-2">Request Headers</h4>
                <ul>
                    <li class="d-flex"><h6>X-Neurnous-Api-Key:</h6>  Your API key.</li>
                    <li class="d-flex"><h6>X-Neurnous-Secret-Key:</h6>  Your secret key.</li>
                </ul>
                <h4 class="mt-2">Response</h4>
                <ul>
                        <li><h6>Success Response:</h6></li>
                        <ul>
                            <li>HTTP Status Code: <span class="text-success">200 OK </span></li>
                            <li>Body:</li>
                        </ul>
<pre>
<code class="language-json">{
    "message":"Success.",
    "success":true,
    "download_url":"{{env('APP_URL')}}/storage/images/1x_GO3ZtFnW7j_1701844208.png",
    "total_requests":50,
    "used_request":5,
    "remaining_requests": 45
}</code>
</pre>
                    <li><strong>Error Response:</strong></li>
                    <ul>
                        <li>HTTP Status Code: <span class="text-danger">401 Unauthorized </span></li>
                        <li>Body:</li>
                    </ul>
<pre>
<code class="language-json">{
    "message": "false.",
    "success": false,
    "message": "Invalid API key or secret key"
}</code>        
</pre>
                    <ul>
                        <li>HTTP Status Code: <span class="text-danger">429 Too Many Requests</span></span></li>
                        <li>Body:</li>
                    </ul>
<pre>
<code class="language-json">{
    "message":"false.",
    "success":false,
    'message':'You already used allowed image requests, please upgrade your subscription for more requests.'
}</code>
</pre>            
                <ul>
                    <li>HTTP Status Code: <span class="text-danger">422  Unprocessable Entity</span></li>
                    <li>Body:</li>
                </ul>
<pre>
<code class="language-json">{
    "message":"false.",
    "success": false,
    "errors": {
        "image": [
        "The image field is required."
        ]
    }
}</code>
</pre>
                </ul>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <h4>Test End Point</h4>
                    <!-- API Testing Form -->
                        <form id="apiTestForm" class="mt-4">
                            <div class="mb-3">
                                <label for="apiKey" class="form-label">API Key:</label>
                                <input type="text" class="form--control" id="apiKey" name="apiKey" onchange="updateCode()" required>
                            </div>

                            <div class="mb-3">
                                <label for="secretKey" class="form-label">Secret Key:</label>
                                <input type="text" class="form--control" id="secretKey" name="secretKey" onchange="updateCode()" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="form--control" id="image" name="image" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="noise" class="form-label">Noise:</label>
                                <select class="form--control" id="noise" name="noise" onchange="updateCode()" required>
                                    <option value="-1" selected>-1</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="scale" class="form-label">Scale:</label>
                                <select class="form--control" id="scale" name="scale" onchange="updateCode()" required>
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="8">8</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="format" class="form-label">Format:</label>
                                <select class="form--control" id="format" name="format" onchange="updateCode()" required>
                                    <option value="png" selected>PNG</option>
                                    <option value="webp">WebP</option>
                                    <option value="jpg">JPG</option>
                                    <option value="jpeg">JPEG</option>
                                </select>
                            </div>
                            <div class="my-3">
                                <button type="button" class="btn btn--base my-4" onclick="testApi()">Test Endpoint</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="d-flex justify-content-between">
                            <select id="languageSelect" class="" onchange="updateCode()">
                                {{-- <option value="php" >PHP (cURL)</option> --}}
                                <option value="js" selected>JavaScript (Fetch API)</option>
                                <option value="ajax">Ajax (jQuery)</option>
                            </select>
                            <button class="btn btn--base btn-sm mb-4" onclick="copyCode()">Copy Code</button>
                        </div>                      
                        <div id="codeContainer"></div>
                           
                    </div>
                    <div class="col-12">
                        <h4>Response <small>(Test end point result will be shown here)</small></h4>
<pre>
<code class="language-json" id="response">example:
{
    "message":"Success.",
    "success":true,
    "download_url": "{{env('APP_URL')}}/storage/images/1x_GO3ZtFnW7j_1701844208.png",
    "total_requests": 50,
    "used_request": 5,
    "remaining_requests": 45
}</code>
</pre>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
            <h4>Get Request Details API</h4>
                <p><strong>Endpoint:</strong> <small class="text-success">(GET)</small> <span class="text-primary">{{ env('APP_URL') }}/api/image-enlarger-get-requests</span></p>
                <h4>Description</h4>
                <p>This API retrieves details about the user's image enlargement requests, including the total number of allowed requests, the number of used requests in the current month, and the remaining available requests.</p>
                <h4 class="mt-2">Request Headers</h4>
                <ul>
                    <li class="d-flex"><h6>X-Neurnous-Api-Key:</h6>  Your API key.</li>
                    <li class="d-flex"><h6>X-Neurnous-Secret-Key:</h6>  Your secret key.</li>
                </ul>
                <h4 class="mt-2">Response</h4>
                <ul>
                    <li><h6>Success Response:</h6></li>
                    <ul>
                        <li>HTTP Status Code: <span class="text-success">200 OK </span></li>
                        <li>Body:</li>
                    </ul>
<pre>
<code class="language-json" id="response">{
    "message": "Success.",
    "success": true,
    "total_requests": 100,
    "used_request": 25,
    "remaining_requests": 75
}</code>
</pre>
                    <li><strong>Error Response:</strong></li>
                    <ul>
                        <li>HTTP Status Code: <span class="text-danger">401 Unauthorized </span></li>
                        <li>Body:</li>
                    </ul>
<pre>
<code class="language-json" id="response-get">{
    "message": "false.",
    "success": false,
    "message": "Invalid API key or secret key"
}</code>
</pre>
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
var path ="{{ env('APP_URL') }}/api/image-enlarger";
function testApi() {
    // Show the preloader
    document.querySelector('.preloader').style.opacity = '1';
    document.querySelector('.preloader').style.display = 'block';

    const form = document.getElementById('apiTestForm');
    const formData = new FormData(form);

    // Get the API key and secret from the form
    const apiKey = formData.get('apiKey');
    const secretKey = formData.get('secretKey');

    // Remove API key and secret from the form data
    formData.delete('apiKey');
    formData.delete('secretKey');

    fetch("{{ env('APP_URL') }}/api/image-enlarger", {
        method: 'POST',
        body: formData,
        headers: {
            'X-Neurnous-Api-Key': apiKey,
            'X-Neurnous-Secret-Key': secretKey
        },
    })
    .then(response => response.json())
    .then(data => {
        // Update the response content
        const responsePre = document.getElementById('response');
        responsePre.innerHTML = JSON.stringify(data, null, 2);

        // Hide the preloader after the fetch operation is complete
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    })
    .catch(error => {
        // Handle errors and hide the preloader
        console.error('Error:', error);
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    });
}
function updateCode() {
    const selectedLanguage = document.getElementById('languageSelect').value;
    const codeContainer = document.getElementById('codeContainer');
    // Get selected values for noise, scale, and format
    const noise = document.getElementById('noise').value;
    const scale = document.getElementById('scale').value;
    const format = document.getElementById('format').value;
    const apiKey = document.getElementById('apiKey').value;
    const secretKey = document.getElementById('secretKey').value;
    let codeSnippet = '';
    switch (selectedLanguage) {
        case 'js':
            codeSnippet = `<code class="language-javascript">// Using Fetch API in JavaScript code remains the same
const apiKey =  '${apiKey}';
const secretKey =  '${secretKey}';
const noise = ${noise};
const scale =${scale};
const format = '${format}';

const formData = new FormData();
formData.append('image', document.getElementById('image').files[0]);

fetch(${path}, {
    method: 'POST',
    body: formData,
    headers: {
        'X-Neurnous-Api-Key': apiKey,
        'X-Neurnous-Secret-Key': secretKey,
    },
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
</code>`;
            break;

        case 'ajax':
            codeSnippet = `<code class="language-javascript">
// Using Ajax with jQuery code remains the same
const apiKey =  '${apiKey}';
const secretKey =  '${secretKey}';
const noise = ${noise};
const scale =${scale};
const format = '${format}';

const formData = new FormData();
formData.append('image', $('#image')[0].files[0]);

$.ajax({
    url: ${path},
    type: 'POST',
    headers: {
        'X-Neurnous-Api-Key': apiKey,
        'X-Neurnous-Secret-Key': secretKey,
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        console.log(response);
    },
    error: function(error) {
        console.error('Error:', error);
    }
});
</code>`;
            break;
        default:
            break;
    }

    // Update the code snippet in the container
    codeContainer.innerHTML = `<pre style="white-space: pre-wrap;">${codeSnippet}</pre>`;
    // Prism.highlightAll();
    hljs.highlightAll();
}

    function copyCode() {
        const codeContainer = document.getElementById('codeContainer');
        const range = document.createRange();
        range.selectNode(codeContainer);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();

        // Alert or display a message on successful copy
        toastr.success('Code copied to clipboard!');
    }
    $(document).ready(function() {
        updateCode(); 
    });
</script>

@endsection
