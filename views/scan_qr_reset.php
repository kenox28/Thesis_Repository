<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR to Reset Password</title>
    <link rel="stylesheet" href="assets/css/Login_Form.css">
    <style>
        :root {
            --light-gray: #cadcfc;
            --off-white: #cadcfc;
            --primary: #00246b;
            --primary-light: #1a3a8f;
            --text-dark: #00246b;
            --shadow: rgba(0, 36, 107, 0.1);
        }
        body {
            min-height: 100vh;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .qr-scan-card {
            background: var(--primary);
            border-radius: 18px;
            box-shadow: 0 8px 32px var(--shadow);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 370px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .qr-scan-card h2 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        .qr-scan-card p {
            color: #e0e7ef;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        #reader {
            width: 100%;
            max-width: 350px;
            min-height: 350px;
            border-radius: 10px;
            border: 2px solid var(--primary-light);
            background: var(--off-white);
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 12px var(--shadow);
        }
        #scanMsg {
            min-height: 32px;
            margin-bottom: 1.2rem;
            text-align: center;
            font-size: 1rem;
            color: #fff;
            font-weight: 500;
        }
        .back-link {
            display: inline-block;
            margin-top: 0.5rem;
            color: var(--light-gray);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #fff;
            text-decoration: underline;
        }
        .qr-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 0.7rem;
            opacity: 0.92;
            filter: brightness(0) invert(1);
        }
        @media (max-width: 500px) {
            .qr-scan-card {
                padding: 1.2rem 0.5rem 1rem 0.5rem;
                max-width: 98vw;
            }
            #reader {
                max-width: 95vw;
            }
        }
        #reader__dashboard_section_csr{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
    <!-- Include html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <div class="qr-scan-card">
        <!-- <img src="assets/icons/qr-code-scan.svg" alt="QR Icon" class="qr-icon" /> -->
        <h2>Reset Password</h2>
        <p>Scan your QR code below to securely reset your password.</p>
        <div id="reader"></div>
        <div id="scanMsg"></div>
        <a href="student_login.php" class="back-link">&larr; Back to Login</a>
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
                document.getElementById('scanMsg').innerHTML = "<span style='color:var(--light-gray);font-weight:600;'>Student found! Redirecting...</span>";
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
        "reader", { fps: 10, qrbox: 200 });
    html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
