/**
 * Modern Sidebar JavaScript
 * Handles sidebar toggle, submenu expansion, and responsive behavior
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get sidebar elements
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.modern-sidebar');
    const sidebarClose = document.querySelector('.sidebar-close');
    const overlay = document.querySelector('.sidebar-overlay');
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    const sidebarBody = document.querySelector('.sidebar-body');
    
    // Track touch events for better mobile experience
    let touchStartX = 0;
    let touchEndX = 0;
    let isSwiping = false;
    
    // Toggle sidebar when clicking the toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebar();
            
            // Add ripple effect on mobile
            if (window.innerWidth <= 767) {
                addRippleEffect(this, e);
            }
        });
    }
    
    // Close sidebar when clicking the close button
    if (sidebarClose) {
        sidebarClose.addEventListener('click', function(e) {
            e.preventDefault();
            closeSidebar();
            
            // Add ripple effect on mobile
            if (window.innerWidth <= 767) {
                addRippleEffect(this, e);
            }
        });
    }
    
    // Close sidebar when clicking the overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }
    
    // Close sidebar when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
            closeSidebar();
        }
    });
    
    // Add swipe to close functionality for mobile
    if (sidebar) {
        sidebar.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        sidebar.addEventListener('touchmove', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const swipeDistance = touchEndX - touchStartX;
            
            // Only apply transform if swiping left (to close)
            if (swipeDistance < 0 && Math.abs(swipeDistance) > 10) {
                isSwiping = true;
                // Limit the transform to avoid excessive movement
                const translateX = Math.max(swipeDistance, -150);
                this.style.transform = `translateX(${translateX}px)`;
                
                // Adjust overlay opacity based on swipe distance
                if (overlay) {
                    const opacity = 1 - (Math.min(Math.abs(translateX), 150) / 150) * 0.7;
                    overlay.style.opacity = opacity.toString();
                }
            }
        }, { passive: true });
        
        sidebar.addEventListener('touchend', function() {
            if (isSwiping) {
                const swipeDistance = touchEndX - touchStartX;
                
                // If swiped far enough to the left, close the sidebar
                if (swipeDistance < -70) {
                    closeSidebar();
                } else {
                    // Otherwise, snap back
                    this.style.transform = '';
                    if (overlay) {
                        overlay.style.opacity = '1';
                    }
                }
                
                isSwiping = false;
            }
        }, { passive: true });
    }
    
    // Toggle submenu when clicking the submenu toggle
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const parent = this.parentElement;
            const submenu = parent.querySelector('.submenu');
            const arrow = this.querySelector('i');
            
            // Toggle active class on parent
            parent.classList.toggle('active');
            
            // Toggle submenu height with smooth animation
            if (submenu) {
                if (parent.classList.contains('active')) {
                    submenu.style.height = submenu.scrollHeight + 'px';
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                    
                    // Add active class to submenu for styling
                    submenu.classList.add('active');
                } else {
                    submenu.style.height = '0';
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                    
                    // Remove active class after animation completes
                    setTimeout(() => {
                        submenu.classList.remove('active');
                    }, 300);
                }
            }
            
            // Add ripple effect on mobile
            if (window.innerWidth <= 767) {
                addRippleEffect(this, e);
            }
        });
    });
    
    // Add ripple effect to sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar-link, .submenu-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 767) {
                addRippleEffect(this, e);
            }
        });
    });
    
    // Function to add ripple effect
    function addRippleEffect(element, event) {
        const ripple = document.createElement('span');
        ripple.classList.add('ripple-effect');
        
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        
        ripple.style.width = ripple.style.height = size + 'px';
        
        // Position the ripple where clicked
        ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
        
        element.appendChild(ripple);
        
        // Remove ripple after animation
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Function to toggle sidebar
    function toggleSidebar() {
        if (sidebar) {
            sidebar.classList.toggle('active');
            sidebar.style.transform = ''; // Reset any transform from swiping
            
            if (overlay) {
                if (sidebar.classList.contains('active')) {
                    overlay.style.display = 'block';
                    overlay.style.opacity = '1';
                    document.body.style.overflow = 'hidden';
                    
                    // Animate sidebar entry
                    sidebar.classList.add('sidebar-animate-in');
                    setTimeout(() => {
                        sidebar.classList.remove('sidebar-animate-in');
                    }, 400);
                } else {
                    overlay.style.opacity = '0';
                    document.body.style.overflow = '';
                    
                    // Animate sidebar exit
                    sidebar.classList.add('sidebar-animate-out');
                    setTimeout(() => {
                        overlay.style.display = 'none';
                        sidebar.classList.remove('sidebar-animate-out');
                        
                        // Remove device info section with fade-out effect
                        removeDeviceInfoSection();
                    }, 300);
                }
            }
        }
    }
    
    // Function to close sidebar
    function closeSidebar() {
        if (sidebar && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            sidebar.style.transform = ''; // Reset any transform from swiping
            
            if (overlay) {
                overlay.style.opacity = '0';
                document.body.style.overflow = '';
                
                // Animate sidebar exit
                sidebar.classList.add('sidebar-animate-out');
                setTimeout(() => {
                    overlay.style.display = 'none';
                    sidebar.classList.remove('sidebar-animate-out');
                    
                    // Remove device info section with fade-out effect
                    removeDeviceInfoSection();
                }, 300);
            }
        }
    }
    
    // Function to remove device info section
    function removeDeviceInfoSection() {
        const deviceInfoSection = document.querySelector('.device-info-section');
        if (deviceInfoSection) {
            deviceInfoSection.classList.add('fade-out');
            setTimeout(() => {
                if (deviceInfoSection.parentNode) {
                    deviceInfoSection.parentNode.removeChild(deviceInfoSection);
                }
            }, 300);
        }
    }
    
    // Function to open sidebar
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.add('active');
            sidebar.style.transform = ''; // Reset any transform from swiping
            
            if (overlay) {
                overlay.style.display = 'block';
                overlay.style.opacity = '1';
                document.body.style.overflow = 'hidden';
                
                // Animate sidebar entry
                sidebar.classList.add('sidebar-animate-in');
                setTimeout(() => {
                    sidebar.classList.remove('sidebar-animate-in');
                }, 400);
            }
            
            // Scroll sidebar to top when opening
            if (sidebarBody) {
                sidebarBody.scrollTop = 0;
            }
        }
    }
    
    // Add keyframe animations if they don't exist
    if (!document.getElementById('sidebar-animations')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'sidebar-animations';
        styleSheet.textContent = `
            @keyframes ripple {
                0% { transform: scale(0); opacity: 1; }
                100% { transform: scale(2); opacity: 0; }
            }
            
            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.4);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
            
            .sidebar-animate-in {
                animation: sidebarIn 0.3s forwards;
            }
            
            .sidebar-animate-out {
                animation: sidebarOut 0.3s forwards;
            }
            
            @keyframes sidebarIn {
                0% { transform: translateX(-20px); opacity: 0.8; }
                100% { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes sidebarOut {
                0% { transform: translateX(0); opacity: 1; }
                100% { transform: translateX(-20px); opacity: 0.8; }
            }
        `;
        document.head.appendChild(styleSheet);
    }
    
    // Make functions globally available
    window.openSidebar = openSidebar;
    window.closeSidebar = closeSidebar;
    window.toggleSidebar = toggleSidebar;
});