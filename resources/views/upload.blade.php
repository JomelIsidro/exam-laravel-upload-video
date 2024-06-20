<!DOCTYPE html>
<html>
<head>
    <title>Video Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        #uploadContainer {
            width: 500px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #uploadContainer h1 {
            text-align: center;
        }

        #uploadForm {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #uploadForm input[type="file"] {
            margin-top: 10px;
        }

        #uploadForm button[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        #uploadForm button[type="submit"]:hover {
            background-color: #45a049;
        }

        #progressBar {
            width: 100%;
            height: 30px;
            background-color: #f1f1f1;
            margin-top: 10px;
            display: none; /* Initially hide progress bar */
        }

        #progress {
            width: 0%;
            height: 100%;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        #errorMessages, #successMessage {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="uploadContainer">
        <h1>Upload Video</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="file" id="fileInput" required>
            <button type="submit">Upload</button>
        </form>
        <div id="uploadingLabel" style="display: none;">Uploading Video...</div>
        <div id="errorMessages" style="color: red;"></div> 
        <div id="successMessage" style="color: green;"></div> 
        <div id="progressBar">
            <div id="progress">0%</div>
        </div>
    </div>
    <script>
        document.getElementById('uploadForm').onsubmit = async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            // Check file type
            if (file.type.startsWith('video/')) {
                // Hide error message for video file
                document.getElementById('errorMessages').textContent = '';

                // Show uploading label
                const uploadingLabel = document.getElementById('uploadingLabel');
                uploadingLabel.style.display = 'block';

                // Show progress bar
                const progressBar = document.getElementById('progressBar');
                progressBar.style.display = 'block';

                // Create XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Set up event listeners for monitoring progress
                xhr.upload.addEventListener('progress', function(e) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('progress').style.width = percent + '%';
                    document.getElementById('progress').textContent = percent + '%';
                });

                // Set up event listener to handle completion of upload
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const responseData = JSON.parse(xhr.responseText);
                        document.getElementById('errorMessages').textContent = ''; // Clear error messages
                        document.getElementById('successMessage').textContent = responseData.message; // Display success message
                        uploadingLabel.style.display = 'none'; // Hide uploading label
                    } else {
                        document.getElementById('errorMessages').textContent = 'An error occurred during upload.';
                        document.getElementById('successMessage').textContent = ''; // Clear success message
                    }
                    progressBar.style.display = 'none'; // Hide progress bar
                };

                // Set up event listener to handle network errors
                xhr.onerror = function() {
                    console.error('Network error during upload.');
                    document.getElementById('errorMessages').textContent = 'Network error during upload.';
                    document.getElementById('successMessage').textContent = ''; // Clear success message
                    uploadingLabel.style.display = 'none'; // Hide uploading label
                    progressBar.style.display = 'none'; // Hide progress bar
                };

                // Open and send XMLHttpRequest
                xhr.open('POST', '/upload');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.send(formData);
            } else {
                // Display error message for non-video file
                document.getElementById('errorMessages').textContent = 'Please upload a video file.';
                document.getElementById('successMessage').textContent = ''; // Clear success message
            }
        }
    </script>
</body>
</html>
