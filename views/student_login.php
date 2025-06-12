<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student Login - Thesis Repository System">
    <meta name="theme-color" content="#174D38">
    <title>Login - Thesis Repository</title>
    <!-- <link rel="stylesheet" href="../assets/css/Landing_Page.css"> -->
    <link rel="stylesheet" href="../assets/css/Login_Form.css?v=1.0.1">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico">
    <style>
    /* Modal Overlay */
    .modal-fp {
      display: none; 
      position: fixed; 
      z-index: 9999; 
      left: 0; top: 0; width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.45);
      align-items: center; justify-content: center;
      transition: background 0.2s;
    }

    /* Modal Content */
    .modal-fp-content {
      background: #fff;
      padding: 2.2rem 1.5rem 1.5rem 1.5rem;
      border-radius: 12px;
      max-width: 350px;
      width: 92vw;
      box-shadow: 0 8px 32px rgba(25, 118, 165, 0.18);
      position: relative;
      animation: modalFadeIn 0.25s;
    }
    @keyframes modalFadeIn {
      from { transform: translateY(40px) scale(0.98); opacity: 0; }
      to   { transform: translateY(0) scale(1); opacity: 1; }
    }
    .modal-fp-close {
      position: absolute; top: 12px; right: 18px;
      font-size: 1.6rem; color: #1976a5; cursor: pointer;
      font-weight: bold; transition: color 0.2s;
    }
    .modal-fp-close:hover { color: #e74c3c; }
    .modal-fp-content h2 {
      margin: 0 0 18px 0; color: #1976a5; font-size: 1.4rem; font-weight: 700;
      text-align: center;
    }
    .modal-fp-label {
      display: block; margin-bottom: 8px; color: #333; font-weight: 500;
    }
    .modal-fp-input {
      width: 90%; padding: 10px 12px; border: 1.5px solid #1976a5;
      border-radius: 6px; margin-bottom: 18px; font-size: 1rem;
      transition: border 0.2s;
    }
    .modal-fp-input:focus { border-color: #174D38; outline: none; }
    .modal-fp-btn {
      width: 100%; background: #1976a5; color: #fff; padding: 10px 0;
      border: none; border-radius: 6px; font-weight: 600; font-size: 1rem;
      cursor: pointer; transition: background 0.2s;
    }
    .modal-fp-btn:hover { background: #174D38; }
    .modal-fp-msg {
      margin-top: 16px; text-align: center; font-size: 1rem;
      min-height: 24px;
    }
    @media (max-width: 500px) {
      .modal-fp-content { padding: 1.2rem 0.5rem 1rem 0.5rem; }
    }
    /* Style for Forgot Password Form */
    #forgotPassForm {
      display: flex;
      flex-direction: column;
      width: 100%;
      padding: 0;
      margin: 0;
    }
    
    #forgotPassForm .modal-fp-label {
      margin-bottom: 0.25rem;
    }
    #forgotPassForm .modal-fp-input {
    }
    #forgotPassForm .modal-fp-btn {
    }
    #forgotPassForm #forgotPassMsg {
    }
    </style>
