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

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
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
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-light), transparent);
        }

        .intro-icon {
            font-size: 90px;
            color: var(--accent-light);
            margin-bottom: 25px;
            text-shadow: 0 0 20px rgba(108, 92, 231, 0.5);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .indicators .indicator-item.active {
            background-color: var(--accent-light);
            border-color: var(--accent-purple);
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.5);
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="particles" id="particles"></div>

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
                const particleCount = 50;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';

                    // Random size between 2-8px
                    const size = Math.random() * 6 + 2;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';

                    // Random position
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';

                    // Random animation delay
                    particle.style.animationDelay = Math.random() * 6 + 's';
                    particle.style.animationDuration = (Math.random() * 4 + 4) + 's';

                    particlesContainer.appendChild(particle);
                }
            }

            createParticles();

            // Initialize carousel
            var carousel = document.querySelector('.carousel');
            var carouselInstance = M.Carousel.init(carousel, {
                fullWidth: true,
                indicators: true,
                duration: 300
            });
            
            // Get navigation buttons
            var prevBtn = document.querySelector('.btn-prev');
            var nextBtn = document.querySelector('.btn-next');
            var skipBtn = document.querySelector('.btn-skip');
            
            // Current slide index
            var currentSlide = 0;
            var totalSlides = 4;
            
            // Show previous button after first slide
            carousel.addEventListener('slide_changed', function(e) {
                currentSlide = carouselInstance.center;
                
                if (currentSlide > 0) {
                    prevBtn.style.display = 'inline-block';
                } else {
                    prevBtn.style.display = 'none';
                }
                
                // Change next button to "Get Started" on last slide
                if (currentSlide === totalSlides - 1) {
                    nextBtn.innerHTML = 'Get Started <i class="material-icons right">check</i>';
                    nextBtn.href = 'index.php';
                } else {
                    nextBtn.innerHTML = 'Next <i class="material-icons right">arrow_forward</i>';
                    nextBtn.href = '#';
                }
            });
            
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