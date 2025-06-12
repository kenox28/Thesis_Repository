<?php
// Check if viewing as super admin
$isAdminView = isset($_SESSION['super_admin_id']) && isset($_SESSION['super_admin_student_view']);

if ($isAdminView): ?>
<style>
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes slideIn {
        from { transform: translateY(-100%); }
        to { transform: translateY(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .admin-view-banner {
        background: linear-gradient(-45deg, #1976a5, #2893c7, #1565C0, #0D47A1);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite, slideIn 0.5s ease-out;
        color: white;
        padding: 12px 24px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .admin-view-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    .admin-view-banner span {
        font-size: 1.1rem;
        font-weight: 500;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-view-banner span::before {
        content: '👁️';
        font-size: 1.2rem;
    }

    .admin-view-banner button {
        background: rgba(255, 255, 255, 0.95);
        color: #1976a5;
        border: none;
        padding: 8px 20px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .admin-view-banner button::after {
        content: '→';
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .admin-view-banner button:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .admin-view-banner button:hover::after {
        transform: translateX(4px);
    }

    .main-nav {
        margin-top: 60px !important;
        background: linear-gradient(to right, #1976a5, #2893c7) !important;
        padding: 12px 24px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    .nav-links {
        display: flex !important;
        gap: 8px !important;
        align-items: center !important;
    }

    .nav-links a {
        color: white !important;
        text-decoration: none !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .nav-links a::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(255,255,255,0.1) !important;
        transform: translateX(-100%) !important;
        transition: transform 0.3s ease !important;
    }

    .nav-links a:hover::before {
        transform: translateX(0) !important;
    }

    .nav-links a.active {
        background: rgba(255,255,255,0.2) !important;
        font-weight: 600 !important;
    }

    .nav-avatar {
        background: rgba(255,255,255,0.15) !important;
        padding: 6px 16px !important;
        border-radius: 50px !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        transition: all 0.3s ease !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
    }

    .nav-avatar:hover {
        background: rgba(255,255,255,0.25) !important;
        transform: translateY(-1px) !important;
    }

    .avatar-initials {
        background: #1976a5 !important;
        color: white !important;
        width: 36px !important;
        height: 36px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: bold !important;
        font-size: 1.1rem !important;
        border: 2px solid rgba(255,255,255,0.8) !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
    }

    .nav-logo img {
        height: 45px !important;
        width: auto !important;
        transition: transform 0.3s ease !important;
    }

    .nav-logo img:hover {
        transform: scale(1.05) !important;
    }

    /* Dropdown enhancements */
    .dropdown-content {
        background: white !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        overflow: hidden !important;
        transition: all 0.3s ease !important;
    }

    .dropdown-content a {
        color: #1976a5 !important;
        padding: 12px 20px !important;
        transition: all 0.3s ease !important;
        position: relative !important;
    }

    .dropdown-content a:hover {
        background: #f0f7ff !important;
        padding-left: 24px !important;
    }

    .dropdown-content a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #1976a5;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .dropdown-content a:hover::before {
        opacity: 1;
    }
</style>
<div class="admin-view-banner">
    <span>You are viewing the student dashboard as a Super Admin</span>
    <button onclick="window.location.href='../super_admin/super_admin_dashboard.php'">
        Return to Admin Dashboard
    </button>
</div>
<?php endif; ?> 