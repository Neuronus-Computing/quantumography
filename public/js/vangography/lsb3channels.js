var Gallery = new Vue({
  el: "#LSBEncode",
  data: {
    loading: false,
    pictures: {
      original: "",
      containers: [],
    },
    picture: {
      base64Picture: "",
      bytes: null,
    },
    decodePictures: {
      original: "",
    },
    analyseUrlDecode: "",
    text: "",
    password: "",
    seconds: 0,
    passwordError: "",

    methods: [],
    analyseUrl: "",
    errors: [],
    text: "",
    password: "",
    confirmPassword: "",
    offset: 100,
    maxlength: 0,
    lengthText: 0,
    seconds: 0,
    coverFileSize: 0,
    secretFile: null,
    secretFileName: "",
    secretFileSize: 0,
    coverFileUrl: "",
    secretFileUrl: "",
    maxFileSize: 20 * 1024 * 1024, // 20MB in bytes
    spacePercentage: 30, // Default space allocation percentage
    spaceForHiding: 0,
    filePara: "Your encrypted file will be shown here.",
    step: "plans",
    status: "testing",
    plan: { price: 10, size: 2 },
    payment: 0,
    stripe: null,
    cardNumber: null,
    cardExpiry: null,
    cardCvc: null,
    paymentError: false,
    paymentSuccess: false,
    name: "",
    email: "",
    paid: 1,
    confirmPasswordError: "",
    passwordError: "",
    planMb: 2,
    section: "index",
    imageUrl: "",
    checkPassword: false,
    decodeFileURL: "",
    decodeFileName: "",
    encFileName:'',
  },
  mounted: function () {
    this.analyseUrl = analyseUrlEncode;
    this.analyseUrlDecode = analyseUrlDecode;
    const stripeKey = window.stripeKey;
    this.stripe = Stripe(stripeKey);
    // Create an instance of Elements
    const elements = this.stripe.elements();
    // Create Card Element for card number
    this.cardNumber = elements.create("cardNumber");
    this.cardNumber.mount("#card-number");
    // Create Card Element for expiry
    this.cardExpiry = elements.create("cardExpiry");
    this.cardExpiry.mount("#card-expiry");
    // Create Card Element for CVC
    this.cardCvc = elements.create("cardCvc");
    this.cardCvc.mount("#card-cvc");
  },
  watch: {
    section: function (newSection) {
      if (newSection === "encode") {
        this.step = "cover-file";
      } else if (newSection === "decode") {
        this.step = "encrypted-file";
      }
    },
    step: function (newstep) {
      $("#status-step").text("");
      if (newstep == "plans") {
        $("#status").html(`<p>File is bigger than ${this.planMb}MB.</p>`);
        $("#alert-text").text(`File is bigger than ${this.planMb}MB.`);
      } else if (newstep == "secret-file") {
        this.resetEncodeFormData();
        $("#status").html(
          `<p class="mb-2">Waiting for the secret file upload (max :${this.spaceForHidingDisplay}).</p>`
        );
      } else if (newstep == "setPassword") {
        $("#status").html(
          '<p class="mb-2">Adding passkey as additional security.</p>'
        );
        setTimeout(() => {
          if (this.section == "encode") {
            this.$refs.passkeyIcon.click();
          } else if (this.section == "decode") {
            this.$refs.decodeWithPasskey.click();
          }
        }, 500);
      } else if (newstep == "password") {
        $("#status").html("");
        setTimeout(() => {
          $("#status").html(
            '<p class="mb-2"><span><img src="/assets/images/quantumography/icons/encryption-complete.svg" class="mr-2"/></span>Encryption completed.</p>'
          );
          setTimeout(() => {
            this.step = "setPassword";
          }, 3000);
        }, 4000);
      } else if (newstep == "password-added") {
        $("#status").html(
          '<p class="mb-2"><span><img src="/assets/images/quantumography/icons/passkey-added.svg" class="mr-2"/></span>Passkey added to cover image.</p>'
        );
      } else if (newstep == "no-password") {
        $("#status").html(
          '<p class="mb-2"><span><img src="/assets/images/quantumography/icons/passkey-added.svg" class="mr-2"/></span>Passkey added to cover image.</p>'
        );
      } else if (newstep == "cover-file") {
        $("#status").html(
          '<p class="mb-2">Waiting for the cover photo upload.</p>'
        );
      } else if (newstep == "secret-file") {
        this.resetcoverFileData();
        $("#status").html(
          '<p class="mb-2">Waiting for the secret file upload.</p>'
        );
      } else if (newstep == "payment") {
        $("#status").html(
          `<h6 class="text-white">${this.plan.plan_name}</h6><h4 class="text-white"><span>$</span>${this.plan.price}</h4><p class="mb-2">For ${this.plan.size}Mb secret file size.</p>`
        );
        $("#payment").addClass("payment-plan-selected");
        $("#plans").addClass("payment-plan-selected");
        setTimeout(() => {
          $("#plans").removeClass("increase-limit-clicked");
        }, 1000);
      } else if (newstep == "encrypted-file") {
        $("#status").html(
          `<p class="mb-2">Waiting for the encrypted file upload.</p>`
        );
      } else if (newstep == "download-encrypted") {
        setTimeout(() => {
          $("#encode").addClass("passkey-animation");
          setTimeout(() => {
            $("#encode").addClass("download-file");
            $("#status").html(
              '<p class="mb-2">Encrypted file is ready to download.</p>'
            );
            this.downloadImageEncrypted();
            setTimeout(() => {
              $("#white-box").css("display", "none");
            }, 1500);
          }, 1500);
        }, 2000);
      } else if (newstep == "setPassword") {
        $("#status").html('<p class="mb-2">Add passkey for decryption.</p>');
      } else if (newstep == "password") {
        $("#status").html(
          '<p class="mb-2">Add passkey as additional security for decryption.</p>'
        );
      } else if (newstep == "encrypted-file-uploaded") {
        $("#status").html('<p class="mb-2">Encrypted file uploaded.</p>');
        setTimeout(() => {
          $("#decode").addClass("encrypted-file-uploaded");
          setTimeout(() => {
            $("#decode").addClass("start-decryption-process");
            setTimeout(() => {
              $("#decode").addClass("decryption-animation");
              setTimeout(() => {
                $("#decode").addClass("decryption-animation-completed");
              }, 3000);
            }, 1000);
          }, 1500);
        }, 2000);
      } else if (newstep == "download") {
        setTimeout(() => {
          $("#decode").addClass("passkey-animation");
          setTimeout(() => {
            $("#decode").addClass("download-file");
            $("#status").html('<p class="mb-2">Download your secret file.</p>');
            setTimeout(() => {
              this.downloadFileDecode(decodeFileURL, decodeFileName);
            }, 500);
            setTimeout(() => {
              $("#white-box").css("display", "none");
            }, 1500);
          }, 1500);
        }, 2000);
      } else if (newstep == "decrypting") {
        $("#status").html('<p class="mb-2">Decrypting your file.</p>');
        $("#decode, #decode-passkey").addClass("passkey-added");
      } else if (newstep == "download-decrypted") {
        $("#status").html('<p class="mb-2">Download your secret file.</p>');
      } else if (newstep == "cover-file-uploaded") {
        $("#status").html(`<p class="mb-2">Cover photo uploaded.</p>`);
        setTimeout(() => {
          document
            .querySelectorAll("#encode, #encrypt-stat-cls")
            .forEach((element) => element.classList.add("cover-file-uploaded"));
        }, 2000);
      } else if (newstep == "secret-file-uploaded") {
        if (this.secretFileSize > this.planMb * 1024 * 1024) {
          $("#status-step").text("Secret File Uploaded.");
          $("#status").html(
            `<div class='main-inside' id='uploading-cover'>
              <div class='d-flex align-items-end'>
                  <img src="assets/images/quantumography/icons/warning.svg" alt="warning" style="width: 25px" class="mr-2">
                  <div>
                      <p class='mb-0'>Secret file size is bigger then ${this.planMb}MB.</p>
                  </div>
              </div>
            </div>`
          );
          setTimeout(() => {
            this.fileLimitExceed();
          }, 1500);
        } else {
          $("#status").html(`<p class="mb-2">Secret file uploaded.</p>`);
          setTimeout(() => {
            document
              .getElementById("encode")
              .classList.add("secret-file-uploaded");
          }, 4000);
        }
      }
    },
    text: function (text) {
      this.lengthText = text.length;
    },
    offset: function () {
      if (this.offset > 100 || this.offset < 30) {
        toastr.error("Please enter a size % value between 30 and 100.");
      }
      this.calculateSpaceForHiding();
    },
    password: function (newVal) {
      // Check if password is 6 digits
      if (newVal.length === 6 && /^\d+$/.test(newVal)) {
        // Password is 6 digits
        this.passwordError = "";
      } else {
        // Password is not 6 digits
        this.passwordError = "Password must be 6 digits";
      }
    },
    confirmPassword: function (newVal) {
      // Check if confirm password matches password
      this.checkPasswordMatch();
    },
  },
  computed: {
    passwordMatchAndValidLength() {
      const password = this.password;
      const confirmPassword = this.confirmPassword;

      // Check if both password and confirm password are non-empty and equal
      const passwordsMatch = password !== "" && password === confirmPassword;

      // Check if the length of password is exactly 6 digits
      const validLength = password.length === 6;

      // Return true if both conditions are met, false otherwise
      return passwordsMatch && validLength;
    },
    maxFileSizeDisplay: function () {
      // Convert maxlength to KB or MB
      if (this.maxlength < 1024) {
        return this.maxlength.toFixed(2) + " B";
      } else if (this.maxlength < 1024 * 1024) {
        return (this.maxlength / 1024).toFixed(2) + " KB";
      } else {
        return (this.maxlength / (1024 * 1024)).toFixed(2) + " MB";
      }
    },
    maxsecretFileSize: function () {
      // Convert maxlength to KB or MB
      if (this.secretFileSize > 0) {
        if (this.secretFileSize < 1024) {
          return this.secretFileSize.toFixed(2) + " B";
        } else if (this.secretFileSize < 1024 * 1024) {
          return (this.secretFileSize / 1024).toFixed(2) + " KB";
        } else {
          return (this.secretFileSize / (1024 * 1024)).toFixed(2) + " MB";
        }
      } else {
        let self = this;
        let encoder = new TextEncoder();
        let textBytes = encoder.encode(self.text);
        this.textSize = textBytes.length;
        if (this.textSize < 1024) {
          return this.textSize.toFixed(2) + " B";
        } else if (this.textSize < 1024 * 1024) {
          return (this.textSize / 1024).toFixed(2) + " KB";
        } else {
          return (this.textSize / (1024 * 1024)).toFixed(2) + " MB";
        }
      }
    },
    getFileSize: function () {
      if (this.secretFileSize > 0) {
        if (this.secretFileSize < 1024) {
          return this.secretFileSize.toFixed(2) + " B";
        } else if (this.secretFileSize < 1024 * 1024) {
          return (this.secretFileSize / 1024).toFixed(2) + " KB";
        } else {
          return (this.secretFileSize / (1024 * 1024)).toFixed(2) + " MB";
        }
      }
    },
    spaceForHidingDisplay: function () {
      // Convert spaceForHiding to KB or MB
      if (this.spaceForHiding < 1024) {
        return this.spaceForHiding.toFixed(2) + " B";
      } else if (this.spaceForHiding < 1024 * 1024) {
        return (this.spaceForHiding / 1024).toFixed(2) + " KB";
      } else {
        return (this.spaceForHiding / (1024 * 1024)).toFixed(2) + " MB";
      }
    },
  },
  methods: {
    checkPasswordMatch: function () {
      if (this.password !== this.confirmPassword) {
        this.confirmPasswordError = "Passwords do not match";
      } else {
        this.confirmPasswordError = "";
      }
    },
    coverFileUploading() {
      const coverFileUploadEffectedElements = document.querySelectorAll(
        "#encode, #encrypt-stat-cls"
      );
      coverFileUploadEffectedElements.forEach((element) =>
        element.classList.add("cover-file-uploading")
      );
    },
    secretFileUploading() {
      document.getElementById("encode").classList.add("secret-file-uploading");
    },
    fileLimitExceed() {
      document.querySelectorAll("#encode, #bottom-clss").forEach((element) => {
        element.classList.add("file-limit-exceeded");
      });
      setTimeout(() => {
        document
          .querySelectorAll("#encode #center-circle .basic-stroke")
          .forEach((element) => (element.style.display = "none"));
        document
          .querySelectorAll("#encode #center-circle .payment-stroke")
          .forEach((element) => (element.style.display = "block"));
      }, 1000);
    },
    paymentSuccessful() {
      $("#payment, #encode").addClass("payment-successfull");
      $("#encode, #bottom-clss").removeClass("file-limit-exceeded");
      $("#encode .basic-stroke").css("display", "block");
      $("#encode .payment-stroke").css("display", "none");
    },
    handleEncryptUpload() {
      $("#decode").addClass("encrypt-file-uploading");
    },
    setSection(section, step) {
      this.section = section;
      this.step = step;
    },
    async submitPayment() {
      this.step = "processing-payment";
      // $('#loading').css({'opacity': '1','display': 'block'});
      let self = this;
      const { token, error } = await this.stripe.createToken(this.cardNumber);

      if (error) {
        this.step = "payment";
        // $('#loading').css({'opacity': '0','display': 'none'});
        // Handle error
        toastr.error(error);
        this.paymentError = true;
      } else {
        // Send token to server for payment processing
        this.$http
          .post("/vangonography/process-payment", {
            payment_method: token.id,
            amount: self.plan.price, // Replace with the amount to pay
            name: self.name, // Replace with the user's name
            email: self.email, // Replace with the user's email
          })
          .then((response) => {
            self.paymentSuccessful();
            // Handle response from the backend
            // Update UI based on the response
            self.paid = 1;
            self.planMb = self.plan.size;
            self.step = "secret-file-uploaded";
            self.payment = 0;
            // first we have to show the encryption step then we will move to password
            // self.step = "password";
            // $('#loading').css({'opacity': '0','display': 'none'});
          })
          .catch((error) => {
            this.$set(this, "errors", error.body);
            if (error.body.errors) {
              for (let field in error.body.errors) {
                toastr.error(
                  error.body.errors[field].join(", "),
                  "Validation Error"
                );
              }
            } else if (error.body.error) {
              toastr.error(error.body.error);
            } else {
              toastr.error("Something went wrong, please try again.");
            }
            self.paid = 0;
            self.step = "payment";
            this.paymentError = true;
          });
      }
    },
    setPlan: function (plan) {
      if (plan.size >= (this.secretFileSize / (1024 * 1024)).toFixed(2)) {
        this.plan = plan;
        this.step = "payment";
      } else {
        // $('#status').html(`<p>Please choose plan with allowed size greater or eqaul to ${this.maxsecretFileSize}.</p>`);
        toastr.error(
          `Please choose plan with allowed size greater or eqaul to ${this.maxsecretFileSize}.`
        );
      }
    },
    resetEncodeFormData: function (event) {
      this.secretFile = null;
      this.secretFileName = "";
      this.secretFileUrl = "";
      this.$refs.secretFileInput.value = "";
    },
    resetcoverFileData: function (event) {
      this.coverFileSize = 0;
      this.coverFileUrl = "";
      this.$refs.coverFileInput.value = "";
    },
    copyPicture: function () {
      var copiedPicture = jQuery.extend(true, {}, this.picture);
      this.pictures.containers.push(copiedPicture);
    },
    onImageChangeOrig: function (event) {
      document
        .getElementById("encode")
        .classList.remove("reupload-cover-clicked");
      var files = event.target.files || event.dataTransfer.files;
      if (!files.length) {
        return;
      }
      this.secretFile = null;
      this.pictures = {
        original: "",
        containers: [],
      };
      this.secretFileName = "";
      this.secretFileSize = 0;
      this.password = "";
      this.filePara = "Your encrypted file will be shown here.";
      var fileTypes = ["jpg", "jpeg" , "png", "heic"];
      var file = files[0];

      var extension = file.name.split(".").pop().toLowerCase();
      var isSuccess = fileTypes.indexOf(extension) > -1;

      if (isSuccess && file.size <= this.maxFileSize) {
        this.coverFileSize = file.size;
        this.readFileOrig(file);
        this.calculateSpaceForHiding();
        this.uploadCoverFile(file, "cover");
        this.coverFileUploading();
      } else {
        if (!isSuccess) {
          toastr.error(
            "It is not a valid picture. Please, use a picture in jpg, jpeg, png or heic format."
          );
        } else {
          toastr.error(
            "The file size exceeds then the maximum allowed (20MB). Please choose a smaller file."
          );
        }
      }

      event.preventDefault();
      event.target.value = null;
    },
    // Method to upload the cover file immediately
    uploadCoverFile: function (file, type) {
      this.step = "uploading";
      var self = this;
      var formData = new FormData();
      formData.append("file", file);
      formData.append("type", type);

      // Show the progress modal
      $("#progressModal").modal("show");
      let uploadStart = false;

      axios
        .post("/upload-file", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
          // Event listener to update progress
          onUploadProgress: function (progressEvent) {
            var percentCompleted = Math.round(
              (progressEvent.loaded * 100) / progressEvent.total
            );
            // Call method to update progress in the modal
            self.updateProgress(percentCompleted, type, uploadStart);
            uploadStart = true;
          },
        })
        .then(function (response) {
          // Handle successful upload
          self.handleSuccessfulUpload(response.data);
          if (type === "cover") {
            self.coverFileUrl = response.data.image_url;
            self.step = "cover-file-uploaded";
          }
          if (type === "secret") {
            self.secretFileUrl = response.data.image_url;
            let allowed = self.planMb * 1024 * 1024;
            if (self.secretFileSize > allowed) {
              self.payment = 1;
              self.paid = 0;
              self.step = "secret-file-uploaded";
            } else {
              self.step = "secret-file-uploaded";
              self.payment = 0;
            }
          }
        })
        .catch(function (error) {
          // Handle upload error
          self.handleUploadError(error);
        });
    },
    // Method to update progress in the modal
    updateProgress: function (percentCompleted, type, start = false) {
      if (!start) {
        type = type.charAt(0).toUpperCase() + type.slice(1);
        $("#status").html(
          `<div class='main-inside' id='uploading-cover'>
            <div class='d-flex justify-center items-center'>
                <div class='circle-skeleton mr-2 relative overflow-hidden'>
                    <div class='wave-circle'></div>
                </div>
                <div class='w-100'>
                    <p class='mb-1'>${type} file uploading</p>
                    <div class='progress-bar'>
                      <div class='progress' id="progress-input" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
          </div>`
        );
      }
      $("#progress-input").css("width", `${percentCompleted}%`);
    },
    // Method to handle successful upload
    handleSuccessfulUpload: function (data) {
      // Hide the progress modal
      $("#progressModal").modal("hide");
      // Handle successful upload
      // Example: Show success message
    },
    // Method to handle upload error
    handleUploadError: function (error) {
      // Hide the progress modal
      $("#progressModal").modal("hide");
      // Handle upload error
      // Example: Show error message
    },
    calculateSpaceForHiding: function () {
      if (this.coverFileSize > 0) {
        // Calculate space based on the specified percentage and offset
        // const effectiveOffset = this.offset >= 30 ? this.offset : 30;
        // this.spaceForHiding = Math.round((this.coverFileSize * effectiveOffset / 100) / 3);

        const totalSize = this.coverFileSize; // 100%
        const offset = this.offset >= 30 ? this.offset : 30;

        // Calculate the size after subtracting 40%
        const reducedSize = Math.round(totalSize - totalSize * 0.5);

        // Calculate space for hiding based on the reduced size and offset
        this.spaceForHiding = Math.round((reducedSize * offset) / 100);
      }
    },
    onSecretFileChange: function (event) {
      document
        .querySelectorAll("#encode, #bottom-clss")
        .forEach((element) =>
          element.classList.remove("reupload-secret-clicked")
        );
      var files = event.target.files || event.dataTransfer.files;
      if (files.length <= 0) {
        return;
      } else {
        var sfile = files[0];
        this.pictures.containers = [];
        if (this.coverFileSize <= 0) {
          $("#status").html("<p>Please first select cover image.");
        } else {
          if (sfile.size < this.spaceForHiding) {
            this.secretFile = sfile;
            this.secretFileSize = sfile.size;
            this.secretFileName = sfile.name; // Save secret file name
            this.uploadCoverFile(sfile, "secret");
            this.secretFileUploading();
          } else {
            this.resetEncodeFormData();
            event.target.value = null;
            $("#status").html(
              "<p>Secret file size exceeds the maximum allowed size (" +
                this.spaceForHidingDisplay +
                ").</p>"
            );
          }
        }
      }

      event.preventDefault();
      event.target.value = null;
    },
    downloadImage: function (base64Data, fileName) {
      const link = document.createElement("a");
      link.href = base64Data;
      link.download = fileName;
      link.click();
    },
    downloadImageEncrypted: function () {
      // Create a temporary link element
    
    // Create temporary download link
    const link = document.createElement("a");
    link.href = this.imageUrl;
    link.download = this.encFileName ?? "encoded_image.png"; // Default filename if not provided

    // Append and trigger download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

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
      setTimeout(function () {
        var imgData = self.pictures.original;

        var img = new Image();
        img.src = imgData;
        img.onload = function () {
          self.maxlength = (((img.width * img.height) / 8 - 8) * 3).toFixed();
          $("#textarea").attr("maxlength", self.maxlength);
        };
      }, 100);
    },
    validateInput(event) {
      const keyPressed = parseInt(String.fromCharCode(event.keyCode));

      // Check if the pressed key would result in a value less than min or greater than max
      if (
        this.offset * 10 + keyPressed < 30 * 10 ||
        this.offset * 10 + keyPressed > 100 * 10
      ) {
        event.preventDefault();
        toastr.error("Please enter a value between 30 and 100.");
      } else {
      }
    },
    validateForm: function () {
      let isValid = true;
      // Validate secret file size
      if (this.secretFile && this.secretFileSize > 0) {
        if (this.secretFileSize > this.spaceForHiding) {
          toastr.error(
            "Secret file size exceeds the maximum allowed size (" +
              this.spaceForHidingDisplay +
              ")."
          );
          isValid = false;
          $(".preloader").css({ opacity: "0", display: "none" });
        }
      } else {
        toastr.error("Please select secret file to encrypt.");
        isValid = false;
        $(".preloader").css({ opacity: "0", display: "none" });
      }
      // Validate offset
      if (this.offset < 30 || this.offset > 100) {
        toastr.error("Size % must be between 30 and 100.");
        isValid = false;
        $(".preloader").css({ opacity: "0", display: "none" });
      }

      return isValid;
    },
    triggerSecretFileInput() {
      // Use the $refs to access the input element and trigger the click event
      this.$refs.secretFileInput.click();
    },
    sendOnSever: function (event) {
      this.step = "encrypting";
      $("#status").html(
        '<p class="mb-2"><span><img src="/assets/images/quantumography/icons/passkey-added.svg" class="mr-2"/></span>Passkey added to cover image.</p>'
      );
      $("#encode, #passkey").addClass("passkey-added");
      var timerStart = Date.now();
      event.preventDefault();
      var self = this;
      // Perform client-side validation before sending data to the server
      if (!this.validateForm()) {
        // Display error messages if validation fails
        return;
      }
      if (this.loading == false) {
        let self = this;
        this.loading = true;
        var formData = new FormData();
        formData.append("original", this.coverFileUrl);
        formData.append("containers", JSON.stringify(this.pictures.containers));
        formData.append("text", this.text);
        formData.append("password", this.password);
        formData.append("offset", this.offset);
        let amount = self.plan.price ? self.plan.price : 0;
        formData.append("amount", amount);
        formData.append("is_paid", self.paid);
        if (this.secretFile) {
          formData.append("secret_file", this.secretFileUrl);
        }
        this.$http.post(this.analyseUrl, formData).then(
          function (response) {
            if (response.body.checkout_url) {
              // Redirect the user to the checkout URL
              window.location.href = response.body.checkout_url;
            }
            if (response.body.path) {
              // toastr.error("Please login to download your encrypted file.")
              // Redirect the user to the login
              self.encFileName =  filename = response.body.path.split('/').pop().split('\\').pop();
              self.imageUrl = response.body.path;
              // self.section = "download";
              self.step = "download-encrypted";
            } else if (response.body.url && !response.body.path) {
              // toastr.error("Please login to download your encrypted file.")
              // Redirect the user to the login
              window.location.href = response.body.url;
            } else {
              if (response.body.data) {
                this.copyPicture();
                this.pictures.containers[0].base64Picture = response.body.data;
                this.pictures.containers[0].originalFileName =
                  this.originalFileName; // Save original file name
              }
              this.seconds = (Date.now() - timerStart) / 1000;
              toastr.success("File encoded successfully.");
              this.resetEncodeFormData();
              this.loading = false;
              this.filePara = "";
              // $('#loading').css({'opacity': '0','display': 'none'});
              this.step = "download-encrypted";
            }
          },
          function (response) {
            this.$set(this, "errors", response.body);
            if (response.body.errors) {
              for (let field in response.body.errors) {
                toastr.error(
                  response.body.errors[field].join(", "),
                  "Validation Error"
                );
              }
            }
            if (response.body.error) {
              toastr.error(response.body.error);
            } else {
              toastr.error("Something went wrong, please try again.");
            }
            // $('#loading').css({'opacity': '0','display': 'none'});
            this.loading = false;
            self.step = "password";
          }
        );
      }
    },
    checkStep() {
      if (this.step == "cover-file") {
        this.$refs.coverFileInput.click();
      }
      if (this.step == "secret-file") {
        this.$refs.secretFileInput.click();
      }
      if (this.step == "encrypted-file") {
        this.$refs.encImg.click();
      }
    },
    //decode functions
    passwordValidLength() {
      const password = this.password;
      // Check if the length of password is exactly 6 digits
      const validLength = password.length === 6;

      // Return true if both conditions are met, false otherwise
      return validLength;
    },
    resetDecoderDecode: function () {
      this.decodePictures = {
        original: "",
      };
      this.text = "";
      this.password = "";
      this.seconds = 0;
    },
    onImageChangeDecode: function (event, ip) {
      var files = event.target.files || event.dataTransfer.files;
      if (!files.length) return;

      var fileTypes = ["jpg", "jpeg", "png"];
      var extension = files[0].name.split(".").pop().toLowerCase(), //file extension from input file
        isSuccess = fileTypes.indexOf(extension) > -1; //is extension in acceptable types

      if (isSuccess) {
        this.readFileDecode(files[0], ip);
        this.step = "encrypted-file-uploaded";
      } else {
        toastr.error("It is not a picture. Please, use a picture");
      }
      event.preventDefault();
    },
    readFileDecode: function (file, ip) {
      var self = this;
      var reader = new FileReader();
      reader.onloadend = function () {
        self.decodePictures.containers[ip].base64Picture = reader.result;
      };
      if (file) {
        this.decodeText =
          "Download button to download secret file after decoding will be shown here.";
        reader.readAsDataURL(file);
      }
    },
    onImageChangeOrigDecode: function (event) {
      var files = event.target.files || event.dataTransfer.files;
      if (!files.length) return;

      var fileTypes = ["jpg", "jpeg" , "png", "heic"];
      var extension = files[0].name.split(".").pop().toLowerCase(), //file extension from input file
        isSuccess = fileTypes.indexOf(extension) > -1; //is extension in acceptable types

      if (isSuccess) {
        this.readFileOrigDecode(files[0]);
        this.step = "encrypted-file-uploaded";
        this.handleEncryptUpload();
      } else {
        toastr.error('It is not a valid picture. Please, use a valid encrypted picture with Vangography encoder with jpg, jpeg, png or heic format')
      }
      event.preventDefault();
      event.target.value = null;
    },
    readFileOrigDecode: function (file) {
      var self = this;
      var reader = new FileReader();
      reader.onloadend = function () {
        self.decodePictures.original = reader.result;
        self.checkPassword = true;
        self.sendOnSeverDecode();
      };
      if (file) {
        reader.readAsDataURL(file);
      }
      // this.$refs.responseDiv.innerHTML= this.decodeText; //
    },
    downloadFileDecode: function (fileUrl, name) {
      // Create an anchor element
      var anchor = document.createElement("a");
      anchor.href = fileUrl;
      anchor.download = name; // Set a default filename or extract it from the URL

      // Append the anchor to the document
      document.body.appendChild(anchor);

      // Trigger a click event on the anchor
      anchor.click();

      // Remove the anchor from the document
      document.body.removeChild(anchor);
    },
    sendOnSeverDecode: function (event) {
      var timerStart = Date.now();
      // event.preventDefault();
      var self = this;
      // this.$refs.responseDiv.innerHTML = '';
      if (this.loading == false) {
        this.loading = true;
        let data = {
          pictures: self.decodePictures,
          password: self.password,
        };
        if (self.checkPassword) {
          data.checkPassword = true;
        }
        this.$http.post(self.analyseUrlDecode, data).then(
          function (response) {
            this.seconds = (Date.now() - timerStart) / 1000;
            this.loading = false;
            if (response.body.password) {
              this.step = "setPassword";
              document
                .getElementById("decode-passkey")
                .classList.add("add-passkey-clicked");
            } else {
              if (response.body.text) {
                this.step = "decrypting";
                // Handle text response
                self.text = response.body.text;
                self.$refs.download.innerHTML = response.body.text;
              }

              if (response.body.file) {
                // Handle file response
                this.step = "decrypting";
                self.$refs.download.innerHTML = "";
                var fileUrl = response.body.file;
                var fileName = response.body.name;
                decodeFileURL = response.body.file;
                decodeFileName = response.body.name;

                // create paragraph
                var paragraph = document.createElement("p");
                paragraph.className = "mb-3";
                paragraph.textContent =
                  "Hello there, here is your decrypted file.";

                // Create a button element
                var downloadButton = document.createElement("img");
                downloadButton.src =
                  "/assets/images/quantumography/icons/download-icon.svg";
                downloadButton.alt = "Download Secret File";
                downloadButton.className = "cursor-pointer";
                // Attach click event to the button
                downloadButton.onclick = function () {
                  // Call the downloadFile function with the file URL
                  self.downloadFileDecode(fileUrl, fileName);
                };
                // Clear existing content in response div
                self.text = "";
                this.$refs.encImg.value = null;
                // Append the button to the response div
                self.$refs.download.appendChild(paragraph);
                self.$refs.download.appendChild(downloadButton);
              }
              toastr.success("File decoded successfully.");
              setTimeout(() => {
                self.step = "download";
              }, 1500);
              $(".preloader").css({
                opacity: "0",
                display: "none",
              });
            }
          },
          function (response) {
            this.$set(this, "errors", response.body);
            if (response.body.errors) {
              for (let field in response.body.errors) {
                toastr.error(
                  response.body.errors[field].join(", "),
                  "Validation Error"
                );
              }
            } else if (response.body.error) {
              toastr.error(response.body.error);
            } else {
              toastr.error("Something went wrong, please try again.");
            }
            $(".preloader").css({
              opacity: "0",
              display: "none",
            });
            this.loading = false;
            this.step = "setPassword";
          }
        );
      }
    },
  },
});
