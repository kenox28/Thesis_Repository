<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Repository and Peer Review</title>
    <link rel="stylesheet" href="../assets/css/Landing_Page.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <a href="#" class="logo">Thesis Repository</a>
            <div class="search-container">
                <input type="text" class="search-field" placeholder="Search thesis repositories...">
                <span class="search-icon">🔍</span>
            </div>
            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#about">About</a>
                <a href="#features">Features</a>
                <a href="#contact">Contact</a>
                <div class="auth-buttons">
                   <button id="login" class="login-btn" onclick="login()">Login</button>
                   <button id="signup" class="signup-btn" onclick="signup()">Sign Up</button>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Thesis Repository and Peer Review</h1>
            <p>Discover, share, and review academic research in one centralized platform. Join our community of researchers and scholars.</p>
            <a href="#features" class="cta-button">Explore Features</a>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-content">
            <h2>About Thesis Repository</h2>
            <div class="about-grid">
                <div class="about-card">
                    <h3>Our Mission</h3>
                    <p>To provide a comprehensive platform that facilitates the sharing, review, and advancement of academic research while maintaining the highest standards of quality and integrity.</p>
                </div>
                <div class="about-card">
                    <h3>What We Do</h3>
                    <p>We connect researchers, students, and academic institutions through a secure and efficient platform for thesis submission, peer review, and knowledge sharing.</p>
                </div>
                <div class="about-card">
                    <h3>Our Impact</h3>
                    <p>Supporting academic excellence by providing tools and resources that enhance research quality and foster collaboration within the academic community.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="features-grid">
            <div class="feature-card">
                <h3>Easy Submission</h3>
                <p>Submit your thesis with our streamlined process. Upload, format, and publish your research in minutes.</p>
            </div>
            <div class="feature-card">
                <h3>Peer Review</h3>
                <p>Get valuable feedback from experts in your field through our comprehensive peer review system.</p>
            </div>
            <div class="feature-card">
                <h3>Research Discovery</h3>
                <p>Access thousands of theses and research papers from various disciplines in one place.</p>
            </div>
        </div>
    </section>
</body>
<script>

    function login(){
        window.location.href = "student_login.php";
    }

    function signup(){
        window.location.href = "Create_form.php";
    }
</script>
</html> 