<?php
// Dashboard content only, no HTML/head/body tags
?>
<div class="dashboard-welcome">
    <div>
        <h2>Welcome, <?php echo $_SESSION['fname']; ?>!</h2>
        <p>Here's your reviewer dashboard overview.</p>
    </div>
</div>
<div class="dashboard-cards">
    <div class="dashboard-card">
        <div class="dashboard-card-title"><i class="fas fa-hourglass-half"></i> Pending Reviews</div>
        <div class="dashboard-card-value" id="pendingCount">0</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-card-title"><i class="fas fa-check-circle"></i> Total Approved</div>
        <div class="dashboard-card-value" id="approvedCount">0</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-card-title"><i class="fas fa-file-alt"></i> Public Repo</div>
        <div class="dashboard-card-value" id="publicCount">0</div>
    </div>
    <div class="dashboard-card">
        <div class="dashboard-card-title"><i class="fas fa-times-circle"></i> Total Rejected</div>
        <div class="dashboard-card-value" id="rejectedCount">0</div>
    </div>
</div>
<main>
    <div id="userTableBody"></div>
</main> 