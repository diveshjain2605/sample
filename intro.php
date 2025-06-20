<?php
include('session.php');
if (isset($_SESSION['user_name'])) {
    header('Location: welcomepage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Material Design CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>Welcome</title>
    <style>
        :root {
            --primary-dark: #0f0f23;
            --secondary-dark: #1a1a2e;
            --accent-purple: #6c5ce7;
            --accent-light: #a29bfe;
            --text-primary: #ffffff;
            --text-secondary: #b2b2b2;
            --glass-bg: rgba(108, 92, 231, 0.1);
            --glass-border: rgba(108, 92, 231, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 50%, #16213e 100%);
            height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: var(--accent-purple);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .particle.glow {
            box-shadow: 0 0 20px var(--accent-purple);
            opacity: 0.2;
        }

        .particle.large {
            animation: floatLarge 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.3; }
        }

        @keyframes floatLarge {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); opacity: 0.05; }
            25% { transform: translateY(-30px) rotate(90deg) scale(1.2); opacity: 0.15; }
            50% { transform: translateY(-60px) rotate(180deg) scale(1.5); opacity: 0.25; }
            75% { transform: translateY(-30px) rotate(270deg) scale(1.2); opacity: 0.15; }
        }

        /* Gradient orbs */
        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-light) 0%, transparent 70%);
            opacity: 0.1;
            animation: orbFloat 10s ease-in-out infinite;
            filter: blur(2px);
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -40px) scale(1.1); }
            66% { transform: translate(-20px, -20px) scale(0.9); }
        }

        .intro-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .carousel {
            flex: 1;
            background: transparent;
        }

        .carousel .carousel-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            background: transparent;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 90%;
            max-width: 650px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards;
        }

        @keyframes slideInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-light), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        .glass-card::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--accent-purple), var(--accent-light), var(--accent-purple));
            border-radius: 22px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .glass-card:hover::after {
            opacity: 0.3;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .intro-icon {
            font-size: 90px;
            color: var(--accent-light);
            margin-bottom: 25px;
            text-shadow: 0 0 20px rgba(108, 92, 231, 0.5);
            animation: iconPulse 3s ease-in-out infinite;
            position: relative;
            display: inline-block;
        }

        .intro-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            border: 2px solid var(--accent-light);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: iconRing 3s ease-in-out infinite;
            opacity: 0;
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
                text-shadow: 0 0 20px rgba(108, 92, 231, 0.5);
            }
            50% {
                transform: scale(1.1);
                text-shadow: 0 0 30px rgba(108, 92, 231, 0.8);
            }
        }

        @keyframes iconRing {
            0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
            50% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
            100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
        }

        .intro-title {
            color: var(--text-primary);
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .intro-text {
            color: var(--text-secondary);
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 35px;
            font-weight: 300;
        }

        .navigation-buttons {
            position: fixed;
            bottom: 40px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 25px;
            z-index: 10;
        }

        .btn-nav {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.3);
            border: none;
            transition: all 0.4s ease;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 15px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .btn-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-nav:hover::before {
            left: 100%;
        }

        .btn-nav:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.4);
        }

        .btn-skip {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-skip:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .indicators {
            position: fixed;
            bottom: 120px;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .indicators .indicator-item {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.4s ease;
            border: 2px solid transparent;
            position: relative;
            margin: 0 8px;
        }

        .indicators .indicator-item::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 1px solid var(--accent-light);
            border-radius: 50%;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s ease;
        }

        .indicators .indicator-item.active {
            background-color: var(--accent-light);
            border-color: var(--accent-purple);
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.5);
            transform: scale(1.2);
        }

        .indicators .indicator-item.active::before {
            opacity: 0.6;
            transform: scale(1);
        }

        .indicators .indicator-item:hover {
            background-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.1);
        }

        /* Additional animations */
        @keyframes slideInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Enhanced button effects */
        .btn-nav:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* Typing animation for text */
        .intro-text.typing {
            overflow: hidden;
            border-right: 2px solid var(--accent-light);
            white-space: nowrap;
            animation: typing 2s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: var(--accent-light); }
        }

        /* Slide-specific styling */
        .carousel-item:nth-child(1) .glass-card { animation-delay: 0.1s; }
        .carousel-item:nth-child(2) .glass-card { animation-delay: 0.2s; }
        .carousel-item:nth-child(3) .glass-card { animation-delay: 0.3s; }
        .carousel-item:nth-child(4) .glass-card { animation-delay: 0.4s; }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .glass-card {
                padding: 30px 20px;
                margin: 0 10px;
            }

            .intro-icon {
                font-size: 70px;
            }

            .intro-title {
                font-size: 24px;
            }

            .intro-text {
                font-size: 16px;
            }

            .navigation-buttons {
                flex-direction: column;
                gap: 15px;
                padding: 0 20px;
            }

            .btn-nav {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="particles" id="particles"></div>

    <!-- Gradient orbs -->
    <div class="gradient-orb" style="width: 200px; height: 200px; top: 10%; left: 5%; animation-delay: 0s;"></div>
    <div class="gradient-orb" style="width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 2s;"></div>
    <div class="gradient-orb" style="width: 100px; height: 100px; bottom: 20%; left: 15%; animation-delay: 4s;"></div>
    <div class="gradient-orb" style="width: 120px; height: 120px; top: 30%; right: 25%; animation-delay: 6s;"></div>

    <div class="intro-container">
        <div class="carousel carousel-slider">
            <!-- Slide 1 -->
            <div class="carousel-item" id="slide1">
                <div class="glass-card">
                    <i class="material-icons intro-icon">dashboard</i>
                    <h3 class="intro-title">Welcome to Warehouse Pro</h3>
                    <p class="intro-text">A comprehensive solution for managing your business operations, invoices, and customer information all in one place. Experience the future of business management.</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" id="slide2">
                <div class="glass-card">
                    <i class="material-icons intro-icon">receipt_long</i>
                    <h3 class="intro-title">Smart Invoice Management</h3>
                    <p class="intro-text">Create, manage, and track invoices with intelligent automation. Keep all your financial records organized and accessible with advanced analytics.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" id="slide3">
                <div class="glass-card">
                    <i class="material-icons intro-icon">groups</i>
                    <h3 class="intro-title">Advanced Customer Management</h3>
                    <p class="intro-text">Maintain detailed customer profiles with interaction history. Build stronger relationships with powerful CRM tools and insights.</p>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item" id="slide4">
                <div class="glass-card">
                    <i class="material-icons intro-icon">verified_user</i>
                    <h3 class="intro-title">Enterprise Security</h3>
                    <p class="intro-text">Your data is protected with military-grade encryption and security standards. Access your information securely from anywhere, anytime.</p>
                </div>
            </div>
        </div>
        
        <!-- Indicators -->
        <div class="indicators"></div>
        
        <!-- Navigation buttons -->
        <div class="navigation-buttons">
            <a href="#" class="btn waves-effect waves-light btn-nav btn-prev" style="display: none;">
                <i class="material-icons left">arrow_back</i> Previous
            </a>
            <a href="#" class="btn waves-effect waves-light btn-nav btn-next">
                Next <i class="material-icons right">arrow_forward</i>
            </a>
            <a href="index.php" class="btn waves-effect waves-light btn-nav btn-skip">
                Skip <i class="material-icons right">skip_next</i>
            </a>
        </div>
    </div>

    <!-- Material Design JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create animated particles
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = 60;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    let className = 'particle';

                    // Add special classes for variety
                    if (Math.random() > 0.8) className += ' glow';
                    if (Math.random() > 0.9) className += ' large';

                    particle.className = className;

                    // Random size between 2-10px
                    const size = Math.random() * 8 + 2;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';

                    // Random position
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';

                    // Random animation delay and duration
                    particle.style.animationDelay = Math.random() * 8 + 's';
                    particle.style.animationDuration = (Math.random() * 6 + 4) + 's';

                    particlesContainer.appendChild(particle);
                }
            }

            // Add mouse interaction
            function addMouseInteraction() {
                document.addEventListener('mousemove', (e) => {
                    const particles = document.querySelectorAll('.particle');
                    const mouseX = e.clientX / window.innerWidth;
                    const mouseY = e.clientY / window.innerHeight;

                    particles.forEach((particle, index) => {
                        if (index % 3 === 0) { // Only affect every 3rd particle for performance
                            const speed = 0.5;
                            const x = (mouseX - 0.5) * speed;
                            const y = (mouseY - 0.5) * speed;

                            particle.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
                        }
                    });
                });
            }

            createParticles();
            addMouseInteraction();

            // Initialize carousel with enhanced settings
            var carousel = document.querySelector('.carousel');
            var carouselInstance = M.Carousel.init(carousel, {
                fullWidth: true,
                indicators: true,
                duration: 400,
                dist: -100,
                shift: 0,
                padding: 0
            });

            // Add slide change animations
            function animateSlideContent() {
                const activeSlide = document.querySelector('.carousel-item.active .glass-card');
                if (activeSlide) {
                    activeSlide.style.animation = 'none';
                    setTimeout(() => {
                        activeSlide.style.animation = 'slideInUp 0.8s ease-out forwards';
                    }, 50);
                }
            }
            
            // Get navigation buttons
            var prevBtn = document.querySelector('.btn-prev');
            var nextBtn = document.querySelector('.btn-next');
            var skipBtn = document.querySelector('.btn-skip');
            
            // Current slide index
            var currentSlide = 0;
            var totalSlides = 4;
            
            // Enhanced slide change handling
            carousel.addEventListener('slide_changed', function(e) {
                currentSlide = carouselInstance.center;

                // Animate slide content
                animateSlideContent();

                // Button visibility and text changes
                if (currentSlide > 0) {
                    prevBtn.style.display = 'inline-block';
                    prevBtn.style.animation = 'slideInLeft 0.3s ease-out';
                } else {
                    prevBtn.style.display = 'none';
                }

                // Change next button to "Get Started" on last slide
                if (currentSlide === totalSlides - 1) {
                    nextBtn.innerHTML = 'Get Started <i class="material-icons right">rocket_launch</i>';
                    nextBtn.href = 'index.php';
                    nextBtn.style.background = 'linear-gradient(135deg, #e17055, #fdcb6e)';
                } else {
                    nextBtn.innerHTML = 'Next <i class="material-icons right">arrow_forward</i>';
                    nextBtn.href = '#';
                    nextBtn.style.background = 'linear-gradient(135deg, var(--accent-purple), var(--accent-light))';
                }

                // Add progress indication
                updateProgressBar();
            });

            // Progress bar function
            function updateProgressBar() {
                const progress = ((currentSlide + 1) / totalSlides) * 100;
                let progressBar = document.querySelector('.progress-bar');
                if (!progressBar) {
                    progressBar = document.createElement('div');
                    progressBar.className = 'progress-bar';
                    progressBar.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        height: 3px;
                        background: linear-gradient(90deg, var(--accent-purple), var(--accent-light));
                        transition: width 0.4s ease;
                        z-index: 1000;
                        box-shadow: 0 0 10px var(--accent-light);
                    `;
                    document.body.appendChild(progressBar);
                }
                progressBar.style.width = progress + '%';
            }
            
            // Previous button click
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                carouselInstance.prev();
            });
            
            // Next button click
            nextBtn.addEventListener('click', function(e) {
                if (currentSlide < totalSlides - 1) {
                    e.preventDefault();
                    carouselInstance.next();
                }
                // If on last slide, the link to index.php will work naturally
            });
            
            // Create indicators manually for better positioning
            var indicators = document.querySelector('.indicators');
            for (var i = 0; i < totalSlides; i++) {
                var indicator = document.createElement('a');
                indicator.classList.add('indicator-item');
                if (i === 0) indicator.classList.add('active');
                indicator.setAttribute('data-slide', i);
                indicators.appendChild(indicator);
                
                // Add click event to each indicator
                indicator.addEventListener('click', function(e) {
                    var slideIndex = parseInt(this.getAttribute('data-slide'));
                    carouselInstance.set(slideIndex);
                });
            }
            
            // Update indicators when slide changes
            carousel.addEventListener('slide_changed', function() {
                var allIndicators = indicators.querySelectorAll('.indicator-item');
                allIndicators.forEach(function(ind, index) {
                    if (index === carouselInstance.center) {
                        ind.classList.add('active');
                    } else {
                        ind.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>