</head>
<body>
    <!-- <header>
        <a href="landingpage.php" aria-label="Return to Home">
            <img src="../assets/icons/home.png" alt="Home Icon">
        </a>
    </header> -->

    <main id="main">
        <form action="#" id="loginForm" method="POST" autocomplete="off">
            <div class="form-group">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email"
                    required
                    autocomplete="email"
                    aria-label="Email address"
                >
            </div>
            <div class="form-group">
                <input 
                    type="password" 
                    name="passw" 
                    placeholder="Password"
                    required
                    autocomplete="current-password"
                    aria-label="Password"
                >
            </div>
            <div class="form-options">
                
            </div>
            <button type="submit">Login</button>
            <div class="form-footer">
                <p>Don't have an account? <a href="Create_form.php">Create Account</a></p>
                <a href="forgot_password.php" class="forgot-password">Forgot Password</a></p>

            </div>
            <a href="landingpage.php">Back to home</a>
        </form>
    </main>
    <script src="../js/login.js?v=1.0.5"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    

    <!-- Forgot Password Modal -->
    <div id="forgotPassModal" class="modal-fp">
      <div class="modal-fp-content">
        <span id="closeForgotModal" class="modal-fp-close">&times;</span>
        <h2>Forgot Password</h2>
        <form id="forgotPassForm" autocomplete="off">
          <label for="forgotEmail" class="modal-fp-label">Enter your email address:</label>
          <input type="email" id="forgotEmail" name="forgotEmail" required class="modal-fp-input" placeholder="you@email.com">
          <button type="submit" class="modal-fp-btn">Send QR Code</button>
        </form>
        <div id="forgotPassMsg" class="modal-fp-msg"></div>
      </div>
    </div>

    <!-- Forced Password Change Modal -->
    <style>
    #forceResetModal {
      display: none;
      position: fixed;
      z-index: 99999;
      left: 0; top: 0; width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.45);
      align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    #forceResetModal .force-reset-content {
      background: #fff;
      max-width: 400px;
      width: 92vw;
      padding: 36px 28px 28px 28px;
      border-radius: 16px;
      box-shadow: 0 2px 24px #1976a522;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    #forceResetModal h2 {
      color: #1976a5;
      text-align: center;
      margin-bottom: 10px;
      font-size: 1.6rem;
      font-weight: 700;
    }
    #forceResetModal .force-reset-reminder {
      color: #e67e22;
      text-align: center;
      margin-bottom: 18px;
      font-weight: 600;
      font-size: 1.08rem;
    }
    #forceResetForm input {
      width: 100%;
      padding: 12px;
      margin: 10px 0 18px 0;
      border-radius: 6px;
      border: 1.5px solid #1976a5;
      font-size: 1rem;
    }
    #forceResetForm button {
      width: 100%;
      background: #1976a5;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 1.08rem;
      margin-top: 6px;
      transition: background 0.2s;
    }
    #forceResetForm button:hover {
      background: #12507b;
    }
    #forceResetMsg {
      text-align: center;
      margin-top: 12px;
      color: #e74c3c;
      min-height: 24px;
    }
    #forceResetClose {
      display: none;
      margin-top: 18px;
      width: 100%;
      background: #888;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 1.08rem;
    }
    @media (max-width: 600px) {
      #forceResetModal .force-reset-content {
        padding: 18px 6vw 18px 6vw;
        max-width: 98vw;
      }
    }
    </style>
    <div id="forceResetModal">
      <div class="force-reset-content">
        <h2>Change Your Password</h2>
        <div class="force-reset-reminder">For your security, you must change your password before using the system.</div>
        <form id="forceResetForm">
          <input type="password" name="password" placeholder="New Password" required minlength="8">
          <input type="password" name="confirm" placeholder="Confirm Password" required minlength="8">
          <button type="submit">Change Password</button>
        </form>
        <div id="forceResetMsg"></div>
        <button id="forceResetClose">Close</button>
      </div>
    </div>
</body>
<script>
    document.querySelector('.forgot-password').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('forgotPassModal').style.display = 'flex';
    });
    document.getElementById('closeForgotModal').onclick = function() {
        document.getElementById('forgotPassModal').style.display = 'none';
    };
    window.onclick = function(event) {
        if (event.target === document.getElementById('forgotPassModal')) {
            document.getElementById('forgotPassModal').style.display = 'none';
        }
    };

    document.getElementById('forgotPassForm').onsubmit = async function(e) {
        e.preventDefault();
        const email = document.getElementById('forgotEmail').value;
        // 1. Check if email exists and get student_id
        const res = await fetch('../php/check_email.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email })
        });
        const result = await res.json();
        if(result.status !== 'success') {
            document.getElementById('forgotPassMsg').innerHTML = result.message;
            return;
        }
        const student_id = result.student_id;
        // 2. Generate QR code with student_id
        const resetUrl = `${window.location.origin}/reset_password.php?id=${student_id}`;
        const qrDataUrl = await QRCode.toDataURL(resetUrl);
        // 3. Send QR code to email
        const res2 = await fetch('../php/send_forgotpass_qr.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email, qrDataUrl })
        });
        const result2 = await res2.json();
        if(result2.status === 'success') {
            // document.getElementById('forgotPassMsg').innerHTML = "A QR code has been sent to your email!";
            window.location.href = 'scan_qr_reset.php';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: result2.message || "Failed to send email.",
                confirmButtonColor: '#174D38'
            });
        }
    };
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</html>