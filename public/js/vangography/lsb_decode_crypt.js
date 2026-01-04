var Gallery = new Vue({
    el: '#LSBDecode',
    data: {
        loading: false,
        pictures: {
            original: ""
        },
        methods: [],
        analyseUrl: "",
        errors: [],
        text: "",
        password: "",
        seconds: 0,
        passwordError:'',
        step: 'encrypted-file',
        decodeText:'After successful decoding , download button to download your secret file will be shown here.',
    },
    mounted: function () {
        this.analyseUrl = analyseUrlDecode;
    },
    watch:{
        step: function(newstep){
             if(newstep == 'encrypted-file'){
                $('#status').html(`<p class="mb-2">Waiting for the encrypted file upload.</p>`);
            }
            else if(newstep == 'setPassword'){
                $('#status').html('<p class="mb-2">Add passkey for decryption.</p>');
            }
            else if(newstep == 'password'){
                $('#status').html('<p class="mb-2">Add passkey as additional security for decryption.</p>');
            }
            else if(newstep == 'encrypted-file-uploaded'){
                $('#status').html('<p class="mb-2">Encrypted file uploaded.</p>');
            }
            else if(newstep == 'download'){
                $('#status').html('<p class="mb-2">Download you secret file.</p>');
            }
            else if(newstep == 'decrypting'){
                $('#status').html('<p class="mb-2">Decrypting your file.</p>');
            }
        },
        password: function(newVal) {
            // Check if password is 6 digits
            if (newVal.length === 6 && /^\d+$/.test(newVal)) {
                // Password is 6 digits
                this.passwordError='';
            } else {
                // Password is not 6 digits
                this.passwordError='Password must be 6 digits';
            }
        },
    },
    methods: {
        passwordValidLength() {
            const password = this.password;    
            // Check if the length of password is exactly 6 digits
            const validLength = password.length === 6;
    
            // Return true if both conditions are met, false otherwise
            return validLength;
        },
        resetDecoder: function () {
            this. pictures = {
                original: ""
            };
            this.text= "";
            this.password= "";
            this.seconds= 0;
        },
        onImageChange: function (event, ip) {
            var files = event.target.files || event.dataTransfer.files;
            if (!files.length)
                return;

            var fileTypes = ['jpg', 'jpeg', 'png'];
            var extension = files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types

            if (isSuccess) {
                this.readFile(files[0], ip);
                this.step="encrypted-file-uploaded";
            }
            else {
                toastr.error('It is not a picture. Please, use a picture')
            }
            event.preventDefault()
        },
        readFile: function (file, ip) {
            var self = this;
            var reader = new FileReader();
            reader.onloadend = function () {
                self.pictures.containers[ip].base64Picture = reader.result;
            };
            if (file) {
                this.decodeText='Download button to download secret file after decoding will be shown here.';
                reader.readAsDataURL(file);
            }
        },
        onImageChangeOrig: function (event) {
            var files = event.target.files || event.dataTransfer.files;
            if (!files.length)
                return;

            var fileTypes = ["jpg", "jpeg" , "png", "heic"];
            var extension = files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types

            if (isSuccess) {
                this.readFileOrig(files[0]);
                this.step="encrypted-file-uploaded";
            }
            else {
                toastr.error('It is not a valid picture. Please, use a valid encrypted picture with Vangography encoder with jpg, jpeg, png or heic format')
            }
            event.preventDefault();
            event.target.value = null;
        },
        readFileOrig: function (file) {
            var self = this;
            var reader = new FileReader();
            reader.onloadend = function () {
                self.pictures.original = reader.result;
            };
            if (file) {
                reader.readAsDataURL(file);
            }
            // this.$refs.responseDiv.innerHTML= this.decodeText; //
        },
        downloadFile: function (fileUrl,name) {
            // Create an anchor element
            var anchor = document.createElement('a');
            anchor.href = fileUrl;
            anchor.download = name;  // Set a default filename or extract it from the URL
        
            // Append the anchor to the document
            document.body.appendChild(anchor);
        
            // Trigger a click event on the anchor
            anchor.click();
        
            // Remove the anchor from the document
            document.body.removeChild(anchor);
        },
        sendOnSever: function (event) {
            this.step= "decrypting";
            var timerStart = Date.now();
            event.preventDefault()
            var self = this;
            // this.$refs.responseDiv.innerHTML = '';
            if(this.loading == false) {
                this.loading = true;
                this.$http.post(this.analyseUrl,
                    {
                        'pictures': this.pictures,
                        'password': this.password
                    })
                    .then(function(response) {
                        this.seconds = (Date.now()-timerStart)/1000;
                        this.loading = false;
                        if (response.body.text) {
                            // Handle text response
                            self.text = response.body.text;
                            self.$refs.download.innerHTML = response.body.text;
                        }
            
                        if (response.body.file) {
                            // Handle file response
                            self.$refs.download.innerHTML = '';
                            var fileUrl = response.body.file;
                            var fileName = response.body.name;

                            // Create a button element
                            var downloadButton = document.createElement('button');
                            downloadButton.className = 'btn--base mr-2 btn-blue-dark-vanu';
                            downloadButton.textContent = 'Download Secret File';
                            // Attach click event to the button
                            downloadButton.onclick = function() {
                                // Call the downloadFile function with the file URL
                                self.downloadFile(fileUrl,fileName);
                            };
                            // Clear existing content in response div
                            self.text = '';
                            this.$refs.encImg.value = null;
                            // Append the button to the response div
                            self.$refs.download.appendChild(downloadButton);
                        }      
                        toastr.success('File decoded successfully.');
                        self.step = 'download';
                        $('.preloader').css({'opacity': '0','display': 'none'});  
                    }, function (response) {
                        this.$set(this, 'errors', response.body);
                        if (response.body.errors) {
                            for (let field in response.body.errors) {
                                toastr.error(response.body.errors[field].join(', '), 'Validation Error');
                            }
                        } 
                        else if (response.body.error) {
                                toastr.error(response.body.error);
                        } 
                        else{
                            toastr.error('Something went wrong, please try again.');
                        }
                        $('.preloader').css({'opacity': '0','display': 'none'});  
                        this.loading = false;
                        this.step="password";
                    });
            }
        }
    }
})
