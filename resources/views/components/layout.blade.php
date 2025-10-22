<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'CodeQuest' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --purple: #9b59b6;
            --light: #f8f9fa;
            --dark: #1f2937;
            --text: #374151;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --shadow: rgba(0, 0, 0, 0.05);
            --shadow-hover: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: var(--text);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 8px var(--shadow);
            padding: 0.8rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #ffffff !important;
            letter-spacing: -0.5px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand .text-primary {
            color: #ffffff !important;
        }

        .navbar-brand .text-warning {
            color: #ffd700 !important;
        }

        /* Desktop Navigation */
        .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.6rem 1rem !important;
            margin: 0 0.2rem;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.9);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        /* Desktop nav: keep hover minimal - only underline (no box/overlay) */
        .nav-link:hover {
            color: #ffffff !important;
            background-color: transparent;
            box-shadow: none;
        }

        /* remove hover overlay on desktop nav links (mobile sidebar keeps its hover styling) */
        .nav-link:hover::before {
            content: '';
            background: transparent;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .nav-item.active .nav-link {
            color: #ffffff !important;
            /* keep active state minimal: only the underline (no background or shadow) */
            background-color: transparent;
            box-shadow: none;
        }

        .nav-item.active .nav-link::after {
            width: 80%;
        }

        /* Auth Buttons in Navbar */
        .btn-login-nav,
        .btn-register-nav {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.3rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login-nav:hover,
        .btn-register-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .btn-register-nav {
            background: rgba(255, 215, 0, 0.3);
        }

        .btn-register-nav:hover {
            background: rgba(255, 215, 0, 0.4);
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border: none;
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: #f0f4ff;
            color: #667eea;
            padding-left: 25px;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }

        .dropdown-divider {
            margin: 5px 0;
        }

        /* Auth Pages Shared Styles */
        .auth-container {
            max-width: 550px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 40px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .auth-header .auth-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 25px;
        }

        .auth-header h2 {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .auth-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 500;
        }

        .btn-auth {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: transform 0.2s;
            margin-top: 10px;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 5px;
        }

        .info-box i {
            color: #667eea;
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 0;
            margin-top: 0.5rem;
            min-width: 250px;
        }

        .dropdown-header {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0.5rem;
        }

        .dropdown-item {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #667eea;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
        }

        /* Profile Icon Color in Navbar */
        .nav-link .fa-user-circle {
            transition: transform 0.2s;
        }

        .nav-link:hover .fa-user-circle {
            transform: scale(1.1);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #6b7280;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 10px var(--shadow);
            z-index: 2000;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .mobile-sidebar.show {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Ensure CodeQuest spans keep their brand colors inside the mobile sidebar */
        .mobile-sidebar .sidebar-brand span:first-child {
            /* keep Code white in the mobile sidebar */
            color: #ffffff !important;
            text-shadow: none;
        }

        .mobile-sidebar .sidebar-brand span:last-child {
            color: var(--warning) !important;
            text-shadow: none;
        }

        .sidebar-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #ffffff;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .sidebar-close:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem;
        }

        .sidebar-menu li {
            margin: 0;
        }
        /* Sidebar links: include icons and use underline-only selection (no boxed overlay) */
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 1rem;
            color: rgba(255, 255, 255, 0.95);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s ease;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu a .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 1rem;
            color: rgba(255,255,255,0.95);
        }

        /* underline indicator (matches desktop nav) */
        .sidebar-menu a::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: rgba(255,255,255,0.95);
            transition: width 0.25s ease;
            border-radius: 2px;
        }

        .sidebar-menu a:hover {
            color: #ffffff;
            background-color: transparent;
            box-shadow: none;
        }

        .sidebar-menu a:hover::after {
            width: 60%;
        }

        .sidebar-menu a.active {
            color: #ffffff;
            background-color: transparent;
            box-shadow: none;
        }

        .sidebar-menu a.active::after {
            width: 60%;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #ffffff;
            cursor: pointer;
            padding: 0.25rem;
        }

        /* Container */
        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Card Styles */
        .card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 1px 3px var(--shadow);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            transform: scale(1.01);
        }

        .card:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
            z-index: 1;
        }

        .card:hover .card-body,
        .card:hover .card-header {
            position: relative;
            z-index: 2;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        /* Table Styles */
        .table {
            font-size: 0.85rem;
        }

        .table thead th {
            background: #f9fafb;
            color: var(--text);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
            padding: 0.9rem 0.75rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.08) !important;
            transform: translateX(2px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .table tbody tr:hover td {
            border-color: rgba(102, 126, 234, 0.2);
        }

        .table tbody td {
            padding: 0.9rem 0.75rem;
            vertical-align: middle;
        }

        /* Badge Styles - Unified modern tag design */
        .badge {
            padding: 0.3rem 0.65rem;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.7rem;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .badge:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        /* All badge variants use same gradient for consistency */
        .badge-primary,
        .badge-success,
        .badge-warning,
        .badge-danger,
        .badge-info,
        .badge-secondary,
        .badge-purple {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        /* Button Styles - Modern, classy colors */
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1.2rem;
            font-weight: 500;
            font-size: 0.85rem;
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        /* Hover: only scale, never change color */
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px var(--shadow-hover);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .btn-outline-secondary {
            border: 2px solid var(--secondary);
            color: var(--secondary);
            background: transparent;
        }

        .btn-outline-secondary:hover {
            border: 2px solid var(--secondary);
            color: var(--secondary);
            background: rgba(118, 75, 162, 0.05);
        }

        /* Alert Styles */
        .alert {
            border-radius: 6px;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 0.85rem;
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border-left: 3px solid var(--info);
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border-left: 3px solid var(--success);
        }

        /* Strong tag subtle highlight (non-intrusive) */
        strong {
            font-weight: 700;
            color: var(--dark);
            padding: 0.08rem 0.35rem;
            border-radius: 4px;
            background: linear-gradient(135deg, rgba(102,126,234,0.10) 0%, rgba(118,75,162,0.06) 100%);
        }

        /* Button size variants */
        .btn-lg {
            padding: 0.65rem 1.5rem;
            font-size: 0.95rem;
        }

        .btn-sm {
            padding: 0.35rem 0.85rem;
            font-size: 0.8rem;
        }

        /* Display Heading */
        .display-4 {
            font-weight: 700;
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .lead {
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* Footer */
        footer {
            background: #ffffff;
            border-top: 1px solid var(--border);
            margin-top: 3rem;
            box-shadow: 0 -1px 3px var(--shadow);
        }

        footer .text-center {
            color: var(--text-light);
            font-size: 0.85rem;
            padding: 1.5rem 1rem;
        }

        /* Footer link styling: black, bold, no underline on hover (scoped only to footer) */
        footer a {
            color: #000000 !important;
            font-weight: 700;
            text-decoration: none !important;
            transition: color 0.2s ease;
        }

        footer a:hover {
            /* change to blue on hover */
            color: var(--info) !important;
            text-decoration: none !important;
            box-shadow: none;
        }

        /* List Group */
        .list-group-item {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 6px;
            margin-bottom: 0.5rem;
            padding: 1rem 1.25rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .list-group-item:hover {
            background: rgba(147, 228, 211, 0.3);
            transform: translateX(4px);
            box-shadow: 0 2px 6px var(--shadow);
        }

        /* Scroll to Top */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px var(--shadow);
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px var(--shadow-hover);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .hamburger {
                display: block;
            }

            .navbar-collapse {
                display: none !important;
            }

            .display-4 {
                font-size: 1.5rem;
            }

            .lead {
                font-size: 0.85rem;
            }

            .card-body {
                padding: 1rem;
            }

            .container {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .navbar {
                padding: 0.8rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .display-4 {
                font-size: 1.3rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
        
        /* CTA buttons: same width on desktop, full-width on small screens */
        .cta-btn {
            display: inline-block;
            vertical-align: middle;
            text-align: center;
            align-items: center;
            justify-content: center;
            width: 240px; /* fixed desktop width so CTAs match */
        }

        @media (max-width: 991px) {
            .cta-btn {
                width: 220px;
            }
        }

        @media (max-width: 576px) {
            .cta-btn {
                display: block;
                width: 100%;
            }
        }

        /* Ensure footer is not fixed to viewport */
        footer {
            position: static !important;
            bottom: auto !important;
            width: 100%;
        }

        /* ============================================
           DIFFICULTY COLOR SYSTEM
           ============================================ */
        
        .difficulty-easy {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .difficulty-medium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .difficulty-hard {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        /* Light background versions for strong tags */
        .difficulty-bg-easy {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-weight: 600;
        }

        .difficulty-bg-medium {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.3);
            font-weight: 600;
        }

        .difficulty-bg-hard {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-weight: 600;
        }

        /* ============================================
           RATING-BASED COLOR SYSTEM (Codeforces Style)
           ============================================ */
        
        /* Rating Color Variables */
        :root {
            --rating-legendary: #ff0000;      /* 3000+ Legendary Grandmaster (Red) */
            --rating-grandmaster: #ff3333;    /* 2400-2999 International Grandmaster (Red) */
            --rating-master: #ff8c00;         /* 2100-2399 Master (Orange) */
            --rating-candidate: #aa00aa;      /* 1900-2099 Candidate Master (Purple/Violet) */
            --rating-expert: #0000ff;         /* 1600-1899 Expert (Blue) */
            --rating-specialist: #03a89e;     /* 1400-1599 Specialist (Cyan) */
            --rating-pupil: #008000;          /* 1200-1399 Pupil (Green) */
            --rating-newbie: #808080;         /* 0-1199 Newbie (Gray) */
        }

        /* Rating Badge Styles */
        .rating-legendary {
            background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
            color: white;
        }

        .rating-grandmaster {
            background: linear-gradient(135deg, #ff3333 0%, #ff0000 100%);
            color: white;
        }

        .rating-master {
            background: linear-gradient(135deg, #ff8c00 0%, #ff6600 100%);
            color: white;
        }

        .rating-candidate {
            background: linear-gradient(135deg, #aa00aa 0%, #8800aa 100%);
            color: white;
        }

        .rating-expert {
            background: linear-gradient(135deg, #0000ff 0%, #0000cc 100%);
            color: white;
        }

        .rating-specialist {
            background: linear-gradient(135deg, #03a89e 0%, #00897b 100%);
            color: white;
        }

        .rating-pupil {
            background: linear-gradient(135deg, #008000 0%, #006400 100%);
            color: white;
        }

        .rating-newbie {
            background: linear-gradient(135deg, #808080 0%, #696969 100%);
            color: white;
        }

        /* Rating Text Colors (for inline use without backgrounds) */
        .rating-text-legendary { color: #ff0000 !important; font-weight: 600; }
        .rating-text-grandmaster { color: #ff3333 !important; font-weight: 600; }
        .rating-text-master { color: #ff8c00 !important; font-weight: 600; }
        .rating-text-candidate { color: #aa00aa !important; font-weight: 600; }
        .rating-text-expert { color: #0000ff !important; font-weight: 600; }
        .rating-text-specialist { color: #03a89e !important; font-weight: 600; }
        .rating-text-pupil { color: #008000 !important; font-weight: 600; }
        .rating-text-newbie { color: #808080 !important; font-weight: 600; }

        /* Rating Circle Indicators (for leaderboard/lists) */
        .rating-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .rating-dot-legendary { background: #ff0000; }
        .rating-dot-grandmaster { background: #ff3333; }
        .rating-dot-master { background: #ff8c00; }
        .rating-dot-candidate { background: #aa00aa; }
        .rating-dot-expert { background: #0000ff; }
        .rating-dot-specialist { background: #03a89e; }
        .rating-dot-pupil { background: #008000; }
        .rating-dot-newbie { background: #808080; }

        /* Rating Light Background Versions (for strong tags in tables) */
        .rating-bg-legendary {
            background: rgba(255, 0, 0, 0.1);
            color: #cc0000;
            border: 1px solid rgba(255, 0, 0, 0.3);
            font-weight: 600;
        }

        .rating-bg-grandmaster {
            background: rgba(255, 51, 51, 0.1);
            color: #ff0000;
            border: 1px solid rgba(255, 51, 51, 0.3);
            font-weight: 600;
        }

        .rating-bg-master {
            background: rgba(255, 140, 0, 0.1);
            color: #ff6600;
            border: 1px solid rgba(255, 140, 0, 0.3);
            font-weight: 600;
        }

        .rating-bg-candidate {
            background: rgba(170, 0, 170, 0.1);
            color: #8800aa;
            border: 1px solid rgba(170, 0, 170, 0.3);
            font-weight: 600;
        }

        .rating-bg-expert {
            background: rgba(0, 0, 255, 0.1);
            color: #0000cc;
            border: 1px solid rgba(0, 0, 255, 0.3);
            font-weight: 600;
        }

        .rating-bg-specialist {
            background: rgba(3, 168, 158, 0.1);
            color: #00897b;
            border: 1px solid rgba(3, 168, 158, 0.3);
            font-weight: 600;
        }

        .rating-bg-pupil {
            background: rgba(0, 128, 0, 0.1);
            color: #006400;
            border: 1px solid rgba(0, 128, 0, 0.3);
            font-weight: 600;
        }

        .rating-bg-newbie {
            background: rgba(128, 128, 128, 0.1);
            color: #696969;
            border: 1px solid rgba(128, 128, 128, 0.3);
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Mobile Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <span style="color: var(--primary);">Code</span><span style="color: var(--warning);">Quest</span>
            </div>
            <button class="sidebar-close" id="sidebarClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                    <i class="menu-icon fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">
                    <i class="menu-icon fas fa-info-circle"></i>
                    <span>About</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">
                    <i class="menu-icon fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>
            
            @auth
                <li>
                    <a href="{{ route('problem.index') }}" class="{{ request()->is('problems*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-code"></i>
                        <span>Problems</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('leaderboard') }}" class="{{ request()->is('leaderboard') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-list-ol"></i>
                        <span>Leaderboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('editorials.index') }}" class="{{ request()->is('editorials*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-book"></i>
                        <span>Editorials</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags.index') }}" class="{{ request()->is('tags*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-tags"></i>
                        <span>Tags</span>
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(255,255,255,0.2); margin-top: 10px; padding-top: 10px;">
                    <a href="{{ route('account.profile') }}" class="{{ request()->is('account/profile') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('account.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: rgba(255,255,255,0.95); width: 100%; text-align: left; padding: 12px 20px; cursor: pointer; display: flex; align-items: center; font-size: 0.9rem;">
                            <i class="menu-icon fas fa-sign-out-alt" style="width: 24px; margin-right: 15px;"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            @else
                <li style="border-top: 1px solid rgba(255,255,255,0.2); margin-top: 10px; padding-top: 10px;">
                    <a href="{{ route('account.login') }}">
                        <i class="menu-icon fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.register') }}">
                        <i class="menu-icon fas fa-user-plus"></i>
                        <span>Register</span>
                    </a>
                </li>
            @endauth
        </ul>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">
            <span class="text-primary">Code</span><span class="text-warning">Quest</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item {{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
                
                @auth
                    <li class="nav-item {{ request()->is('problems*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('problem.index') }}">Problems</a>
                    </li>
                    <li class="nav-item {{ request()->is('leaderboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('leaderboard') }}">Leaderboard</a>
                    </li>
                    <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                    </li>
                    <li class="nav-item {{ request()->is('editorials*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('editorials.index') }}">Editorials</a>
                    </li>
                    <li class="nav-item {{ request()->is('tags*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
                    </li>
                @endauth
            </ul>
            
            <!-- Right Side: Auth Buttons or Profile -->
            <ul class="navbar-nav ms-auto">
                @auth
                    @php
                        $rating = (int) (Auth::user()->cf_max_rating ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    @endphp
                    
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle me-2" style="font-size: 1.8rem; color: {{ $ratingColor }};"></i>
                            <span style="color: white;">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <div class="dropdown-header d-flex align-items-center" style="border-bottom: 2px solid {{ $ratingColor }};">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('images/profile/' . Auth::user()->profile_picture) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="rounded-circle me-2" 
                                         style="width: 40px; height: 40px; object-fit: cover; border: 2px solid {{ $ratingColor }};">
                                @else
                                    <i class="fas fa-user-circle me-2" style="font-size: 2.5rem; color: {{ $ratingColor }};"></i>
                                @endif
                                <div>
                                    <strong style="color: {{ $ratingColor }};">{{ Auth::user()->name }}</strong><br>
                                    <small class="text-muted">{{ Auth::user()->cf_handle }} ({{ $rating }})</small>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('account.profile') }}">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('account.editProfile') }}">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('account.logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <!-- Guest User Buttons -->
                    <li class="nav-item">
                        <a class="nav-link btn-login-nav" href="{{ route('account.login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-register-nav" href="{{ route('account.register') }}">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Global Alert Messages -->
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <strong>Success:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <strong>Warning:</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session()->has('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle"></i> <strong>Info:</strong> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start mt-auto">
        <div class="text-center p-3">
            Copyright &copy; 2025 CodeQuest | Developed by <a href="https://github.com/kazirifatalmuin">Kazi Rifat Al Muin</a>. All rights reserved.
            <br>
            <a href="{{ route('admin.dashboard') }}" class="mt-2 d-inline-block">
                <i class="fas fa-user-shield"></i> Admin Panel
            </a>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile Sidebar Toggle
        const hamburger = document.getElementById('hamburger');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarClose = document.getElementById('sidebarClose');

        function openSidebar() {
            mobileSidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            mobileSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        if (hamburger) {
            hamburger.addEventListener('click', openSidebar);
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        // Scroll to Top Button
        const scrollTopBtn = document.getElementById('scrollTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });

        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>
