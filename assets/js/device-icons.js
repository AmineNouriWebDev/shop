/**
 * Device Icons Functionality
 * Enhances the device icons with interactive features and sidebar integration
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all device icons
    const deviceIcons = document.querySelectorAll('.device-icon');
    let touchStartTime;
    let touchTimeout;
    
    // Add click/touch events to each device icon
    deviceIcons.forEach(icon => {
        // For mobile touch interactions
        icon.addEventListener('touchstart', function(e) {
            touchStartTime = new Date().getTime();
            // Add visual feedback
            this.classList.add('touch-active');
            
            // Clear any existing timeout
            if (touchTimeout) clearTimeout(touchTimeout);
            
            // Set timeout for long press
            touchTimeout = setTimeout(() => {
                // Vibrate if available (subtle feedback)
                if (navigator.vibrate) navigator.vibrate(50);
                
                // Scale effect for feedback
                this.style.transform = 'scale(0.95)';
            }, 100);
        });
        
        icon.addEventListener('touchend', function(e) {
            // Remove visual feedback
            this.classList.remove('touch-active');
            this.style.transform = '';
            
            // Clear timeout
            if (touchTimeout) clearTimeout(touchTimeout);
            
            // Calculate touch duration
            const touchDuration = new Date().getTime() - touchStartTime;
            
            // Only trigger if it was a tap (not a scroll)
            if (touchDuration < 500) {
                handleDeviceSelection(this);
            }
        });
        
        // For desktop clicks
        icon.addEventListener('click', function(e) {
            // Don't trigger on touch devices (already handled by touch events)
            if (e.pointerType !== 'touch') {
                handleDeviceSelection(this);
            }
        });
    });
    
    // Function to handle device selection
    function handleDeviceSelection(selectedIcon) {
        // Remove active class from all icons
        deviceIcons.forEach(i => i.classList.remove('active'));
        
        // Add active class to selected icon
        selectedIcon.classList.add('active');
        
        // Get device type from data attribute
        const deviceType = selectedIcon.getAttribute('data-device');
        
        // Show content for this device
        showDeviceContent(deviceType);
        
        // On mobile, also open sidebar with device info
        if (window.innerWidth <= 767) {
            openSidebarWithDeviceInfo(deviceType);
            
            // Add animation to highlight compatible cards
            animateCompatibleCards(deviceType);
        }
    }
    
    // Function to show device content
    function showDeviceContent(deviceType) {
        // You can implement device-specific content display here
        console.log(`Showing content for ${deviceType}`);
        
        // Example: Update subscription cards based on device compatibility
        const subscriptionCards = document.querySelectorAll('.card.text-center');
        
        subscriptionCards.forEach(card => {
            // Add a subtle highlight to cards that work well with the selected device
            card.classList.remove('device-highlight');
            
            // This is just an example - you would implement your own logic
            if ((deviceType === 'tv' && card.querySelector('h3').textContent.includes('Annuel')) ||
                (deviceType === 'screen') ||
                (deviceType === 'phone' && !card.querySelector('h3').textContent.includes('Annuel'))) {
                card.classList.add('device-highlight');
            }
        });
    }
    
    // Function to animate compatible cards
    function animateCompatibleCards(deviceType) {
        // Get all compatible cards
        const compatibleCards = document.querySelectorAll(`.card.text-center[data-${deviceType}="true"]`);
        
        // Add staggered animation
        compatibleCards.forEach((card, index) => {
            // First reset any existing animations
            card.style.animation = 'none';
            card.offsetHeight; // Trigger reflow
            
            // Apply new animation with delay based on index
            card.style.animation = `pulseHighlight 0.6s ${index * 0.1}s forwards`;
        });
    }
    
    // Function to open sidebar with device info
    function openSidebarWithDeviceInfo(deviceType) {
        // Get the sidebar elements
        const sidebar = document.getElementById('modernSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar && overlay) {
            // Show the sidebar and overlay
            sidebar.classList.add('active');
            overlay.style.display = 'block';
            
            // Create device info content based on device type
            let deviceTitle, deviceDescription, deviceCompatibility, deviceIcon;
            
            switch(deviceType) {
                case 'tv':
                    deviceTitle = "Télévision";
                    deviceDescription = "Profitez de nos contenus sur grand écran avec une qualité d'image exceptionnelle.";
                    deviceCompatibility = "Compatible avec les Smart TV, Apple TV, Android TV, et les box internet.";
                    deviceIcon = "<svg class='device-info-icon' width='40' height='40' viewBox='0 0 24 24'><path fill='#3dbcd3' d='M21,17H3V5H21M21,3H3A2,2 0 0,0 1,5V17A2,2 0 0,0 3,19H8V21H16V19H21A2,2 0 0,0 23,17V5A2,2 0 0,0 21,3Z'/></svg>";
                    break;
                case 'screen':
                    deviceTitle = "Ordinateur";
                    deviceDescription = "Accédez à tous nos contenus depuis votre ordinateur, où que vous soyez.";
                    deviceCompatibility = "Compatible avec tous les navigateurs modernes sur Windows, Mac et Linux.";
                    deviceIcon = "<svg class='device-info-icon' width='40' height='40' viewBox='0 0 24 24'><path fill='#3dbcd3' d='M21,16H3V4H21M21,2H3C1.89,2 1,2.89 1,4V16A2,2 0 0,0 3,18H10V20H8V22H16V20H14V18H21A2,2 0 0,0 23,16V4C23,2.89 22.1,2 21,2Z'/></svg>";
                    break;
                case 'phone':
                    deviceTitle = "Mobile";
                    deviceDescription = "Emportez vos contenus préférés partout avec vous sur votre smartphone ou tablette.";
                    deviceCompatibility = "Applications disponibles sur iOS et Android.";
                    deviceIcon = "<svg class='device-info-icon' width='40' height='40' viewBox='0 0 24 24'><path fill='#3dbcd3' d='M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3C19,1.89 18.1,1 17,1Z'/></svg>";
                    break;
            }
            
            // Create or update device info section in sidebar
            let deviceInfoSection = sidebar.querySelector('.device-info-section');
            
            if (!deviceInfoSection) {
                deviceInfoSection = document.createElement('div');
                deviceInfoSection.className = 'device-info-section';
                sidebar.querySelector('.sidebar-body').prepend(deviceInfoSection);
            }
            
            // Update content with enhanced styling
            deviceInfoSection.innerHTML = `
                <div class="device-info-header">
                    ${deviceIcon}
                    <h3>${deviceTitle}</h3>
                </div>
                <p class="device-description">${deviceDescription}</p>
                <div class="compatibility-box">
                    <h4>Compatibilité</h4>
                    <p>${deviceCompatibility}</p>
                </div>
                <div class="device-action-buttons">
                    <button class="btn btn-sm btn-primary device-action-btn">Voir les offres compatibles</button>
                </div>
            `;
            
            // Add click event to the action button
            const actionBtn = deviceInfoSection.querySelector('.device-action-btn');
            if (actionBtn) {
                actionBtn.addEventListener('click', function() {
                    // Scroll to compatible cards
                    const firstCompatibleCard = document.querySelector(`.card.text-center[data-${deviceType}="true"]`);
                    if (firstCompatibleCard) {
                        // Close sidebar first
                        closeSidebar();
                        
                        // Then scroll to card with smooth animation
                        setTimeout(() => {
                            firstCompatibleCard.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center' 
                            });
                        }, 400);
                    }
                });
            }
        }
    }
    
    // Add keyframe animation to document if it doesn't exist
    if (!document.getElementById('device-animations')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'device-animations';
        styleSheet.textContent = `
            @keyframes pulseHighlight {
                0% { transform: scale(1); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
                50% { transform: scale(1.03); box-shadow: 0 8px 20px rgba(61,188,211,0.3); }
                100% { transform: scale(1); box-shadow: 0 5px 15px rgba(61,188,211,0.2); }
            }
            
            .touch-active {
                background-color: rgba(61,188,211,0.1);
            }
            
            .device-info-header {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }
            
            .device-info-icon {
                margin-right: 15px;
            }
            
            .device-description {
                margin-bottom: 20px;
                line-height: 1.5;
            }
            
            .compatibility-box {
                background-color: #f8f9fa;
                border-radius: 10px;
                padding: 15px;
                margin-bottom: 20px;
            }
            
            .compatibility-box h4 {
                font-size: 16px;
                margin-bottom: 8px;
                color: #3dbcd3;
            }
            
            .device-action-buttons {
                display: flex;
                justify-content: center;
            }
            
            .device-action-btn {
                padding: 8px 16px;
                border-radius: 20px;
            }
        `;
        document.head.appendChild(styleSheet);
    }
});