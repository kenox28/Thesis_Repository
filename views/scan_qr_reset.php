<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scan QR to Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fa; }
        .scanner-container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 16px #1976a522; padding: 32px 24px; text-align: center; }
        #reader { width: 100%; min-height: 300px; margin: 0 auto 18px auto; }
        .msg { color: #e74c3c; margin-bottom: 12px; }
        .success { color: #1976a5; }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #1976a5;
            text-decoration: none;
        }
    </style>
    <!-- Include html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <header>
        <a href="student_login.php" class="back-button">Back</a>
    </header>
    <div class="scanner-container">
        <h2>Scan QR Code to Reset Password</h2>
        <div id="reader"></div>
        <div id="scanMsg" class="msg"></div>
    </div>
    <script>
    // Helper: extract student_id from URL or plain value
    function extractStudentId(qrText) {
        // If QR is a URL like .../reset_password.php?id=STUDENT_ID
        const match = qrText.match(/[?&]id=([a-zA-Z0-9_-]+)/);
        if (match) return match[1];
        // If QR is just the student_id
        if (/^[a-zA-Z0-9_-]+$/.test(qrText)) return qrText;
        return null;
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        html5QrcodeScanner.clear();
        document.getElementById('scanMsg').innerHTML = "Checking student ID...";
        const student_id = extractStudentId(decodedText);
        if (!student_id) {
            document.getElementById('scanMsg').innerHTML = "Invalid QR code.";
            return;
        }
        // Check with backend if student_id exists
        fetch('../php/check_student_id.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ student_id })
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                document.getElementById('scanMsg').innerHTML = "<span class='success'>Student found! Redirecting...</span>";
                setTimeout(() => {
                    window.location.href = `reset_password.php?id=${student_id}`;
                }, 1200);
            } else {
                document.getElementById('scanMsg').innerHTML = result.message || "Student not found.";
            }
        })
        .catch(() => {
            document.getElementById('scanMsg').innerHTML = "Error checking student ID.";
        });
    }

    // Start the scanner
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
