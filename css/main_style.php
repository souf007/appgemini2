<?php
header("Content-type: text/css; charset=UTF-8");
session_start();
include("../config.php");
?>

/* --- Modern UI/UX Overhaul --- */

/* 1. General Resets & Font Import */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --primary-color: #3B82F6; /* Modern Blue */
    --primary-hover: #2563EB;
    --secondary-color: #6B7280; /* Gray */
    --text-color: #1F2937;
    --text-light: #6B7280;
    --background-color: #F9FAFB;
    --surface-color: #FFFFFF;
    --border-color: #E5E7EB;
    --danger-color: #EF4444;
    --success-color: #10B981;
    --warning-color: #F59E0B;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--background-color);
    color: var(--text-color);
    line-height: 1.6;
}

a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.2s ease-in-out;
}

a:hover {
    color: var(--primary-hover);
}

/* 2. Layout & Main Structure */
.lx-wrapper {
    display: flex;
    min-height: 100vh;
}

.lx-main-leftside {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100%;
    background: #1F2937; /* Dark sidebar */
    color: #F3F4F6;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease-in-out;
    z-index: 1000;
}

.lx-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 70px;
    padding: 10px;
    background: #111827; /* Darker logo area */
}

.lx-logo img {
    max-height: 45px;
    max-width: 160px;
}

.lx-main-menu-scroll {
    flex-grow: 1;
    overflow-y: auto;
}

.lx-main-menu ul li a {
    display: flex;
    align-items: center;
    padding: 14px 20px;
    color: #D1D5DB;
    font-weight: 500;
    border-left: 3px solid transparent;
    transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
}

.lx-main-menu ul li a:hover {
    background-color: #374151;
    color: var(--surface-color);
}

.lx-main-menu ul li a.active {
    background-color: var(--primary-color);
    color: var(--surface-color);
    border-left-color: #93C5FD;
}

.lx-main-menu ul li a i {
    margin-right: 15px;
    width: 20px;
    text-align: center;
    font-size: 1.1em;
}

.lx-main-content {
    margin-left: 240px;
    width: calc(100% - 240px);
    padding: 20px;
    transition: margin-left 0.3s ease-in-out;
}

.lx-header {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    height: 70px;
    background-color: var(--surface-color);
    border-bottom: 1px solid var(--border-color);
    padding: 0 20px;
    position: sticky;
    top: 0;
    z-index: 900;
}

/* 3. Modernized Form Elements */
.lx-textfield input[type='text'],
.lx-textfield input[type='number'],
.lx-textfield input[type='password'],
.lx-textfield input[type='email'],
.lx-textfield select,
.lx-textfield textarea {
    width: 100%;
    padding: 10px 12px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background-color: #F9FAFB;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.lx-textfield select {
     -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.lx-textfield input:focus,
.lx-textfield select:focus,
.lx-textfield textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.lx-submit a, .lx-submit button, a.lx-header-btn, .lx-price-filter {
    display: inline-block;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 600;
    background-color: var(--primary-color);
    color: #FFFFFF;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.2s ease-in-out, transform 0.1s ease;
}

.lx-submit a:hover, .lx-submit button:hover, a.lx-header-btn:hover, .lx-price-filter:hover {
    background-color: var(--primary-hover);
}

.lx-submit a:active, .lx-submit button:active, a.lx-header-btn:active, .lx-price-filter:active {
    transform: translateY(1px);
}

/* 4. Table Design */
.lx-page-content {
    background: var(--surface-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
}

.lx-table table {
    width: 100%;
    border-collapse: collapse;
}

.lx-table table tr.lx-first-tr td {
    padding: 12px 15px;
    font-weight: 600;
    color: var(--text-light);
    background-color: #F9FAFB;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.05em;
    border-bottom: 2px solid var(--border-color);
}

.lx-table table tr td {
    padding: 12px 15px;
    color: var(--text-color);
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.lx-table table tr:nth-child(2n) {
    background-color: #F9FAFB;
}

.lx-table table tr:last-child td {
    border-bottom: none;
}

.lx-table table tr:hover {
    background-color: #EFF6FF; /* Light blue on hover */
}

/* 5. Animations & Transitions */
.lx-edit-menu, .lx-account-settings, .lx-notifications {
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
}

.lx-edit-menu.active, .lx-account-settings.active, .lx-notifications.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* 6. Responsive Design */
@media(max-width: 1023px){
    .lx-main-leftside {
        transform: translateX(-240px);
    }
    .lx-main-leftside.active {
        transform: translateX(0);
    }
    .lx-main-content {
        margin-left: 0;
        width: 100%;
    }
    .lx-mobile-menu {
        display: block; /* Show hamburger menu */
    }
}

/* Login Page Specifics */
.lx-login-content {
    background: var(--surface-color);
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    min-width: 400px;
}

.lx-login .lx-submit a {
    display: block;
    width: 100%;
}

/* Legacy styles for compatibility if needed, but should be phased out */
<?php
if($settings['inventaire'] == "1"){
	?>
.lx-new,.lx-edit,.lx-delete{ display:none !important; }
.lx-end-inventaire,.lx-popup-inventaire{ display:inline-block !important; }
	<?php
}
// ... rest of the PHP-based dynamic CSS ...
?>
