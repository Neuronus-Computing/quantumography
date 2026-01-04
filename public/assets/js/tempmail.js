
function getEmailFromServer() {
    return $.ajax({
        url: '/generate-mail', // Replace with the actual route URL
        method: 'GET',
        dataType: 'json'
    }).done(function(response) {
        // Store the response data in local storage
        localStorage.setItem('temp_mail', response.temp_mail);
        localStorage.setItem('encrypted_email', response.encrypted_email);
        console.log('Data stored in local storage:', response);

        // Set the email value in the input field
        $('#mail').val(response.temp_mail);

        // Call the API to fetch mail data
        fetchMailData(response.encrypted_email);
        // Fetch mail data every minute
        // setInterval(function() {
        //     fetchMailData(encryptedEmail);
        // }, 60000); // 60000 milliseconds = 1 minute
    }).fail(function(error) {
        console.log('Error fetching data:', error);
    });
}

function refreshPage() {
    // Reload the current page
    window.location.reload();
}
// Function to call the API and fetch mail data
function fetchMailData(encryptedEmail) {
    var myHeaders = new Headers();
    myHeaders.append("apikey", "{{ env('TEMP_MAIL_API_KEY') }}");

    var requestOptions = {
        method: 'GET',
        headers: myHeaders,
        redirect: 'follow'
    };

    // Fetch the mail data and store it in the 'data' variable
    fetch(`https://api.apilayer.com/temp_mail/mail/id/${encryptedEmail}`, requestOptions)
        .then(response => response.json())
        .then(data => {
            // Populate the inbox table with the data
            populateInboxTable(data);
        })
        .catch(error => console.log('Error fetching mail data:', error));
}

// Function to populate the inbox table with data
function populateInboxTable(data) {
    var inboxTable = $("#inboxData");

    // Clear existing table rows
    inboxTable.empty();

    // Loop through the inbox data and create table rows
    data.forEach(item => {
        debugger;
        console.log(item);
        const [senderName, senderEmail] = item.mail_from.split('<');
        var sender = senderName.trim() + '<br>' + senderEmail.replace('>', '').trim();
        var subject = item.mail_subject;
        var mailId = item.mail_id;
        debugger;
        if (item.mail_attachments.length > 0)
            // Check if the email has attachments and create the icon accordingly
            subject += '  <i class="fas fa-paperclip"></i>';

        // Create a table row with the data
        var row = `
            <tr>
                <td>${sender}</td>
                <td>${subject}</td>
                <td><button class="btn btn-primary" onclick="viewMail('${mailId}')">View</button></td>
            </tr>
        `;
        // Append the row to the inbox table
        inboxTable.append(row);
    });
}

// Function to view the selected mail
function viewMail(mailId) {
    var myHeaders = new Headers();
    myHeaders.append("apikey", "{{ env('TEMP_MAIL_API_KEY') }}");

    var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        headers: myHeaders
    };
    fetch(`https://api.apilayer.com/temp_mail/one_mail/id/${mailId}`, requestOptions)
        .then(response => response.json())
        .then((result) => {
            debugger;
            // Populate the mail details in the view
            $("#mailSubject").html(`Subject: ` + result.mail_subject);
            const [senderName, senderEmail] = result.mail_from.split('<');
            $("#mailFrom").html(`${senderName.trim()}<br>${senderEmail.replace('>', '').trim()}`);
            $("#mailDate").html(`Date:<br>` + new Date(result.mail_timestamp * 1000).toLocaleString());

            $("#mailContent").html(result.mail_html);

            // Check if the mail has attachments
            if (result.mail_attachments_count > 0) {
                // Create and populate the attachments dropdown
                var attachmentsDropdown = $('<select id="attachmentsDropdown"></select>');
                var option = $('<option></option>').val('').text('download');
                attachmentsDropdown.append(option);

                $.each(result.mail_attachments, function(index, attachment) {
                    var option = $('<option></option>').val(attachment._id).text(attachment.filename);
                    attachmentsDropdown.append(option);
                });

                // Add event listener to handle attachment selection and download
                attachmentsDropdown.on('change', function() {
                    var selectedAttachmentId = $(this).val();
                    downloadAttachment(mailId, selectedAttachmentId);
                });

                // Append the dropdown to the mailDetails container
                $("#attachments").append(attachmentsDropdown);
            }

            // Show the detailed mail view
            $("#inboxList").hide();
            $("#mailDetails").show();
        })
        .catch(error => console.log('error', error));

}

function downloadAttachment(mailId, attachmentId) {
    var myHeaders = new Headers();
    myHeaders.append("apikey", "{{ env('TEMP_MAIL_API_KEY') }}");

    var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        headers: myHeaders
    };

    fetch(`https://api.apilayer.com/temp_mail/one_attachment/id/${mailId}/${attachmentId}`, requestOptions)
        .then(response => response.json())
        .then(data => {
            const content = data.content;
            const contentType = data.contentType;
            const name = data.name;

            // Convert base64 content to a Uint8Array
            const decodedContent = Uint8Array.from(atob(content), c => c.charCodeAt(0));

            // Create a Blob from the Uint8Array
            const blob = new Blob([decodedContent], {
                type: contentType
            });

            // Create a temporary URL for the blob
            const url = URL.createObjectURL(blob);

            // Create a temporary anchor element to trigger the download
            const a = document.createElement('a');
            a.href = url;
            a.download = name; // Set the desired filename for the downloaded PDF file
            a.click();

            // Release the object URL after the download
            URL.revokeObjectURL(url);
        })
        .catch(error => console.log('error', error));
}

function deleteMail() {
    var myHeaders = new Headers();
    myHeaders.append("apikey", "{{ env('TEMP_MAIL_API_KEY') }}");

    var requestOptions = {
        method: 'GET',
        redirect: 'follow',
        headers: myHeaders
    };

    fetch(`https://api.apilayer.com/temp_mail/delete/id/${localStorage.getItem('encrypted_email')}`, requestOptions)
        .then(response => response.text())
        .then((result) => {
            localStorage.removeItem('temp_mail');
            localStorage.removeItem('encrypted_email');
            getEmailFromServer();
            console.log(result)
        })
        .catch(error => console.log('error', error));
}
// Function to go back to the inbox list view
function backToList() {
    // Show the inbox list view
    $("#inboxList").show();
    $("#mailDetails").hide();
}
// Function to copy email to clipboard
function copyEmailToClipboard() {
    const emailField = document.getElementById("mail");
    const textToCopy = emailField.value;

    // Create a temporary input field to copy the text
    const tempInput = document.createElement("input");
    tempInput.value = textToCopy;
    document.body.appendChild(tempInput);

    // Select the text inside the temporary input field
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile devices

    // Copy the selected text to the clipboard
    document.execCommand("copy");

    // Remove the temporary input field from the DOM
    document.body.removeChild(tempInput);

    // Show a tooltip or a message indicating that the email has been copied
    toastr.success("Email copied to clipboard: " + textToCopy);
}
$(document).ready(function() {
    if (!localStorage.getItem('temp_mail') && !localStorage.getItem('encrypted_email')) {
        getEmailFromServer();
    } else {
        $('#mail').val(localStorage.getItem('temp_mail'));
        // Call the API to fetch mail data using the email from local storage
        fetchMailData(localStorage.getItem('encrypted_email'));
        // Fetch mail data every minute
        // setInterval(function() {
        //     fetchMailData(localStorage.getItem('encrypted_email'));
        // }, 60000); // 60000 milliseconds = 1 minute
    }
});