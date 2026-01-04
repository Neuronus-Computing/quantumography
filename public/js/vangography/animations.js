const indexElement = document.getElementById("index");
const encodeElement = document.getElementById("encode");
const decodeElement = document.getElementById("decode");
const bottomClss = document.getElementById("bottom-clss");
const statCls = document.getElementById("encrypt-stat-cls");
const plansElement = document.getElementById("plans");
const blueCircle = document.querySelector("#encode #round-icon .blue-circle");
const halfBlueCircle = document.querySelector(
  "#encode #round-icon .half-blue-circle"
);
const secretUploadButtons = document.getElementById("secret-uploaded-buttons");
const fileEncryptingStat = document.querySelector(
  "#encrypt-stat-cls .file-encryption"
);
const addPasskeyElement = document.getElementById("passkey");
const addPasskeyDecodeElement = document.getElementById("decode-passkey");
const fileEncodeEffectedElements = document.querySelectorAll(
  "#index, #encode, #encrypt-stat-cls, .quantum-bg-section .logo-quantum, #bottom-clss, #decode"
);
const fileDecodeEffectedElements = document.querySelectorAll(
  "#index, #encode, #upgrade,#encrypt-stat-cls, .quantum-bg-section .logo-quantum, #decode-bottom-clss, #decode"
);

const encodeFile = () => {
  fileEncodeEffectedElements.forEach((element) =>
    element.classList.add("encode-file-clicked")
  );
};

const handleBottomCls = (section = "encode") => {
  if (section === "encode") {
    bottomClss.classList.toggle("arrow-clicked");
  } else {
    document
      .getElementById("decode-bottom-clss")
      .classList.toggle("arrow-clicked");
  }
};

const handleSecretUpload = () => {
  encodeElement.classList.add("upload-secret-clicked");
  encodeElement.classList.remove("cover-file-uploading");
  setTimeout(() => {
    document.getElementById("cover-uploaded-buttons").style.display = "none";
  }, 1000);
};

const handleReUploadCover = () => {
  encodeElement.classList.add("reupload-cover-clicked");
  encodeElement.classList.remove("cover-file-uploading");
  setTimeout(() => {
    encodeElement.classList.remove("cover-file-uploaded");
  }, 2000);
};

const handleReUploadSecret = () => {
  bottomClss.classList.add("reupload-secret-clicked");
  bottomClss.classList.remove("file-limit-exceeded");
  encodeElement.classList.add("reupload-secret-clicked");
  encodeElement.classList.remove(
    "secret-file-uploading",
    "secret-file-uploaded",
    "reupload-cover-clicked",
    "file-limit-exceeded"
  );
  setTimeout(() => {
    document
      .querySelectorAll("#encode #center-circle .basic-stroke")
      .forEach((element) => (element.style.display = "block"));
    document
      .querySelectorAll("#encode #center-circle .payment-stroke")
      .forEach((element) => (element.style.display = "none"));
  }, 2000);
};

const handleIncreaseLimit = () => {
  plansElement.classList.remove("revert-increase-limit");
  plansElement.classList.add("increase-limit-clicked");
};

const handleRevertIncreseLimit = () => {
  plansElement.classList.add("revert-increase-limit");
  setTimeout(() => {
    plansElement.classList.remove("increase-limit-clicked");
  }, 1000);
};

const handleStartEncryption = () => {
  encodeElement.classList.add("start-encryption-clicked");
  statCls.classList.add("start-encryption-clicked");
  setTimeout(() => {
    encodeElement.classList.add("encryption-completed");
    setTimeout(() => {
      secretUploadButtons.style.display = "none";
      fileEncryptingStat.style.display = "none";
    }, 1000);
    setTimeout(() => {
      encodeElement.classList.add("animate-at-encryption-completed");
      setTimeout(() => {
        blueCircle.style.display = "none";
        halfBlueCircle.style.display = "block";
      }, 3000);
    }, 3000);
  }, 2500);
};

const handleAddPasskey = (section = "encode") => {
  if (section === "encode") {
    addPasskeyElement.classList.add("add-passkey-clicked");
    encodeElement.classList.add("add-passkey-clicked");
  } else {
    addPasskeyDecodeElement.classList.add("add-passkey-clicked");
    decodeElement.classList.add("add-passkey-clicked");
  }
};

const decodeFile = () => {
  fileDecodeEffectedElements.forEach((element) =>
    element.classList.add("decode-file-clicked")
  );
};

const handleGotoDecode = () => {
  window.location.reload();
  // encodeElement.classList.add("goto-decode-clicked");
  // indexElement.classList.add("goto-decode-clicked");
  // statCls.classList.add("goto-decode-clicked");
  // setTimeout(() => {
  //   encodeElement.className = "";
  //   indexElement.className = "";
  //   statCls.className = "";
  //   decodeElement.className = "";
  //   setTimeout(() => {
  //     statCls.classList.add("encrypt-stat-cls");
  //     indexElement.classList.add("container", "content");
  //   }, 100);
  // }, 1000);
};
