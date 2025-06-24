/**
 * UI Enhancements for Warehouse Pro
 * This file contains JavaScript fixes for better user interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== MATERIALIZE COMPONENT INITIALIZATION =====
    initializeMaterializeComponents();
    
    // ===== INPUT FIELD ENHANCEMENTS =====
    enhanceInputFields();
    
    // ===== BUTTON ENHANCEMENTS =====
    enhanceButtons();
    
    // ===== FORM VALIDATION ENHANCEMENTS =====
    enhanceFormValidation();
    
    // ===== TOOLTIP ENHANCEMENTS =====
    enhanceTooltips();
    
    // ===== TABLE ENHANCEMENTS =====
    enhanceTables();
    
    // ===== ANIMATION ENHANCEMENTS =====
    enhanceAnimations();
});

function initializeMaterializeComponents() {
    // Initialize all Materialize components with enhanced options
    
    // Dropdowns
    var dropdowns = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(dropdowns, {
        coverTrigger: false,
        constrainWidth: false,
        hover: false,
        alignment: 'left',
        closeOnClick: true,
        inDuration: 300,
        outDuration: 200
    });
    
    // Select elements
    var selects = document.querySelectorAll('select');
    M.FormSelect.init(selects, {
        classes: 'select-enhanced',
        dropdownOptions: {
            alignment: 'left',
            autoTrigger: true,
            constrainWidth: false,
            container: null,
            coverTrigger: true,
            closeOnClick: true,
            hover: false,
            inDuration: 150,
            outDuration: 250,
            onOpenStart: null,
            onOpenEnd: null,
            onCloseStart: null,
            onCloseEnd: null
        }
    });
    
    // Sidenav
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs, {
        edge: 'left',
        draggable: true,
        inDuration: 250,
        outDuration: 200,
        onOpenStart: null,
        onOpenEnd: null,
        onCloseStart: null,
        onCloseEnd: null,
        preventScrolling: true
    });
    
    // Tooltips
    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips, {
        enterDelay: 200,
        exitDelay: 0,
        html: false,
        margin: 5,
        inDuration: 250,
        outDuration: 200,
        position: 'bottom',
        transitionMovement: 10
    });
    
    // Modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals, {
        opacity: 0.5,
        inDuration: 250,
        outDuration: 250,
        preventScrolling: true,
        dismissible: true,
        startingTop: '4%',
        endingTop: '10%'
    });
    
    // Floating Action Button
    var fabs = document.querySelectorAll('.fixed-action-btn');
    M.FloatingActionButton.init(fabs, {
        direction: 'top',
        hoverEnabled: true,
        toolbarEnabled: false
    });
}

function enhanceInputFields() {
    // Fix input field visibility and interactions
    const inputs = document.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        // Ensure text is always visible
        input.style.color = 'var(--text-primary)';
        input.style.webkitTextFillColor = 'var(--text-primary)';
        
        // Add focus enhancement
        input.addEventListener('focus', function() {
            this.style.backgroundColor = 'rgba(255, 255, 255, 0.12)';
            this.style.borderBottomColor = 'var(--accent-light)';
            
            // Activate label
            const label = this.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                label.classList.add('active');
            }
        });
        
        // Add blur enhancement
        input.addEventListener('blur', function() {
            this.style.backgroundColor = 'rgba(255, 255, 255, 0.08)';
            
            // Deactivate label if empty
            if (!this.value) {
                const label = this.nextElementSibling;
                if (label && label.tagName === 'LABEL') {
                    label.classList.remove('active');
                }
            }
        });
        
        // Add input enhancement
        input.addEventListener('input', function() {
            this.style.color = 'var(--text-primary)';
            this.style.webkitTextFillColor = 'var(--text-primary)';
        });
    });
}

function enhanceButtons() {
    // Add enhanced button interactions
    const buttons = document.querySelectorAll('.btn, .btn-large, .btn-small, .btn-floating');
    
    buttons.forEach(button => {
        // Add ripple effect
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
        
        // Add hover enhancement
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

function enhanceFormValidation() {
    // Add real-time form validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('invalid')) {
                    validateField(this);
                }
            });
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    // Remove existing validation classes
    field.classList.remove('valid', 'invalid');
    
    if (field.hasAttribute('required') && !value) {
        isValid = false;
    } else if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
        }
    } else if (field.type === 'tel' && value) {
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(value.replace(/\D/g, ''))) {
            isValid = false;
        }
    }
    
    if (isValid) {
        field.classList.add('valid');
    } else {
        field.classList.add('invalid');
    }
    
    return isValid;
}

function enhanceTooltips() {
    // Add dynamic tooltip content
    const tooltippedElements = document.querySelectorAll('.tooltipped');
    
    tooltippedElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Update tooltip content if needed
            const dynamicContent = this.getAttribute('data-dynamic-tooltip');
            if (dynamicContent) {
                this.setAttribute('data-tooltip', dynamicContent);
                M.Tooltip.getInstance(this).options.html = dynamicContent;
            }
        });
    });
}

function enhanceTables() {
    // Add table enhancements
    const tables = document.querySelectorAll('table');
    
    tables.forEach(table => {
        // Add hover effects to rows
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(108, 92, 231, 0.1)';
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'scale(1)';
            });
        });
    });
}

function enhanceAnimations() {
    // Add scroll-triggered animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe cards and other elements
    const animatedElements = document.querySelectorAll('.card, .btn, .stats-card');
    animatedElements.forEach(el => {
        observer.observe(el);
    });
}

// ===== UTILITY FUNCTIONS =====

function showToast(message, classes = '') {
    M.toast({
        html: message,
        classes: classes,
        displayLength: 4000,
        inDuration: 300,
        outDuration: 375,
        activationPercent: 0.8
    });
}

function showNotification(title, message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <h6>${title}</h6>
            <p>${message}</p>
            <button class="btn-flat notification-close">
                <i class="material-icons">close</i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
    
    // Manual close
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
}

// ===== CSS ANIMATIONS =====
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .animate-in {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        padding: 20px;
        z-index: 10000;
        min-width: 300px;
        backdrop-filter: blur(20px);
        animation: slideInRight 0.3s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);
